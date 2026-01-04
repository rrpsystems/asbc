<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

/**
 * @deprecated Este comando está DEPRECADO e será removido em versão futura.
 *
 * MOTIVO: Duplicação de funcionalidade com GerarRelatorioOperadoraCommand.
 *
 * PROBLEMA:
 * - Dois comandos fazem exatamente a mesma coisa
 * - Manutenção duplicada
 * - Confusão para usuários
 *
 * SUBSTITUÍDO POR:
 * - operadora:gerar-relatorio (mais completo, suporta --carrier_id)
 *
 * MIGRAÇÃO:
 * - Antes: php artisan operadora:processar-mensal --mes=12 --ano=2025
 * - Depois: php artisan operadora:gerar-relatorio 12 2025
 *
 * @see \App\Console\Commands\GerarRelatorioOperadoraCommand
 */
class ProcessarRelatorioOperadoraMensalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'operadora:processar-mensal {--mes=} {--ano=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[DEPRECADO] Use operadora:gerar-relatorio - Processa relatórios de operadora';

    /**
     * Execute the console command.
     *
     * Este comando agora é um wrapper que redireciona para operadora:gerar-relatorio
     */
    public function handle()
    {
        // Se não informar mês/ano, usa o mês anterior
        $mes = $this->option('mes') ?: Carbon::now()->subMonth()->month;
        $ano = $this->option('ano') ?: Carbon::now()->subMonth()->year;

        // Exibe aviso de deprecação
        $this->warn('╔════════════════════════════════════════════════════════════╗');
        $this->warn('║             ⚠️  COMANDO DEPRECADO                          ║');
        $this->warn('╚════════════════════════════════════════════════════════════╝');
        $this->newLine();
        $this->error('❌ Este comando está DEPRECADO e será removido em versão futura.');
        $this->newLine();

        $this->line('<fg=yellow>PROBLEMA do comando antigo:</>');
        $this->line('  • Duplicação com operadora:gerar-relatorio');
        $this->line('  • Não suporta filtro por operadora (--carrier_id)');
        $this->line('  • Manutenção duplicada');
        $this->newLine();

        $this->line('<fg=green>✅ Use o novo comando:</>');
        $this->line("  <fg=cyan>php artisan operadora:gerar-relatorio {$mes} {$ano}</>");
        $this->newLine();

        $this->line('<fg=green>VANTAGENS do novo comando:</>');
        $this->line('  ✓ Mais completo (suporta --carrier_id)');
        $this->line('  ✓ Validação de mês/ano');
        $this->line('  ✓ Argumentos obrigatórios (menos erros)');
        $this->line('  ✓ Já usado pela interface web');
        $this->newLine();

        // Pergunta se deseja executar o novo comando
        if ($this->confirm("Deseja executar o novo comando operadora:gerar-relatorio {$mes} {$ano} agora?", true)) {
            $this->info("Executando: operadora:gerar-relatorio {$mes} {$ano}");
            $this->newLine();

            // Log de uso do comando deprecado
            Log::warning('Comando DEPRECADO operadora:processar-mensal foi usado', [
                'mes' => $mes,
                'ano' => $ano,
                'user' => get_current_user(),
            ]);

            // Chama o comando novo
            $exitCode = Artisan::call('operadora:gerar-relatorio', [
                'mes' => $mes,
                'ano' => $ano,
            ]);

            // Exibe output do comando novo
            $this->line(Artisan::output());

            return $exitCode;
        } else {
            $this->warn('Execução cancelada.');
            $this->info('Para executar manualmente:');
            $this->line("  <fg=cyan>php artisan operadora:gerar-relatorio {$mes} {$ano}</>");

            return 0;
        }
    }
}
