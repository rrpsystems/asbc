<?php

namespace App\Livewire\Maintenance;

use App\Jobs\ProcessCdrBatchJob;
use App\Models\Cdr;
use App\Models\CarrierUsage;
use App\Models\Rate;
use App\Models\RevenueSummary;
use App\Services\CarrierCostAllocationService;
use App\Services\RateCacheService;
use App\Services\RevenueBatchDispatcher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Livewire\Attributes\Layout;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

#[Layout('layouts.app')]
class Index extends Component
{
    use Interactions;

    public $stats = [];
    public $queueStats = [];
    public $cacheStats = [];
    public $batchStats = [];
    public $revenueStats = [];
    public $carrierStats = [];
    public $reprocessModal = false;
    public $reprocessLimit = 100;
    public $reprocessStatus = '';
    public $specificCdrId = null;
    public $reprocessDataInicial = null;
    public $reprocessDataFinal = null;
    public $reprocessCarrierId = null;
    public $reprocessCustomerId = null;

    // Revenue Reprocess
    public $revenueReprocessModal = false;
    public $revenueReprocessMes = null;
    public $revenueReprocessAno = null;
    public $revenueReprocessCustomerId = null;
    public $revenueReprocessBatchSize = 100;
    public $revenueReprocessModeLote = false; // Novo: modo lote
    public $revenueReprocessNumMeses = 12; // Novo: quantos meses processar

    // Fechar Faturas
    public $fecharFaturasModal = false;
    public $fecharFaturasMes = null;
    public $fecharFaturasAno = null;
    public $fecharFaturasPreview = [];
    public $fecharFaturasModeLote = false; // Novo: modo lote
    public $fecharFaturasNumMeses = 12; // Novo: quantos meses processar

    // Reabrir Faturas
    public $reabrirFaturasModal = false;
    public $reabrirFaturasMes = null;
    public $reabrirFaturasAno = null;
    public $reabrirFaturasTipo = 'ambos';
    public $reabrirFaturasMotivo = '';
    public $reabrirFaturasModeLote = false; // Novo: modo lote
    public $reabrirFaturasNumMeses = 12; // Novo: quantos meses processar

    // Gerar Relatórios de Operadora
    public $gerarRelatorioOperadoraModal = false;
    public $gerarRelatorioMes = null;
    public $gerarRelatorioAno = null;
    public $gerarRelatorioCarrierId = null;

    public function mount()
    {
        $this->loadStats();

        // Inicializa com mês/ano atual
        $this->revenueReprocessMes = now()->month;
        $this->revenueReprocessAno = now()->year;

        // Inicializa fechar/reabrir com mês anterior
        $mesAnterior = now()->subMonth();
        $this->fecharFaturasMes = $mesAnterior->month;
        $this->fecharFaturasAno = $mesAnterior->year;
        $this->reabrirFaturasMes = $mesAnterior->month;
        $this->reabrirFaturasAno = $mesAnterior->year;

        // Inicializa relatórios de operadora com mês atual
        $this->gerarRelatorioMes = now()->month;
        $this->gerarRelatorioAno = now()->year;
    }

    public function loadStats()
    {
        // Estatísticas de CDRs
        $this->stats = [
            'total_cdrs' => Cdr::count(),
            'tarifados' => Cdr::where('status', 'Tarifada')->count(),
            'pendentes' => Cdr::where('status', 'Pendente')->count(),
            'erro_tarifa' => Cdr::where('status', 'Erro_Tarifa')->count(),
            'tarifa_nao_encontrada' => Cdr::where('status', 'Tarifa_Nao_Encontrada')->count(),
            'dados_invalidos' => Cdr::where('status', 'Dados_Invalidos')->count(),
            'erro_permanente' => Cdr::where('status', 'Erro_Permanente')->count(),
            'ultimo_tarifado' => Cdr::where('status', 'Tarifada')->latest('updated_at')->first(),
            'ultimo_cdr' => Cdr::latest('id')->first(),
            'total_rates' => Rate::where('ativo', true)->count(),
        ];

        // Estatísticas da Fila
        try {
            $this->queueStats = [
                'jobs_pendentes' => Redis::llen('queues:default') ?? 0,
                'jobs_falhados' => DB::table('failed_jobs')->count(),
            ];
        } catch (\Exception $e) {
            $this->queueStats = [
                'jobs_pendentes' => 'N/A',
                'jobs_falhados' => 'N/A',
            ];
        }

        // Estatísticas do Cache
        $this->cacheStats = [
            'driver' => config('cache.default'),
        ];

        // Estatísticas de Batches de Revenue
        try {
            $dispatcher = app(RevenueBatchDispatcher::class);
            $this->batchStats = $dispatcher->getPendingBatchesStats();
        } catch (\Exception $e) {
            $this->batchStats = [
                'total_batches' => 0,
                'total_cdrs' => 0,
                'batches' => [],
            ];
            Log::error('Erro ao carregar stats de batches', [
                'error' => $e->getMessage(),
            ]);
        }

        // Estatísticas de Resumos Mensais
        try {
            $this->revenueStats = [
                'total_resumos' => RevenueSummary::count(),
                'mes_atual' => RevenueSummary::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
                'ultimo_resumo' => RevenueSummary::latest('updated_at')->first(),
            ];
        } catch (\Exception $e) {
            $this->revenueStats = [
                'total_resumos' => 0,
                'mes_atual' => 0,
                'ultimo_resumo' => null,
            ];
        }

        // Estatísticas de Relatórios de Operadora
        try {
            $ultimoRelatorio = CarrierUsage::latest('updated_at')->first();

            $this->carrierStats = [
                'total_relatorios' => CarrierUsage::count(),
                'mes_atual' => CarrierUsage::where('mes', now()->month)
                    ->where('ano', now()->year)
                    ->count(),
                'ultimo_relatorio' => $ultimoRelatorio,
                'ultimo_mes' => $ultimoRelatorio ? "{$ultimoRelatorio->mes}/{$ultimoRelatorio->ano}" : 'N/A',
            ];
        } catch (\Exception $e) {
            $this->carrierStats = [
                'total_relatorios' => 0,
                'mes_atual' => 0,
                'ultimo_relatorio' => null,
                'ultimo_mes' => 'N/A',
            ];
            Log::error('Erro ao carregar stats de operadora', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function tarifar()
    {
        try {
            $totalPendentes = Cdr::where('status', '!=', 'Tarifada')->count();

            if ($totalPendentes === 0) {
                $this->toast()->warning('Nenhum CDR pendente para tarifar')->send();
                return;
            }

            // Limita a 1000 CDRs por vez
            $totalToProcess = min($totalPendentes, 1000);

            // Marca como Pendente antes de despachar
            Cdr::where('status', '!=', 'Tarifada')
                ->limit($totalToProcess)
                ->update(['status' => 'Pendente']);

            // Despacha jobs em lote
            $batchSize = 1000;
            $numBatches = (int) ceil($totalToProcess / $batchSize);

            for ($i = 0; $i < $numBatches; $i++) {
                $offset = $i * $batchSize;
                $currentBatchSize = min($batchSize, $totalToProcess - $offset);

                ProcessCdrBatchJob::dispatch($currentBatchSize, null, $offset);
            }

            $this->toast()->success("✅ {$totalToProcess} CDRs marcados para tarifação! {$numBatches} job(s) de lote despachado(s).")->send();
            $this->loadStats();

            Log::info('Tarifação manual disparada via interface (lote)', [
                'user_id' => auth()->id(),
                'cdrs_marcados' => $totalToProcess,
                'jobs_batch_despachados' => $numBatches,
                'batch_size' => $batchSize,
            ]);

        } catch (\Exception $e) {
            $this->toast()->error("Erro ao despachar jobs: {$e->getMessage()}")->send();
            Log::error('Erro na tarifação manual', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
        }
    }

    public function openReprocessModal()
    {
        $this->reprocessModal = true;
        $this->reprocessLimit = 100;
        $this->reprocessStatus = '';
        $this->specificCdrId = null;
        $this->reprocessDataInicial = null;
        $this->reprocessDataFinal = null;
        $this->reprocessCarrierId = null;
        $this->reprocessCustomerId = null;
    }

    public function reprocessar()
    {
        try {
            $query = Cdr::query();
            $isRetariffing = false;

            // Se tem CDR específico - usa job em batch com apenas 1 CDR
            if ($this->specificCdrId) {
                $cdr = Cdr::find($this->specificCdrId);

                if (!$cdr) {
                    $this->toast()->error("CDR #{$this->specificCdrId} não encontrado")->send();
                    return;
                }

                // Se está retarifando CDR já tarifado
                if ($cdr->status === 'Tarifada') {
                    $cdr->update([
                        'status' => 'Pendente',
                        'valor_venda' => 0,
                        'valor_compra' => 0,
                        'tempo_cobrado' => 0,
                        'revenue_summary_id' => null,
                        'cobrada' => null,
                    ]);
                } else {
                    $cdr->status = 'Pendente';
                    $cdr->save();
                }

                // Usa batch job com apenas 1 CDR
                ProcessCdrBatchJob::dispatch(1, null, 0, [$cdr->id]);
                $this->toast()->success("✅ CDR #{$this->specificCdrId} marcado como Pendente e job despachado!")->send();
                $this->reprocessModal = false;
                $this->loadStats();
                return;
            }

            // Filtro por status
            if ($this->reprocessStatus) {
                $query->where('status', $this->reprocessStatus);

                // Detecta se está retarifando
                if ($this->reprocessStatus === 'Tarifada') {
                    $isRetariffing = true;
                }
            } else {
                $query->where('status', '!=', 'Tarifada');
            }

            // Filtro por período
            if ($this->reprocessDataInicial && $this->reprocessDataFinal) {
                $query->whereBetween('calldate', [
                    $this->reprocessDataInicial . ' 00:00:00',
                    $this->reprocessDataFinal . ' 23:59:59'
                ]);
            }

            // Filtro por carrier
            if ($this->reprocessCarrierId) {
                $query->where('carrier_id', $this->reprocessCarrierId);
            }

            // Filtro por customer
            if ($this->reprocessCustomerId) {
                $query->where('customer_id', $this->reprocessCustomerId);
            }

            $totalToProcess = $query->count();

            if ($totalToProcess === 0) {
                $this->toast()->warning('Nenhum CDR encontrado com os filtros selecionados')->send();
                return;
            }

            // Log para debug
            Log::info('Reprocessamento de CDRs iniciado', [
                'data_inicial' => $this->reprocessDataInicial,
                'data_final' => $this->reprocessDataFinal,
                'status' => $this->reprocessStatus,
                'carrier_id' => $this->reprocessCarrierId,
                'customer_id' => $this->reprocessCustomerId,
                'total_encontrado' => $totalToProcess,
                'limite_configurado' => $this->reprocessLimit,
                'is_retariffing' => $isRetariffing,
            ]);

            // NOVO COMPORTAMENTO:
            // - Se há filtro de data: processa TODOS os CDRs do período (ignora limite)
            // - Se NÃO há filtro de data: aplica o limite como segurança
            if (!$this->reprocessDataInicial && !$this->reprocessDataFinal) {
                // Sem filtro de data: aplica o limite de segurança
                $totalToProcess = min($totalToProcess, $this->reprocessLimit);
                Log::info('Sem filtro de data - aplicando limite de segurança', [
                    'total_limitado' => $totalToProcess,
                ]);
            } else {
                // Com filtro de data: processa TODOS os CDRs do período
                Log::info('Filtro de data ativo - processando TODOS os CDRs do período', [
                    'total_periodo' => $totalToProcess,
                ]);
            }

            // PRIMEIRO: Coleta IDs dos CDRs que serão processados
            $cdrIds = $query->limit($totalToProcess)->pluck('id')->toArray();

            Log::info('CDRs coletados para reprocessamento', [
                'ids_coletados' => count($cdrIds),
                'primeiro_id' => $cdrIds[0] ?? null,
                'ultimo_id' => end($cdrIds) ?: null,
            ]);

            // Marca todos como Pendente ANTES de despachar jobs
            // IMPORTANTE: PostgreSQL tem limite de 65.535 parâmetros por query
            // Então dividimos em chunks de 30.000 para ficar seguro
            $updateChunkSize = 30000;

            if ($isRetariffing) {
                // RETARIFAÇÃO: Reseta todos os campos de tarifação
                foreach (array_chunk($cdrIds, $updateChunkSize) as $chunk) {
                    Cdr::whereIn('id', $chunk)->update([
                        'status' => 'Pendente',
                        'valor_venda' => 0,
                        'valor_compra' => 0,
                        'tempo_cobrado' => 0,
                        'revenue_summary_id' => null,
                        'cobrada' => null,
                    ]);
                }
            } else {
                // REPROCESSAMENTO NORMAL: Apenas muda status
                foreach (array_chunk($cdrIds, $updateChunkSize) as $chunk) {
                    Cdr::whereIn('id', $chunk)->update(['status' => 'Pendente']);
                }
            }

            // NOVO: Despacha jobs em lote com IDs específicos
            $batchSize = 1000; // CDRs por job
            $batches = array_chunk($cdrIds, $batchSize);
            $numBatches = count($batches);

            foreach ($batches as $batchIds) {
                ProcessCdrBatchJob::dispatch(count($batchIds), null, 0, $batchIds);
            }

            // Mensagem de sucesso mais informativa
            $periodoInfo = ($this->reprocessDataInicial && $this->reprocessDataFinal)
                ? " (período: {$this->reprocessDataInicial} a {$this->reprocessDataFinal})"
                : "";

            $actionMessage = $isRetariffing
                ? "✅ {$totalToProcess} CDRs resetados e marcados para RETARIFAÇÃO{$periodoInfo}! {$numBatches} job(s) de lote despachados."
                : "✅ {$totalToProcess} CDRs marcados como Pendente{$periodoInfo} e {$numBatches} job(s) de lote despachados!";

            $this->toast()->success($actionMessage)->send();
            $this->reprocessModal = false;
            $this->loadStats();

            Log::info($isRetariffing ? 'Retarifação manual via interface (lote)' : 'Reprocessamento manual via interface (lote)', [
                'user_id' => auth()->id(),
                'status_filtro' => $this->reprocessStatus,
                'limite' => $this->reprocessLimit,
                'periodo' => $this->reprocessDataInicial && $this->reprocessDataFinal
                    ? "{$this->reprocessDataInicial} até {$this->reprocessDataFinal}"
                    : null,
                'carrier_id' => $this->reprocessCarrierId,
                'customer_id' => $this->reprocessCustomerId,
                'cdrs_marcados_pendente' => $totalToProcess,
                'jobs_batch_despachados' => $numBatches,
                'batch_size' => $batchSize,
                'is_retariffing' => $isRetariffing,
            ]);

        } catch (\Exception $e) {
            $this->toast()->error("Erro ao reprocessar: {$e->getMessage()}")->send();
            $this->reprocessModal = false;
            Log::error('Erro no reprocessamento manual', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
        }
    }

    public function limparCacheRates()
    {
        try {
            $cacheService = app(RateCacheService::class);
            $cacheService->invalidateAll();

            $this->toast()->success('✅ Cache de rates limpo com sucesso!')->send();
            $this->loadStats();

            Log::info('Cache de rates limpo via interface', [
                'user_id' => auth()->id()
            ]);

        } catch (\Exception $e) {
            $this->toast()->error("Erro ao limpar cache: {$e->getMessage()}")->send();
        }
    }

    public function limparJobsFalhados()
    {
        try {
            Artisan::call('queue:flush');

            $this->toast()->success('✅ Jobs falhados removidos com sucesso!')->send();
            $this->loadStats();

            Log::info('Jobs falhados removidos via interface', [
                'user_id' => auth()->id()
            ]);

        } catch (\Exception $e) {
            $this->toast()->error("Erro ao limpar jobs: {$e->getMessage()}")->send();
        }
    }

    public function retryJobsFalhados()
    {
        try {
            Artisan::call('queue:retry', ['id' => 'all']);

            $this->toast()->success('✅ Jobs falhados reenfileirados!')->send();
            $this->loadStats();

            Log::info('Retry de jobs falhados via interface', [
                'user_id' => auth()->id()
            ]);

        } catch (\Exception $e) {
            $this->toast()->error("Erro ao reprocessar jobs: {$e->getMessage()}")->send();
        }
    }

    public function flushBatches()
    {
        try {
            Artisan::call('revenue:flush-batches');

            $this->toast()->success('✅ Batches de revenue processados com sucesso!')->send();
            $this->loadStats();

            Log::info('Flush de batches de revenue via interface', [
                'user_id' => auth()->id()
            ]);

        } catch (\Exception $e) {
            $this->toast()->error("Erro ao processar batches: {$e->getMessage()}")->send();
            Log::error('Erro ao flush de batches via interface', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
        }
    }

    /**
     * Gera relatórios de operadora para o mês atual
     * @deprecated Use openGerarRelatorioOperadoraModal() para versão com seleção de mês/ano
     */
    public function gerarRelatoriosOperadora()
    {
        try {
            $mes = now()->month;
            $ano = now()->year;

            $service = new CarrierCostAllocationService();
            $total = $service->persistirResumoMensal($mes, $ano);

            $this->toast()->success("✅ Relatórios de {$total} operadora(s) gerados para {$mes}/{$ano}!")->send();
            $this->loadStats();

            Log::info('Relatórios de operadora gerados via interface', [
                'user_id' => auth()->id(),
                'mes' => $mes,
                'ano' => $ano,
                'total_operadoras' => $total,
            ]);

        } catch (\Exception $e) {
            $this->toast()->error("Erro ao gerar relatórios: {$e->getMessage()}")->send();
            Log::error('Erro ao gerar relatórios via interface', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
        }
    }

    /**
     * Abre modal para gerar relatórios de operadora com mês/ano customizado
     */
    public function openGerarRelatorioOperadoraModal()
    {
        $this->gerarRelatorioMes = now()->month;
        $this->gerarRelatorioAno = now()->year;
        $this->gerarRelatorioCarrierId = null;
        $this->gerarRelatorioOperadoraModal = true;
    }

    /**
     * Gera relatórios de operadora para mês/ano específico
     */
    public function gerarRelatoriosOperadoraCustomizado()
    {
        // Validações
        if (!$this->gerarRelatorioMes || $this->gerarRelatorioMes < 1 || $this->gerarRelatorioMes > 12) {
            $this->toast()->error('Mês inválido. Use valores entre 1 e 12.')->send();
            return;
        }

        if (!$this->gerarRelatorioAno || $this->gerarRelatorioAno < 2020 || $this->gerarRelatorioAno > 2100) {
            $this->toast()->error('Ano inválido. Use valores entre 2020 e 2100.')->send();
            return;
        }

        try {
            $service = new CarrierCostAllocationService();

            // Se carrier_id especificado, processa apenas esse
            if ($this->gerarRelatorioCarrierId) {
                $total = $service->persistirResumoMensal(
                    $this->gerarRelatorioMes,
                    $this->gerarRelatorioAno,
                    $this->gerarRelatorioCarrierId
                );
            } else {
                $total = $service->persistirResumoMensal(
                    $this->gerarRelatorioMes,
                    $this->gerarRelatorioAno
                );
            }

            $this->toast()->success("✅ Relatórios de {$total} operadora(s) gerados para {$this->gerarRelatorioMes}/{$this->gerarRelatorioAno}!")->send();
            $this->loadStats();
            $this->gerarRelatorioOperadoraModal = false;

            Log::info('Relatórios de operadora gerados via interface (customizado)', [
                'user_id' => auth()->id(),
                'mes' => $this->gerarRelatorioMes,
                'ano' => $this->gerarRelatorioAno,
                'carrier_id' => $this->gerarRelatorioCarrierId,
                'total_operadoras' => $total,
            ]);

        } catch (\Exception $e) {
            $this->toast()->error("Erro ao gerar relatórios: {$e->getMessage()}")->send();
            Log::error('Erro ao gerar relatórios customizados via interface', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'mes' => $this->gerarRelatorioMes,
                'ano' => $this->gerarRelatorioAno,
                'carrier_id' => $this->gerarRelatorioCarrierId,
            ]);
        }
    }

    /**
     * Processa relatórios do mês anterior (automático)
     */
    public function processarRelatoriosMesAnterior()
    {
        try {
            $mes = now()->subMonth()->month;
            $ano = now()->subMonth()->year;

            $service = new CarrierCostAllocationService();
            $total = $service->persistirResumoMensal($mes, $ano);

            $this->toast()->success("✅ Relatórios de {$total} operadora(s) processados para {$mes}/{$ano}!")->send();
            $this->loadStats();

            Log::info('Relatórios do mês anterior processados via interface', [
                'user_id' => auth()->id(),
                'mes' => $mes,
                'ano' => $ano,
                'total_operadoras' => $total,
            ]);

        } catch (\Exception $e) {
            $this->toast()->error("Erro ao processar relatórios: {$e->getMessage()}")->send();
            Log::error('Erro ao processar relatórios do mês anterior via interface', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
        }
    }

    /**
     * Abre modal de reprocessamento de receitas
     */
    public function openRevenueReprocessModal()
    {
        $this->revenueReprocessModal = true;
        $this->revenueReprocessMes = now()->month;
        $this->revenueReprocessAno = now()->year;
        $this->revenueReprocessCustomerId = null;
        $this->revenueReprocessBatchSize = 100;
        $this->revenueReprocessModeLote = false;
        $this->revenueReprocessNumMeses = 12;
    }

    /**
     * Reprocessa receitas mensais usando batch processing (ou em lote)
     */
    public function reprocessarReceitas()
    {
        try {
            // Validações
            if (!$this->revenueReprocessMes || $this->revenueReprocessMes < 1 || $this->revenueReprocessMes > 12) {
                $this->toast()->error('Mês inválido. Use valores entre 1 e 12.')->send();
                return;
            }

            if (!$this->revenueReprocessAno || $this->revenueReprocessAno < 2020 || $this->revenueReprocessAno > 2100) {
                $this->toast()->error('Ano inválido.')->send();
                return;
            }

            $totalFaturas = 0;
            $totalJobs = 0;

            if ($this->revenueReprocessModeLote) {
                // Modo lote: processar múltiplos meses
                $periodos = $this->calcularPeriodosReprocessamento($this->revenueReprocessNumMeses);

                foreach ($periodos as $periodo) {
                    // Monta comando para cada período
                    $params = [
                        'mes' => $periodo['mes'],
                        'ano' => $periodo['ano'],
                        '--batch-size' => $this->revenueReprocessBatchSize,
                        '--force' => true,
                    ];

                    if ($this->revenueReprocessCustomerId) {
                        $params['--customer_id'] = $this->revenueReprocessCustomerId;
                    }

                    // Executa comando e captura output IMEDIATAMENTE
                    $exitCode = Artisan::call('revenue:reprocess', $params);
                    $output = Artisan::output();

                    // Extrai estatísticas do output deste período específico
                    if (preg_match('/Faturas processadas\s+│\s+(\d+)/', $output, $faturas)) {
                        $totalFaturas += (int)$faturas[1];
                    }

                    if (preg_match('/Jobs despachados\s+│\s+(\d+)/', $output, $jobs)) {
                        $totalJobs += (int)$jobs[1];
                    }
                }

                $this->toast()->success("✅ Reprocessamento em lote iniciado! {$totalFaturas} fatura(s), {$totalJobs} job(s) despachados em " . count($periodos) . " mês(es).")->send();

                Log::info('Reprocessamento de receitas em lote via interface', [
                    'user_id' => auth()->id(),
                    'num_meses' => $this->revenueReprocessNumMeses,
                    'periodos' => $periodos,
                    'customer_id' => $this->revenueReprocessCustomerId,
                    'batch_size' => $this->revenueReprocessBatchSize,
                    'total_faturas_processadas' => $totalFaturas,
                    'total_jobs_despachados' => $totalJobs,
                ]);
            } else {
                // Modo único mês
                $params = [
                    'mes' => $this->revenueReprocessMes,
                    'ano' => $this->revenueReprocessAno,
                    '--batch-size' => $this->revenueReprocessBatchSize,
                    '--force' => true,
                ];

                if ($this->revenueReprocessCustomerId) {
                    $params['--customer_id'] = $this->revenueReprocessCustomerId;
                }

                // Executa comando
                Artisan::call('revenue:reprocess', $params);
                $output = Artisan::output();

                // Extrai estatísticas
                preg_match('/Faturas processadas\s+│\s+(\d+)/', $output, $faturas);
                preg_match('/Jobs despachados\s+│\s+(\d+)/', $output, $jobs);

                $faturasCount = $faturas[1] ?? 'N/A';
                $jobsCount = $jobs[1] ?? 'N/A';

                $this->toast()->success("✅ Reprocessamento iniciado! {$faturasCount} fatura(s), {$jobsCount} job(s) despachados.")->send();

                Log::info('Reprocessamento de receitas via interface', [
                    'user_id' => auth()->id(),
                    'mes' => $this->revenueReprocessMes,
                    'ano' => $this->revenueReprocessAno,
                    'customer_id' => $this->revenueReprocessCustomerId,
                    'batch_size' => $this->revenueReprocessBatchSize,
                    'faturas_processadas' => $faturasCount,
                    'jobs_despachados' => $jobsCount,
                ]);
            }

            $this->revenueReprocessModal = false;
            $this->loadStats();

        } catch (\Exception $e) {
            $this->toast()->error("Erro ao reprocessar receitas: {$e->getMessage()}")->send();
            $this->revenueReprocessModal = false;
            Log::error('Erro no reprocessamento de receitas via interface', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'mes' => $this->revenueReprocessMes,
                'ano' => $this->revenueReprocessAno,
            ]);
        }
    }

    /**
     * Calcula períodos para reprocessamento em lote
     * Processa N meses CONSECUTIVOS a partir do mês/ano selecionado
     */
    private function calcularPeriodosReprocessamento(int $numMeses): array
    {
        $periodos = [];
        $dataBase = Carbon::createFromDate($this->revenueReprocessAno, $this->revenueReprocessMes, 1);

        for ($i = 0; $i < $numMeses; $i++) {
            $data = $dataBase->copy()->addMonths($i);
            $periodos[] = [
                'mes' => $data->month,
                'ano' => $data->year,
                'label' => $data->translatedFormat('m/Y'),
            ];
        }

        return $periodos;
    }

    public function updatedRevenueReprocessModeLote()
    {
        // Reset quando alternar modo
        if (!$this->revenueReprocessModeLote) {
            $this->revenueReprocessNumMeses = 12;
        }
    }

    public function updatedRevenueReprocessNumMeses()
    {
        // Validação básica
        if ($this->revenueReprocessNumMeses < 1) {
            $this->revenueReprocessNumMeses = 1;
        }
        if ($this->revenueReprocessNumMeses > 24) {
            $this->revenueReprocessNumMeses = 24;
        }
    }

    /**
     * Calcula preview do reprocessamento de receitas
     */
    public function getRevenueReprocessPreviewProperty()
    {
        // Sempre retorna array, nunca null
        // Isso garante que o preview sempre apareça no frontend

        // Precisa ter mês e ano selecionados
        if (!$this->revenueReprocessMes || !$this->revenueReprocessAno) {
            return [
                'periodos' => [],
                'totalFaturas' => 0,
            ];
        }

        // Se modo lote, calcula múltiplos períodos
        if ($this->revenueReprocessModeLote) {
            $periodos = $this->calcularPeriodosReprocessamento($this->revenueReprocessNumMeses ?? 12);
        } else {
            // Modo individual: apenas 1 período
            $periodos = [[
                'mes' => $this->revenueReprocessMes,
                'ano' => $this->revenueReprocessAno,
                'label' => str_pad($this->revenueReprocessMes, 2, '0', STR_PAD_LEFT) . '/' . $this->revenueReprocessAno,
            ]];
        }

        // Conta faturas existentes para cada período
        $totalFaturas = 0;
        foreach ($periodos as &$periodo) {
            $query = RevenueSummary::where('mes', $periodo['mes'])
                ->where('ano', $periodo['ano']);

            if ($this->revenueReprocessCustomerId) {
                $query->where('customer_id', $this->revenueReprocessCustomerId);
            }

            $count = $query->count();
            $periodo['faturas'] = $count;
            $totalFaturas += $count;
        }

        return [
            'periodos' => $periodos,
            'totalFaturas' => $totalFaturas,
        ];
    }

    /**
     * Atualiza receita de produtos recorrentes para o mês atual
     */
    public function atualizarReceitaProdutos()
    {
        try {
            $mes = now()->month;
            $ano = now()->year;

            $service = app(\App\Services\MonthlyRevenueSummaryService::class);
            $service->atualizarReceitaProdutos($mes, $ano);

            $this->toast()->success("✅ Receita de produtos atualizada para {$mes}/{$ano}!")->send();
            $this->loadStats();

            Log::info('Receita de produtos atualizada via interface', [
                'user_id' => auth()->id(),
                'mes' => $mes,
                'ano' => $ano,
            ]);

        } catch (\Exception $e) {
            $this->toast()->error("Erro ao atualizar produtos: {$e->getMessage()}")->send();
            Log::error('Erro ao atualizar receita de produtos via interface', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
        }
    }

    /**
     * Abre modal de fechar faturas e carrega preview
     */
    public function openFecharFaturasModal()
    {
        $this->fecharFaturasModal = true;
        $mesAnterior = now()->subMonth();
        $this->fecharFaturasMes = $mesAnterior->month;
        $this->fecharFaturasAno = $mesAnterior->year;
        $this->carregarPreviewFecharFaturas();
    }

    /**
     * Carrega preview de quantas faturas serão fechadas
     */
    public function carregarPreviewFecharFaturas()
    {
        try {
            if ($this->fecharFaturasModeLote) {
                // Modo lote: calcular período
                $periodos = $this->calcularPeriodosFechamento($this->fecharFaturasNumMeses);

                $faturasClientes = 0;
                $relatoriosOperadoras = 0;

                foreach ($periodos as $periodo) {
                    $faturasClientes += RevenueSummary::where('mes', $periodo['mes'])
                        ->where('ano', $periodo['ano'])
                        ->where('fechado', false)
                        ->count();

                    $relatoriosOperadoras += CarrierUsage::where('mes', $periodo['mes'])
                        ->where('ano', $periodo['ano'])
                        ->where('fechado', false)
                        ->count();
                }

                $this->fecharFaturasPreview = [
                    'faturas_clientes' => $faturasClientes,
                    'relatorios_operadoras' => $relatoriosOperadoras,
                    'periodos' => count($periodos),
                    'meses' => $periodos,
                ];
            } else {
                // Modo único mês
                $faturasClientes = RevenueSummary::where('mes', $this->fecharFaturasMes)
                    ->where('ano', $this->fecharFaturasAno)
                    ->where('fechado', false)
                    ->count();

                $relatoriosOperadoras = CarrierUsage::where('mes', $this->fecharFaturasMes)
                    ->where('ano', $this->fecharFaturasAno)
                    ->where('fechado', false)
                    ->count();

                $this->fecharFaturasPreview = [
                    'faturas_clientes' => $faturasClientes,
                    'relatorios_operadoras' => $relatoriosOperadoras,
                ];
            }

        } catch (\Exception $e) {
            $this->fecharFaturasPreview = [
                'faturas_clientes' => 0,
                'relatorios_operadoras' => 0,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Calcula períodos para fechamento em lote
     */
    private function calcularPeriodosFechamento($numMeses)
    {
        $periodos = [];
        $dataBase = Carbon::createFromDate($this->fecharFaturasAno, $this->fecharFaturasMes, 1);

        for ($i = 0; $i < $numMeses; $i++) {
            $data = $dataBase->copy()->subMonths($i);
            $periodos[] = [
                'mes' => $data->month,
                'ano' => $data->year,
                'label' => $data->translatedFormat('m/Y'),
            ];
        }

        return $periodos;
    }

    /**
     * Atualiza preview quando mês/ano mudam
     */
    public function updatedFecharFaturasMes()
    {
        $this->carregarPreviewFecharFaturas();
    }

    public function updatedFecharFaturasAno()
    {
        $this->carregarPreviewFecharFaturas();
    }

    public function updatedFecharFaturasModeLote()
    {
        $this->carregarPreviewFecharFaturas();
    }

    public function updatedFecharFaturasNumMeses()
    {
        $this->carregarPreviewFecharFaturas();
    }

    public function updatedReabrirFaturasModeLote()
    {
        // Reset quando alternar modo
        if (!$this->reabrirFaturasModeLote) {
            $this->reabrirFaturasNumMeses = 12;
        }
    }

    public function updatedReabrirFaturasNumMeses()
    {
        // Validação básica
        if ($this->reabrirFaturasNumMeses < 1) {
            $this->reabrirFaturasNumMeses = 1;
        }
        if ($this->reabrirFaturasNumMeses > 24) {
            $this->reabrirFaturasNumMeses = 24;
        }
    }

    /**
     * Fecha faturas do mês/ano selecionado (ou em lote)
     */
    public function fecharFaturas()
    {
        try {
            // Validações
            if (!$this->fecharFaturasMes || $this->fecharFaturasMes < 1 || $this->fecharFaturasMes > 12) {
                $this->toast()->error('Mês inválido. Use valores entre 1 e 12.')->send();
                return;
            }

            if (!$this->fecharFaturasAno || $this->fecharFaturasAno < 2020 || $this->fecharFaturasAno > 2100) {
                $this->toast()->error('Ano inválido.')->send();
                return;
            }

            $service = app(\App\Services\MonthlyRevenueSummaryService::class);
            $totalFaturasClientes = 0;
            $totalRelatoriosOperadoras = 0;

            if ($this->fecharFaturasModeLote) {
                // Modo lote: processar múltiplos meses
                $periodos = $this->calcularPeriodosFechamento($this->fecharFaturasNumMeses);

                foreach ($periodos as $periodo) {
                    // Atualiza receita de produtos antes de fechar
                    $service->atualizarReceitaProdutos($periodo['mes'], $periodo['ano']);

                    // Fecha faturas de clientes
                    $totalFaturasClientes += RevenueSummary::where('mes', $periodo['mes'])
                        ->where('ano', $periodo['ano'])
                        ->where('fechado', false)
                        ->update(['fechado' => true]);

                    // Fecha relatórios de operadoras
                    $totalRelatoriosOperadoras += CarrierUsage::where('mes', $periodo['mes'])
                        ->where('ano', $periodo['ano'])
                        ->where('fechado', false)
                        ->update(['fechado' => true]);
                }

                $this->toast()->success("✅ Faturamento em lote fechado! {$totalFaturasClientes} fatura(s) de clientes e {$totalRelatoriosOperadoras} relatório(s) de operadoras em " . count($periodos) . " mês(es).")->send();

                Log::info('Fechamento de faturas em lote via interface', [
                    'user_id' => auth()->id(),
                    'num_meses' => $this->fecharFaturasNumMeses,
                    'periodos' => $periodos,
                    'faturas_clientes' => $totalFaturasClientes,
                    'relatorios_operadoras' => $totalRelatoriosOperadoras,
                ]);
            } else {
                // Modo único mês
                $service->atualizarReceitaProdutos($this->fecharFaturasMes, $this->fecharFaturasAno);

                // Fecha faturas de clientes
                $totalFaturasClientes = RevenueSummary::where('mes', $this->fecharFaturasMes)
                    ->where('ano', $this->fecharFaturasAno)
                    ->where('fechado', false)
                    ->update(['fechado' => true]);

                // Fecha relatórios de operadoras
                $totalRelatoriosOperadoras = CarrierUsage::where('mes', $this->fecharFaturasMes)
                    ->where('ano', $this->fecharFaturasAno)
                    ->where('fechado', false)
                    ->update(['fechado' => true]);

                $this->toast()->success("✅ Faturamento fechado! {$totalFaturasClientes} fatura(s) de clientes e {$totalRelatoriosOperadoras} relatório(s) de operadoras.")->send();

                Log::info('Fechamento de faturas via interface', [
                    'user_id' => auth()->id(),
                    'mes' => $this->fecharFaturasMes,
                    'ano' => $this->fecharFaturasAno,
                    'faturas_clientes' => $totalFaturasClientes,
                    'relatorios_operadoras' => $totalRelatoriosOperadoras,
                ]);
            }

        } catch (\Exception $e) {
            $this->toast()->error("Erro ao fechar faturas: {$e->getMessage()}")->send();
            Log::error('Erro ao fechar faturas via interface', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'mes' => $this->fecharFaturasMes,
                'ano' => $this->fecharFaturasAno,
            ]);
        }
    }

    /**
     * Calcula períodos para reabertura em lote
     */
    private function calcularPeriodosReabertura(int $numMeses): array
    {
        $periodos = [];
        $dataBase = Carbon::createFromDate($this->reabrirFaturasAno, $this->reabrirFaturasMes, 1);

        for ($i = 0; $i < $numMeses; $i++) {
            $data = $dataBase->copy()->subMonths($i);
            $periodos[] = [
                'mes' => $data->month,
                'ano' => $data->year,
                'label' => $data->translatedFormat('m/Y'),
            ];
        }

        return $periodos;
    }

    /**
     * Abre modal de reabrir faturas
     */
    public function openReabrirFaturasModal()
    {
        $this->reabrirFaturasModal = true;
        $mesAnterior = now()->subMonth();
        $this->reabrirFaturasMes = $mesAnterior->month;
        $this->reabrirFaturasAno = $mesAnterior->year;
        $this->reabrirFaturasTipo = 'ambos';
        $this->reabrirFaturasMotivo = '';
    }

    /**
     * Reabre faturas do mês/ano selecionado
     */
    public function reabrirFaturas()
    {
        try {
            // Validações
            if (!$this->reabrirFaturasMes || $this->reabrirFaturasMes < 1 || $this->reabrirFaturasMes > 12) {
                $this->toast()->error('Mês inválido. Use valores entre 1 e 12.')->send();
                return;
            }

            if (!$this->reabrirFaturasAno || $this->reabrirFaturasAno < 2020 || $this->reabrirFaturasAno > 2100) {
                $this->toast()->error('Ano inválido.')->send();
                return;
            }

            if (empty(trim($this->reabrirFaturasMotivo))) {
                $this->toast()->error('Motivo é obrigatório para auditoria.')->send();
                return;
            }

            $faturasClientes = 0;
            $relatoriosOperadoras = 0;

            if ($this->reabrirFaturasModeLote) {
                // Modo lote: processar múltiplos meses
                $periodos = $this->calcularPeriodosReabertura($this->reabrirFaturasNumMeses);

                foreach ($periodos as $periodo) {
                    // Reabre conforme tipo selecionado
                    if (in_array($this->reabrirFaturasTipo, ['cliente', 'ambos'])) {
                        $faturasClientes += RevenueSummary::where('mes', $periodo['mes'])
                            ->where('ano', $periodo['ano'])
                            ->where('fechado', true)
                            ->update(['fechado' => false]);
                    }

                    if (in_array($this->reabrirFaturasTipo, ['operadora', 'ambos'])) {
                        $relatoriosOperadoras += CarrierUsage::where('mes', $periodo['mes'])
                            ->where('ano', $periodo['ano'])
                            ->where('fechado', true)
                            ->update(['fechado' => false]);
                    }
                }

                $this->toast()->success("✅ Faturamento em lote reaberto! {$faturasClientes} fatura(s) de clientes e {$relatoriosOperadoras} relatório(s) de operadoras em " . count($periodos) . " mês(es).")->send();

                Log::warning('Reabertura de faturas em lote via interface', [
                    'user_id' => auth()->id(),
                    'user_name' => auth()->user()->name ?? 'N/A',
                    'num_meses' => $this->reabrirFaturasNumMeses,
                    'periodos' => $periodos,
                    'tipo' => $this->reabrirFaturasTipo,
                    'motivo' => $this->reabrirFaturasMotivo,
                    'faturas_clientes' => $faturasClientes,
                    'relatorios_operadoras' => $relatoriosOperadoras,
                ]);
            } else {
                // Modo único mês
                // Reabre conforme tipo selecionado
                if (in_array($this->reabrirFaturasTipo, ['cliente', 'ambos'])) {
                    $faturasClientes = RevenueSummary::where('mes', $this->reabrirFaturasMes)
                        ->where('ano', $this->reabrirFaturasAno)
                        ->where('fechado', true)
                        ->update(['fechado' => false]);
                }

                if (in_array($this->reabrirFaturasTipo, ['operadora', 'ambos'])) {
                    $relatoriosOperadoras = CarrierUsage::where('mes', $this->reabrirFaturasMes)
                        ->where('ano', $this->reabrirFaturasAno)
                        ->where('fechado', true)
                        ->update(['fechado' => false]);
                }

                $this->toast()->success("✅ Faturamento reaberto! {$faturasClientes} fatura(s) de clientes e {$relatoriosOperadoras} relatório(s) de operadoras.")->send();

                Log::warning('Reabertura de faturas via interface', [
                    'user_id' => auth()->id(),
                    'user_name' => auth()->user()->name ?? 'N/A',
                    'mes' => $this->reabrirFaturasMes,
                    'ano' => $this->reabrirFaturasAno,
                    'tipo' => $this->reabrirFaturasTipo,
                    'motivo' => $this->reabrirFaturasMotivo,
                    'faturas_clientes' => $faturasClientes,
                    'relatorios_operadoras' => $relatoriosOperadoras,
                ]);
            }

            $this->reabrirFaturasModal = false;
            $this->loadStats();

        } catch (\Exception $e) {
            $this->toast()->error("Erro ao reabrir faturas: {$e->getMessage()}")->send();
            Log::error('Erro ao reabrir faturas via interface', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'mes' => $this->reabrirFaturasMes,
                'ano' => $this->reabrirFaturasAno,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.maintenance.index');
    }
}
