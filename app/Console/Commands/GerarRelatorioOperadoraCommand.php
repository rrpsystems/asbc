<?php

namespace App\Console\Commands;

use App\Services\CarrierCostAllocationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GerarRelatorioOperadoraCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'operadora:gerar-relatorio {mes} {ano} {--carrier_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gera ou recalcula o relatório de gastos da operadora para um mês específico';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mes = $this->argument('mes');
        $ano = $this->argument('ano');
        $carrierId = $this->option('carrier_id');

        if ($mes < 1 || $mes > 12) {
            $this->error('Mês inválido. Informe um valor entre 1 e 12.');
            return 1;
        }

        $this->info("Gerando relatórios de operadora para {$mes}/{$ano}...");

        if ($carrierId) {
            $this->info("Filtrando apenas carrier_id: {$carrierId}");
        }

        try {
            $service = new CarrierCostAllocationService();
            $totalOperadoras = $service->persistirResumoMensal($mes, $ano, $carrierId);

            $this->info("✓ Relatórios gerados para {$totalOperadoras} operadora(s)!");

            Log::info('Relatórios de operadora gerados manualmente', [
                'mes' => $mes,
                'ano' => $ano,
                'carrier_id' => $carrierId,
                'total_operadoras' => $totalOperadoras,
            ]);

            return 0;
        } catch (\Exception $e) {
            $this->error("Erro ao gerar relatórios: {$e->getMessage()}");

            Log::error('Erro ao gerar relatórios de operadora', [
                'mes' => $mes,
                'ano' => $ano,
                'carrier_id' => $carrierId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return 1;
        }
    }
}
