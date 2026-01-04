<?php

namespace App\Jobs;

use App\Models\Cdr;
use App\Services\CallTariffService;
use App\Services\RevenueBatchDispatcher;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessCdrBatchJob implements ShouldQueue
{
    use Queueable;

    /**
     * Número máximo de tentativas
     */
    public $tries = 2;

    /**
     * Timeout em segundos (10 minutos para processar o lote)
     */
    public $timeout = 600;

    /**
     * Tempo de espera entre tentativas
     */
    public $backoff = [300]; // 5 minutos

    protected int $batchSize;
    protected ?int $carrierId;
    protected int $offset;
    protected ?array $specificCdrIds;

    /**
     * Create a new job instance.
     */
    public function __construct(int $batchSize = 1000, ?int $carrierId = null, int $offset = 0, ?array $specificCdrIds = null)
    {
        $this->batchSize = $batchSize;
        $this->carrierId = $carrierId;
        $this->offset = $offset;
        $this->specificCdrIds = $specificCdrIds;
    }

    /**
     * Execute the job.
     */
    public function handle(CallTariffService $tariffService, RevenueBatchDispatcher $batchDispatcher): void
    {
        $startTime = microtime(true);

        Log::info('Iniciando processamento de lote de CDRs', [
            'batch_size' => $this->batchSize,
            'carrier_id' => $this->carrierId,
            'offset' => $this->offset,
            'specific_ids' => $this->specificCdrIds ? count($this->specificCdrIds) : null,
        ]);

        // Busca CDRs pendentes para este lote
        if ($this->specificCdrIds) {
            // Se IDs específicos foram fornecidos, busca apenas esses CDRs
            $cdrs = Cdr::whereIn('id', $this->specificCdrIds)
                       ->where('status', 'Pendente')
                       ->get();
        } else {
            // Caso contrário, usa a abordagem antiga (offset/limit)
            $query = Cdr::where('status', 'Pendente');

            if ($this->carrierId) {
                $query->where('carrier_id', $this->carrierId);
            }

            $cdrs = $query->skip($this->offset)
                         ->limit($this->batchSize)
                         ->get();
        }

        if ($cdrs->isEmpty()) {
            Log::info('Nenhum CDR pendente encontrado para este lote');
            return;
        }

        // Processa o lote
        $stats = $this->processBatch($cdrs, $tariffService, $batchDispatcher);

        $duration = microtime(true) - $startTime;

        Log::info('Lote de CDRs processado com sucesso', [
            'batch_size' => $this->batchSize,
            'cdrs_processados' => $stats['total'],
            'sucesso' => $stats['success'],
            'erros' => $stats['errors'],
            'taxa_sucesso' => $stats['total'] > 0
                ? round(($stats['success'] / $stats['total']) * 100, 2) . '%'
                : '0%',
            'duracao_segundos' => round($duration, 2),
            'velocidade_cdrs_s' => $stats['total'] > 0
                ? round($stats['total'] / $duration, 0)
                : 0,
            'erros_por_tipo' => $stats['errors_by_type'],
        ]);
    }

    /**
     * Processa um lote de CDRs
     */
    private function processBatch($cdrs, CallTariffService $tariffService, RevenueBatchDispatcher $batchDispatcher): array
    {
        $updates = [
            'Tarifada' => [],
            'Tarifa_Nao_Encontrada' => [],
            'Dados_Invalidos' => [],
            'Erro_Tarifa' => [],
        ];

        $successCount = 0;
        $errorCount = 0;
        $errorsByType = [];

        foreach ($cdrs as $cdr) {
            try {
                // Calcula tarifa
                $result = $tariffService->calcularTarifa($cdr);

                // Adiciona ao batch de update
                $updates['Tarifada'][] = [
                    'id' => $cdr->id,
                    'customer_id' => $cdr->customer_id,
                    'calldate' => $cdr->calldate,
                    'valor_compra' => $result['compra'],
                    'valor_venda' => $result['venda'],
                    'tempo_cobrado' => $result['tempo_cobrado'],
                ];

                $successCount++;

            } catch (\App\Exceptions\Tariff\RateNotFoundException $e) {
                $updates['Tarifa_Nao_Encontrada'][] = ['id' => $cdr->id];
                $errorCount++;
                $errorsByType['Tarifa_Nao_Encontrada'] = ($errorsByType['Tarifa_Nao_Encontrada'] ?? 0) + 1;

            } catch (\App\Exceptions\Tariff\InvalidCdrDataException $e) {
                $updates['Dados_Invalidos'][] = ['id' => $cdr->id];
                $errorCount++;
                $errorsByType['Dados_Invalidos'] = ($errorsByType['Dados_Invalidos'] ?? 0) + 1;

            } catch (\Exception $e) {
                $updates['Erro_Tarifa'][] = ['id' => $cdr->id];
                $errorCount++;
                $errorsByType['Erro_Generico'] = ($errorsByType['Erro_Generico'] ?? 0) + 1;

                // Log apenas erros genéricos (inesperados)
                Log::warning('Erro ao processar CDR no lote', [
                    'cdr_id' => $cdr->id,
                    'erro' => $e->getMessage(),
                    'classe' => get_class($e),
                ]);
            }
        }

        // Aplica updates em bulk
        $this->applyBulkUpdates($updates);

        // Agrupa CDRs tarifados por cliente/período e adiciona ao batch de receita
        $tarifadosCount = count($updates['Tarifada']);
        if ($tarifadosCount > 0) {
            Log::info("Agrupando {$tarifadosCount} CDRs tarifados por período para batch de receita");

            // Agrupa por customer_id + mes + ano
            $gruposPorPeriodo = [];
            foreach ($updates['Tarifada'] as $data) {
                $calldate = Carbon::parse($data['calldate']);
                $key = "{$data['customer_id']}_{$calldate->month}_{$calldate->year}";

                if (!isset($gruposPorPeriodo[$key])) {
                    $gruposPorPeriodo[$key] = [
                        'customer_id' => $data['customer_id'],
                        'mes' => $calldate->month,
                        'ano' => $calldate->year,
                        'cdr_ids' => [],
                    ];
                }

                $gruposPorPeriodo[$key]['cdr_ids'][] = $data['id'];
            }

            // Processa cada grupo de uma vez
            foreach ($gruposPorPeriodo as $grupo) {
                $batchDispatcher->addCdrBatchToPeriod(
                    $grupo['cdr_ids'],
                    $grupo['customer_id'],
                    $grupo['mes'],
                    $grupo['ano']
                );
            }

            Log::info("CDRs agrupados e adicionados ao batch de receita", [
                'total_cdrs' => $tarifadosCount,
                'grupos_periodo' => count($gruposPorPeriodo),
            ]);
        }

        return [
            'total' => $cdrs->count(),
            'success' => $successCount,
            'errors' => $errorCount,
            'errors_by_type' => $errorsByType,
        ];
    }

    /**
     * Aplica atualizações em bulk no banco
     */
    private function applyBulkUpdates(array $updates): void
    {
        // Update CDRs tarifados
        if (!empty($updates['Tarifada'])) {
            foreach ($updates['Tarifada'] as $data) {
                DB::table('cdrs')
                    ->where('id', $data['id'])
                    ->update([
                        'status' => 'Tarifada',
                        'valor_compra' => $data['valor_compra'],
                        'valor_venda' => $data['valor_venda'],
                        'tempo_cobrado' => $data['tempo_cobrado'],
                        'updated_at' => now(),
                    ]);
            }
        }

        // Update CDRs com erro (apenas status)
        foreach (['Tarifa_Nao_Encontrada', 'Dados_Invalidos', 'Erro_Tarifa'] as $status) {
            if (!empty($updates[$status])) {
                $ids = array_column($updates[$status], 'id');
                DB::table('cdrs')
                    ->whereIn('id', $ids)
                    ->update([
                        'status' => $status,
                        'updated_at' => now(),
                    ]);
            }
        }
    }

    /**
     * Executado quando o job falha após todas as tentativas
     */
    public function failed(\Throwable $exception): void
    {
        Log::critical('Job de processamento de lote falhou após todas as tentativas', [
            'batch_size' => $this->batchSize,
            'carrier_id' => $this->carrierId,
            'offset' => $this->offset,
            'exception_class' => get_class($exception),
            'erro' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
