<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * @deprecated Este comando está DEPRECADO e será removido em versão futura.
 *
 * PROBLEMAS:
 * 1. Usa MonthlyRevenueSummaryService::atualizarResumo() (deprecado)
 * 2. Race conditions - Processamento 1 CDR por vez
 * 3. Performance ruim - 10.000 CDRs = 10.000 transactions
 * 4. Sem distributed locks
 *
 * SUBSTITUÍDO POR:
 * - ReprocessRevenueBatchCommand (app/Console/Commands/ReprocessRevenueBatchCommand.php)
 * - Usa batch processing (100 CDRs por job)
 * - Atomic updates com DB::raw()
 * - Distributed locks
 * - 99% mais rápido
 *
 * @see \App\Console\Commands\ReprocessRevenueBatchCommand
 */
class RefaturarCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fatura:reprocessar {mes} {ano} {--customer_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[DEPRECADO] Use revenue:reprocess - Reprocessa faturas com batch processing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->warn('╔════════════════════════════════════════════════════════════╗');
        $this->warn('║                    ⚠️  COMANDO DEPRECADO                   ║');
        $this->warn('╚════════════════════════════════════════════════════════════╝');
        $this->newLine();

        $this->error('❌ Este comando está DEPRECADO e será removido em versão futura.');
        $this->newLine();

        $this->comment('PROBLEMAS do comando antigo:');
        $this->comment('  • Race conditions (perda de dados)');
        $this->comment('  • Performance ruim (1 CDR por vez)');
        $this->comment('  • 10.000 CDRs = 10.000 transactions');
        $this->newLine();

        $this->info('✅ Use o novo comando otimizado:');
        $this->newLine();

        $mes = $this->argument('mes');
        $ano = $this->argument('ano');
        $customerId = $this->option('customer_id');

        $novoComando = "php artisan revenue:reprocess {$mes} {$ano}";
        if ($customerId) {
            $novoComando .= " --customer_id={$customerId}";
        }

        $this->line("  <fg=green>{$novoComando}</>");
        $this->newLine();

        $this->comment('VANTAGENS do novo comando:');
        $this->comment('  ✓ Batch processing (100 CDRs por job)');
        $this->comment('  ✓ Distributed locks (previne race conditions)');
        $this->comment('  ✓ Atomic updates (DB::raw)');
        $this->comment('  ✓ 99% mais rápido');
        $this->comment('  ✓ Modo síncrono e assíncrono');
        $this->newLine();

        if ($this->confirm('Deseja executar o novo comando agora?', true)) {
            $this->newLine();
            $this->call('revenue:reprocess', [
                'mes' => $mes,
                'ano' => $ano,
                '--customer_id' => $customerId,
            ]);
        } else {
            $this->comment('Operação cancelada. Execute manualmente quando estiver pronto.');
        }

        return 0;
    }
}
