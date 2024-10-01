<?php

namespace App\Jobs;

use App\Services\CallTariffService;
use App\Services\MonthlyRevenueSummaryService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CallTariffJob implements ShouldQueue
{
    use Queueable;

    protected $cdr;

    /**
     * Create a new job instance.
     */
    public function __construct($cdr)
    {
        $this->cdr = $cdr;
    }

    /**
     * Execute the job.
     */
    // public function handle(CallTariffService $tariffService, MonthlyRevenueSummaryService $revenueSummaryService)
    public function handle(CallTariffService $tariffService)
    {
        try {
            $tarifas = $tariffService->calcularTarifa($this->cdr);

            // Atualiza o CDR com os valores calculados
            $this->cdr->valor_compra = $tarifas['compra'];
            $this->cdr->valor_venda = $tarifas['venda'];
            $this->cdr->tempo_cobrado = $tarifas['tempo_cobrado'];
            $this->cdr->status = 'Processada';
            $this->cdr->save();

            // Atualiza o resumo mensal
            // $revenueSummaryService->atualizarResumo($this->cdr);
        } catch (\Exception $e) {
            $this->cdr->status = 'Erro_Tarifa';
            $this->cdr->save();
            throw $e;
        }
    }
}
