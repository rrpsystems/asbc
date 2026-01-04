<?php

namespace App\Console\Commands;

use App\Models\CarrierUsage;
use App\Models\RevenueSummary;
use Illuminate\Console\Command;

class ReabrirFaturaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fatura:reabrir {mes} {ano} {--tipo=ambos}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reabre faturas fechadas de um mês específico (tipos: cliente, operadora, ambos)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mes = $this->argument('mes');
        $ano = $this->argument('ano');
        $tipo = $this->option('tipo');

        if ($mes < 1 || $mes > 12) {
            $this->error('Mês inválido. Informe um valor entre 1 e 12.');
            return 1;
        }

        $this->info("Reabrindo faturas da competência {$mes}/{$ano}...");

        $totalClientes = 0;
        $totalOperadoras = 0;

        // Reabre faturas de clientes
        if (in_array($tipo, ['cliente', 'ambos'])) {
            $totalClientes = RevenueSummary::where('mes', $mes)
                ->where('ano', $ano)
                ->where('fechado', true)
                ->update(['fechado' => false]);

            $this->info("✓ {$totalClientes} fatura(s) de clientes reabertas!");
        }

        // Reabre relatórios de operadoras
        if (in_array($tipo, ['operadora', 'ambos'])) {
            $totalOperadoras = CarrierUsage::where('mes', $mes)
                ->where('ano', $ano)
                ->where('fechado', true)
                ->update(['fechado' => false]);

            $this->info("✓ {$totalOperadoras} relatório(s) de operadoras reabertos!");
        }

        if ($totalClientes === 0 && $totalOperadoras === 0) {
            $this->warn("Nenhuma fatura fechada encontrada para {$mes}/{$ano}");
        } else {
            $this->info("Status alterado de 'Fechado' para 'Aberto'");
        }

        return 0;
    }
}
