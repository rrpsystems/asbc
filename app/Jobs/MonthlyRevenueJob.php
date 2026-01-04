<?php

namespace App\Jobs;

use App\Services\MonthlyRevenueSummaryService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

/**
 * @deprecated Este job está DEPRECADO e será removido em versão futura.
 *
 * PROBLEMAS CRÍTICOS:
 * 1. Nunca executava porque verificava status 'Processada' (que não existe)
 * 2. Race conditions ao atualizar resumos mensais
 * 3. Variável $summary indefinida no catch (erro fatal)
 * 4. Performance ruim (1 job por CDR)
 *
 * SUBSTITUÍDO POR:
 * - CallTariffJob agora usa RevenueBatchDispatcher
 * - ProcessMonthlyRevenueBatch processa CDRs em lote
 * - CheckFranchiseAlert listener para alertas (event-driven)
 *
 * @see \App\Jobs\ProcessMonthlyRevenueBatch
 * @see \App\Services\RevenueBatchDispatcher
 */
class MonthlyRevenueJob implements ShouldQueue
{
    use Queueable;

    protected $cdr;

    /**
     * Create a new job instance.
     *
     * @param  mixed  $cdr
     * @deprecated Não use mais este job. Use RevenueBatchDispatcher.
     */
    public function __construct($cdr)
    {
        $this->cdr = $cdr;

        // Log de warning para detectar uso indevido
        Log::warning('MonthlyRevenueJob DEPRECADO foi instanciado', [
            'cdr_id' => $cdr->id ?? 'unknown',
            'trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3),
        ]);
    }

    /**
     * Execute the job.
     *
     * @return void
     * @deprecated Este job está quebrado e não deve ser usado.
     */
    public function handle(MonthlyRevenueSummaryService $revenueSummaryService)
    {
        Log::warning('MonthlyRevenueJob DEPRECADO foi executado - NÃO USE!', [
            'cdr_id' => $this->cdr->id ?? 'unknown',
            'cdr_status' => $this->cdr->status ?? 'unknown',
        ]);

        // NOTA: Este código NUNCA executava porque o status nunca é 'Processada'
        // O CallTariffJob marca como 'Tarifada', não 'Processada'
        if ($this->cdr->status !== 'Processada') {
            return; // Não faz nada se não estiver processada
        }

        try {
            // Atualiza o resumo mensal com base no CDR
            $summary = $revenueSummaryService->atualizarResumo($this->cdr);

            // Atualiza o status do CDR
            $this->cdr->status = 'Tarifada';
            $this->cdr->cobrada = $summary;
            $this->cdr->save();

        } catch (\Exception $e) {
            // Atualiza o status do CDR em caso de erro
            $this->cdr->cobrada = $summary;
            $this->cdr->status = 'Erro_Resumo';
            $this->cdr->save();

            // Loga a exceção para monitoramento
            Log::error('Erro ao processar CDR: '.$this->cdr->id.' - '.$e->getMessage());

            throw $e; // Lança a exceção novamente
        }
    }
}
