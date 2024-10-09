<?php

namespace App\Jobs;

use App\Services\CallTariffService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CallTariffJob implements ShouldQueue
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
    public function handle(CallTariffService $tariffService)
    {
        // Verifica se o CDR já foi processado
        if ($this->cdr->status === 'Processada') {
            return; // Não faz nada se já estiver processada
        }

        try {
            // Calcula as tarifas para o CDR
            $tarifas = $tariffService->calcularTarifa($this->cdr);

            // Atualiza o CDR com os valores calculados
            $this->cdr->valor_compra = $tarifas['compra'];
            $this->cdr->valor_venda = $tarifas['venda'];
            $this->cdr->tempo_cobrado = $tarifas['tempo_cobrado'];
            $this->cdr->status = 'Processada';
            $this->cdr->save();

            // Atualiza o resumo mensal, se necessário
            // $revenueSummaryService->atualizarResumo($this->cdr);
        } catch (\Exception $e) {
            // Atualiza o status do CDR em caso de erro
            $this->cdr->status = 'Erro_Tarifa';
            $this->cdr->save();

            // Loga a exceção para monitoramento
            Log::error('Erro ao processar CDR: '.$this->cdr->id.' - '.$e->getMessage());
            throw $e; // Lança a exceção novamente
        }
    }
}
