<?php

namespace App\Jobs;

use App\Services\MonthlyRevenueSummaryService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class MonthlyRevenueJob implements ShouldQueue
{
    use Queueable;

    protected $cdr;

    /**
     * Create a new job instance.
     *
     * @param  mixed  $cdr
     */
    public function __construct($cdr)
    {
        $this->cdr = $cdr;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(MonthlyRevenueSummaryService $revenueSummaryService)
    {
        // Verifica se o status do CDR é 'Processada'
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
