<?php

namespace App\Console\Commands;

use App\Models\CarrierUsage;
use App\Models\RevenueSummary;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FecharFaturasMensalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fatura:fechar-mensal {--mes=} {--ano=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fecha faturas de clientes e relatórios de operadoras do mês anterior (período: dia 3 do mês anterior até dia 2 do mês atual)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Se não informar, usa o mês/ano do período que está fechando
        // Exemplo: rodando dia 3/11, fecha o período 3/10 a 2/11 (competência 10/2025)
        $dataReferencia = $this->option('mes') && $this->option('ano')
            ? Carbon::create($this->option('ano'), $this->option('mes'), 1)
            : Carbon::now()->subMonth();

        $mes = $dataReferencia->month;
        $ano = $dataReferencia->year;

        $this->info("Fechando faturas da competência {$mes}/{$ano}...");
        $this->info("Período: 03/{$mes}/{$ano} até 02/" . Carbon::create($ano, $mes)->addMonth()->format('m/Y'));

        // Atualiza receita de produtos recorrentes antes de fechar
        $this->info("Atualizando receita de produtos recorrentes...");
        $service = app(\App\Services\MonthlyRevenueSummaryService::class);
        $service->atualizarReceitaProdutos($mes, $ano);
        $this->info("✓ Receita de produtos atualizada!");

        // Fecha faturas de clientes
        $faturasClientes = RevenueSummary::where('mes', $mes)
            ->where('ano', $ano)
            ->where('fechado', false)
            ->update(['fechado' => true]);

        // Fecha relatórios de operadoras
        $relatoriosOperadoras = CarrierUsage::where('mes', $mes)
            ->where('ano', $ano)
            ->where('fechado', false)
            ->update(['fechado' => true]);

        $this->info("✓ {$faturasClientes} fatura(s) de clientes fechadas!");
        $this->info("✓ {$relatoriosOperadoras} relatório(s) de operadoras fechados!");
        $this->info("Status alterado de 'Aberto' para 'Fechado'");

        return 0;
    }
}
