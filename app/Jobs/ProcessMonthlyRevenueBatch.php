<?php

namespace App\Jobs;

use App\Events\MonthlyRevenueUpdated;
use App\Models\Cdr;
use App\Models\RevenueSummary;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessMonthlyRevenueBatch implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public $tries = 3;
    public $timeout = 300; // 5 minutos

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly int $customerId,
        private readonly int $mes,
        private readonly int $ano,
        private readonly array $cdrIds
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $lockKey = "revenue_batch:{$this->customerId}:{$this->mes}:{$this->ano}";
        $lock = Cache::lock($lockKey, 300);

        if (!$lock->get()) {
            Log::warning('Revenue batch já em processamento', [
                'customer_id' => $this->customerId,
                'mes' => $this->mes,
                'ano' => $this->ano,
                'cdr_count' => count($this->cdrIds),
            ]);

            // Recoloca na fila para tentar depois
            $this->release(30);
            return;
        }

        try {
            DB::transaction(function () {
                $this->processRevenueBatch();
            });

            Log::info('Revenue batch completed successfully', [
                'customer_id' => $this->customerId,
                'mes' => $this->mes,
                'ano' => $this->ano,
                'cdrs_processed' => count($this->cdrIds),
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao processar batch de revenue', [
                'customer_id' => $this->customerId,
                'mes' => $this->mes,
                'ano' => $this->ano,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e; // Relança para retry
        } finally {
            $lock->release();
        }
    }

    /**
     * Processa o batch de CDRs e atualiza o resumo mensal
     */
    private function processRevenueBatch(): void
    {
        $startTime = microtime(true);

        // Carrega todos os CDRs do lote com o customer
        // Apenas CDRs que ainda não foram processados em nenhuma fatura
        $cdrs = Cdr::with('customer')
            ->whereIn('id', $this->cdrIds)
            ->where('status', 'Tarifada')
            ->whereNull('revenue_summary_id')
            ->get();

        if ($cdrs->isEmpty()) {
            Log::warning('Nenhum CDR tarifado encontrado no batch', [
                'customer_id' => $this->customerId,
                'cdr_ids' => $this->cdrIds,
            ]);
            return;
        }

        $customer = $cdrs->first()->customer;

        if (!$customer) {
            Log::error('Customer não encontrado para batch', [
                'customer_id' => $this->customerId,
            ]);
            return;
        }

        // Busca ou cria resumo com lock pessimista
        $resumo = RevenueSummary::lockForUpdate()
            ->firstOrCreate(
                [
                    'customer_id' => $this->customerId,
                    'mes' => $this->mes,
                    'ano' => $this->ano,
                ],
                [
                    'franquia_minutos' => ($customer->franquia_minutos * 60),
                    'valor_plano' => $customer->valor_plano,
                    'minutos_usados' => 0,
                    'custo_total' => $customer->valor_plano,
                ]
            );

        // Calcula estatísticas do batch
        $stats = $this->calculateBatchStats($cdrs, $resumo);

        // Atualiza resumo atomicamente
        $this->updateResumoAtomically($resumo, $stats);

        // Marca CDRs como processados com flag de cobrança
        $this->markCdrsAsProcessed($cdrs, $stats, $resumo->id);

        $duration = round((microtime(true) - $startTime) * 1000, 2);

        Log::info('Revenue batch processed', [
            'customer_id' => $this->customerId,
            'mes' => $this->mes,
            'ano' => $this->ano,
            'cdrs_processados' => count($this->cdrIds),
            'duration_ms' => $duration,
            'stats' => $stats,
        ]);

        // Dispara evento para alertas
        event(new MonthlyRevenueUpdated($this->customerId, $this->mes, $this->ano));
    }

    /**
     * Calcula as estatísticas agregadas do batch
     */
    private function calculateBatchStats($cdrs, $resumo): array
    {
        $stats = [
            'minutos_fixo' => 0,
            'minutos_movel' => 0,
            'minutos_internacional' => 0,
            'minutos_excedentes_fixo' => 0,
            'minutos_excedentes_movel' => 0,
            'minutos_excedentes_internacional' => 0,
            'excedente_fixo' => 0.0,
            'excedente_movel' => 0.0,
            'excedente_internacional' => 0.0,
            'minutos_total' => 0,
            'custo_excedente' => 0.0,
            'custo_total' => 0.0,
            'cdr_cobrancas' => [], // [cdr_id => 'S' ou 'N']
        ];

        $minutosDisponiveis = $resumo->franquia_minutos - $resumo->minutos_usados;

        foreach ($cdrs as $cdr) {
            // Validação de dados
            if (!$cdr->tempo_cobrado || $cdr->tempo_cobrado < 0) {
                Log::warning('CDR com tempo_cobrado inválido', [
                    'cdr_id' => $cdr->id,
                    'tempo_cobrado' => $cdr->tempo_cobrado,
                ]);
                continue;
            }

            $tempoCobrado = $cdr->tempo_cobrado;
            $valorVenda = $cdr->valor_venda ?? 0;

            if ($cdr->tarifa === 'Internacional') {
                // Internacional sempre é cobrado
                $stats['minutos_excedentes_internacional'] += $tempoCobrado;
                $stats['excedente_internacional'] += $valorVenda;
                $stats['custo_excedente'] += $valorVenda;
                $stats['custo_total'] += $valorVenda;
                $stats['cdr_cobrancas'][$cdr->id] = 'S';
            } else {
                $tipo = strtolower($cdr->tarifa); // 'fixo' ou 'movel'

                if ($minutosDisponiveis > 0) {
                    if ($tempoCobrado <= $minutosDisponiveis) {
                        // Cabe totalmente na franquia
                        $stats["minutos_{$tipo}"] += $tempoCobrado;
                        $minutosDisponiveis -= $tempoCobrado;
                        $stats['cdr_cobrancas'][$cdr->id] = 'N';
                    } else {
                        // Parte franquia, parte excedente
                        $minutosNaFranquia = $minutosDisponiveis;
                        $minutosExcedentes = $tempoCobrado - $minutosNaFranquia;

                        // Calcula valor proporcional do excedente
                        $valorExcedente = $tempoCobrado > 0
                            ? ($valorVenda / $tempoCobrado) * $minutosExcedentes
                            : 0;

                        $stats["minutos_{$tipo}"] += $minutosNaFranquia;
                        $stats["minutos_excedentes_{$tipo}"] += $minutosExcedentes;
                        $stats["excedente_{$tipo}"] += $valorExcedente;
                        $stats['custo_excedente'] += $valorExcedente;
                        $stats['custo_total'] += $valorExcedente;

                        $minutosDisponiveis = 0;
                        $stats['cdr_cobrancas'][$cdr->id] = 'S';
                    }
                } else {
                    // Franquia esgotada - tudo é excedente
                    $stats["minutos_excedentes_{$tipo}"] += $tempoCobrado;
                    $stats["excedente_{$tipo}"] += $valorVenda;
                    $stats['custo_excedente'] += $valorVenda;
                    $stats['custo_total'] += $valorVenda;
                    $stats['cdr_cobrancas'][$cdr->id] = 'S';
                }
            }

            $stats['minutos_total'] += $tempoCobrado;
        }

        return $stats;
    }

    /**
     * Atualiza o resumo usando incrementos atômicos
     */
    private function updateResumoAtomically($resumo, array $stats): void
    {
        // Update atômico usando DB::raw para evitar race conditions
        DB::table('revenue_summaries')
            ->where('id', $resumo->id)
            ->update([
                'minutos_fixo' => DB::raw("minutos_fixo + {$stats['minutos_fixo']}"),
                'minutos_movel' => DB::raw("minutos_movel + {$stats['minutos_movel']}"),
                'minutos_internacional' => DB::raw("minutos_internacional + {$stats['minutos_internacional']}"),
                'minutos_excedentes_fixo' => DB::raw("minutos_excedentes_fixo + {$stats['minutos_excedentes_fixo']}"),
                'minutos_excedentes_movel' => DB::raw("minutos_excedentes_movel + {$stats['minutos_excedentes_movel']}"),
                'minutos_excedentes_internacional' => DB::raw("minutos_excedentes_internacional + {$stats['minutos_excedentes_internacional']}"),
                'excedente_fixo' => DB::raw("excedente_fixo + {$stats['excedente_fixo']}"),
                'excedente_movel' => DB::raw("excedente_movel + {$stats['excedente_movel']}"),
                'excedente_internacional' => DB::raw("excedente_internacional + {$stats['excedente_internacional']}"),
                'minutos_total' => DB::raw("minutos_total + {$stats['minutos_total']}"),
                'minutos_usados' => DB::raw("minutos_usados + {$stats['minutos_fixo']} + {$stats['minutos_movel']}"),
                'minutos_excedentes' => DB::raw("minutos_excedentes + {$stats['minutos_excedentes_fixo']} + {$stats['minutos_excedentes_movel']} + {$stats['minutos_excedentes_internacional']}"),
                'custo_excedente' => DB::raw("custo_excedente + {$stats['custo_excedente']}"),
                'custo_total' => DB::raw("custo_total + {$stats['custo_total']}"),
                'updated_at' => now(),
            ]);
    }

    /**
     * Marca os CDRs como processados com a flag de cobrança
     */
    private function markCdrsAsProcessed($cdrs, array $stats, int $revenueSummaryId): void
    {
        foreach ($cdrs as $cdr) {
            $cobrada = $stats['cdr_cobrancas'][$cdr->id] ?? 'N';

            $cdr->update([
                'cobrada' => $cobrada,
                'revenue_summary_id' => $revenueSummaryId,
            ]);
        }
    }

    /**
     * Determine the time at which the job should timeout.
     */
    public function retryUntil(): \DateTime
    {
        return now()->addMinutes(30);
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Revenue batch failed permanently', [
            'customer_id' => $this->customerId,
            'mes' => $this->mes,
            'ano' => $this->ano,
            'cdr_ids' => $this->cdrIds,
            'error' => $exception->getMessage(),
        ]);
    }
}
