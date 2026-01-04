<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\RevenueSummary;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MonthlyRevenueSummaryService
{
    public $cobrada = 'N';

    protected $alertService;

    public function __construct(AlertService $alertService = null)
    {
        $this->alertService = $alertService ?? app(AlertService::class);
    }

    /**
     * @deprecated Este método está DEPRECADO e será removido em versão futura.
     *
     * PROBLEMAS:
     * 1. Race conditions - Múltiplos processos podem sobrescrever dados
     * 2. Performance ruim - 1 transaction por CDR
     * 3. Não usa distributed locks
     * 4. Alertas síncronos (bloqueiam processamento)
     *
     * SUBSTITUÍDO POR:
     * - ProcessMonthlyRevenueBatch (app/Jobs/ProcessMonthlyRevenueBatch.php)
     * - RevenueBatchDispatcher (app/Services/RevenueBatchDispatcher.php)
     * - Use ReprocessRevenueBatchCommand para reprocessamento
     *
     * @see \App\Jobs\ProcessMonthlyRevenueBatch
     * @see \App\Services\RevenueBatchDispatcher
     * @see \App\Console\Commands\ReprocessRevenueBatchCommand
     */
    public function atualizarResumo($cdr)
    {
        Log::warning('MonthlyRevenueSummaryService::atualizarResumo DEPRECADO - Use ProcessMonthlyRevenueBatch', [
            'cdr_id' => $cdr->id ?? 'unknown',
            'customer_id' => $cdr->customer_id ?? 'unknown',
            'trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3),
        ]);

        return DB::transaction(function () use ($cdr) {
            // Encontra ou cria o resumo para o mês e ano do CDR
            $resumo = RevenueSummary::firstOrCreate(
                [
                    'customer_id' => $cdr->customer_id,
                    'mes' => Carbon::parse($cdr->calldate)->month,
                    'ano' => Carbon::parse($cdr->calldate)->year,
                ],
                [
                    'franquia_minutos' => ($cdr->customer->franquia_minutos * 60),
                    'valor_plano' => $cdr->customer->valor_plano,
                    'minutos_usados' => 0,
                    'custo_total' => $cdr->customer->valor_plano,
                ]
            );

            // Atualiza o resumo com base no tipo de chamada
            switch ($cdr->tarifa) {
                case 'Fixo':
                    $this->calcularFixo($cdr, $resumo);
                    break;
                case 'Movel':
                    $this->calcularMovel($cdr, $resumo);
                    break;
                case 'Internacional':
                    $this->calcularInternacional($cdr, $resumo);
                    break;
                default:
                    // Opcional: logar ou tratar chamadas de tarifa não reconhecidas
                    break;
            }

            $resumo->save();

            // Verifica se deve criar alerta de franquia
            try {
                $this->alertService->checkFranchiseUsage(
                    $cdr->customer_id,
                    Carbon::parse($cdr->calldate)->month,
                    Carbon::parse($cdr->calldate)->year
                );
            } catch (\Exception $e) {
                Log::error('Erro ao verificar alertas de franquia', [
                    'customer_id' => $cdr->customer_id,
                    'error' => $e->getMessage()
                ]);
            }

            return $this->cobrada;
        });
    }

    protected function calcularFixo($cdr, $resumo)
    {
        $this->atualizarResumoPorTipo($cdr, $resumo, 'fixo');
    }

    protected function calcularMovel($cdr, $resumo)
    {
        $this->atualizarResumoPorTipo($cdr, $resumo, 'movel');
    }

    protected function calcularInternacional($cdr, $resumo)
    {
        $this->cobrada = 'S';
        $resumo->minutos_excedentes_internacional += $cdr->tempo_cobrado;
        $resumo->minutos_excedentes += $cdr->tempo_cobrado;
        $resumo->excedente_internacional += $cdr->valor_venda;
        $resumo->custo_excedente += $cdr->valor_venda;
        $resumo->custo_total += $cdr->valor_venda;
        $resumo->minutos_total += $cdr->tempo_cobrado;
    }

    protected function atualizarResumoPorTipo($cdr, $resumo, $tipo)
    {
        $tempoCobrado = $cdr->tempo_cobrado;
        $valorVenda = $cdr->valor_venda;

        // Verifica se ainda tem franquia disponível
        $minutosDisponiveis = $resumo->franquia_minutos - $resumo->minutos_usados;

        if ($minutosDisponiveis > 0) {
            // Ainda tem franquia disponível
            if ($tempoCobrado <= $minutosDisponiveis) {
                // A chamada cabe toda na franquia
                $resumo->{'minutos_'.$tipo} += $tempoCobrado;
                $resumo->minutos_usados += $tempoCobrado;
                $this->cobrada = 'N';
            } else {
                // Parte da chamada usa franquia, parte é excedente
                $minutosNaFranquia = $minutosDisponiveis;
                $minutosExcedentes = $tempoCobrado - $minutosNaFranquia;
                
                // Calcula valor proporcional do excedente
                $valorExcedente = ($valorVenda / $tempoCobrado) * $minutosExcedentes;

                // Adiciona os minutos na franquia
                $resumo->{'minutos_'.$tipo} += $minutosNaFranquia;
                $resumo->minutos_usados += $minutosNaFranquia;
                
                // Adiciona os minutos excedentes
                $resumo->{'minutos_excedentes_'.$tipo} += $minutosExcedentes;
                $resumo->minutos_excedentes += $minutosExcedentes;
                $resumo->{'excedente_'.$tipo} += $valorExcedente;
                $resumo->custo_excedente += $valorExcedente;
                $resumo->custo_total += $valorExcedente;
                
                $this->cobrada = 'S';
            }
        } else {
            // Franquia já foi totalmente utilizada - tudo é excedente
            $this->cobrada = 'S';
            $resumo->{'minutos_excedentes_'.$tipo} += $tempoCobrado;
            $resumo->minutos_excedentes += $tempoCobrado;
            $resumo->{'excedente_'.$tipo} += $valorVenda;
            $resumo->custo_excedente += $valorVenda;
            $resumo->custo_total += $valorVenda;
        }

        $resumo->minutos_total += $tempoCobrado;
    }

    /**
     * Calcula e atualiza a receita de produtos recorrentes para todos os clientes
     * Deve ser executado após processar todas as chamadas do mês
     *
     * OTIMIZADO: Reduz 501 queries (100 clientes) para 3 queries usando batch processing
     */
    public function atualizarReceitaProdutos($mes, $ano)
    {
        // OTIMIZADO: Usa batch processing para evitar N+1 queries

        // 1. Busca todos clientes ativos (1 query)
        $clientes = Customer::where('ativo', true)
            ->select('id')
            ->get();

        if ($clientes->isEmpty()) {
            Log::info('Nenhum cliente ativo encontrado para atualizar produtos', [
                'mes' => $mes,
                'ano' => $ano,
            ]);
            return;
        }

        $clienteIds = $clientes->pluck('id')->toArray();

        // 2. Busca clientes com revendas para aplicar markup (1 query)
        $clientesComRevenda = Customer::whereIn('id', $clienteIds)
            ->with('reseller')
            ->get()
            ->keyBy('id');

        // 3. Busca produtos por cliente (1 query)
        $produtosPorCliente = DB::table('customer_products')
            ->whereIn('customer_id', $clienteIds)
            ->where('ativo', true)
            ->select('customer_id', 'valor_venda_unitario', 'quantidade', 'valor_custo_unitario')
            ->get()
            ->groupBy('customer_id');

        $priceCalculationService = app(PriceCalculationService::class);

        // 4. Processa e atualiza em chunks
        collect($clienteIds)->chunk(100)->each(function ($chunkIds) use ($mes, $ano, $produtosPorCliente, $clientesComRevenda, $priceCalculationService) {
            foreach ($chunkIds as $clienteId) {
                $produtos = $produtosPorCliente->get($clienteId);

                if (!$produtos || $produtos->isEmpty()) {
                    // Cliente não tem produtos ativos
                    continue;
                }

                $customer = $clientesComRevenda->get($clienteId);

                // Calcula totais aplicando markup se necessário
                $totalReceita = $produtos->sum(function($produto) use ($customer, $priceCalculationService) {
                    $valorBase = $produto->valor_venda_unitario * $produto->quantidade;

                    // Aplica markup se cliente tiver revenda
                    if ($customer && $customer->hasReseller()) {
                        return $priceCalculationService->calculatePrice(
                            $valorBase,
                            $customer,
                            'produtos'
                        );
                    }

                    return $valorBase;
                });

                $totalCusto = $produtos->sum(function($produto) {
                    return $produto->valor_custo_unitario * $produto->quantidade;
                });

                // Update ou insert atômico
                DB::table('revenue_summaries')
                    ->updateOrInsert(
                        [
                            'customer_id' => $clienteId,
                            'mes' => $mes,
                            'ano' => $ano,
                        ],
                        [
                            'produtos_receita' => $totalReceita,
                            'produtos_custo' => $totalCusto,
                            'receita_total' => DB::raw("COALESCE(custo_total, 0) + " . $totalReceita),
                            'updated_at' => now(),
                        ]
                    );
            }
        });

        Log::info('Receita de produtos atualizada com sucesso', [
            'mes' => $mes,
            'ano' => $ano,
            'clientes_processados' => count($clienteIds),
            'clientes_com_produtos' => $produtosPorCliente->count(),
        ]);
    }

    /**
     * Calcula e atualiza a receita de produtos para um cliente específico
     */
    public function atualizarReceitaProdutosCliente($customerId, $mes, $ano)
    {
        return DB::transaction(function () use ($customerId, $mes, $ano) {
            // Busca ou cria o resumo do cliente
            $resumo = RevenueSummary::firstOrCreate(
                [
                    'customer_id' => $customerId,
                    'mes' => $mes,
                    'ano' => $ano,
                ],
                [
                    'franquia_minutos' => 0,
                    'valor_plano' => 0,
                    'minutos_usados' => 0,
                    'custo_total' => 0,
                ]
            );

            // Busca customer com relacionamento de revenda
            $customer = Customer::with('reseller')->find($customerId);

            // Calcula receita e custo dos produtos ativos
            $produtos = \App\Models\CustomerProduct::where('customer_id', $customerId)
                ->where('ativo', true)
                ->get();

            $priceCalculationService = app(PriceCalculationService::class);

            $produtosReceita = $produtos->sum(function($produto) use ($customer, $priceCalculationService) {
                $valorBase = $produto->valor_venda_unitario * $produto->quantidade;

                // Aplica markup se cliente tiver revenda
                if ($customer && $customer->hasReseller()) {
                    return $priceCalculationService->calculatePrice(
                        $valorBase,
                        $customer,
                        'produtos'
                    );
                }

                return $valorBase;
            });

            $produtosCusto = $produtos->sum(function($produto) {
                return $produto->valor_custo_unitario * $produto->quantidade;
            });

            // Atualiza o resumo
            $resumo->produtos_receita = $produtosReceita;
            $resumo->produtos_custo = $produtosCusto;
            $resumo->receita_total = $resumo->custo_total + $produtosReceita;
            $resumo->save();

            return $resumo;
        });
    }
}
