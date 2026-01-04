<?php

namespace App\Console\Commands;

use App\Jobs\ProcessMonthlyRevenueBatch;
use App\Models\Cdr;
use App\Models\RevenueSummary;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReprocessRevenueBatchCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'revenue:reprocess
                            {mes : Mês (1-12)}
                            {ano : Ano (ex: 2025)}
                            {--customer_id= : ID específico do cliente}
                            {--batch-size=100 : Tamanho do batch (padrão: 100)}
                            {--sync : Processa sincronamente ao invés de despachar jobs}
                            {--force : Pula confirmação (útil quando chamado via interface web)}';

    /**
     * The console command description.
     */
    protected $description = 'Reprocessa resumos mensais de receita em lote usando batch processing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mes = (int) $this->argument('mes');
        $ano = (int) $this->argument('ano');
        $customerId = $this->option('customer_id');
        $batchSize = (int) $this->option('batch-size');
        $sync = $this->option('sync');

        // Validações
        if ($mes < 1 || $mes > 12) {
            $this->error('❌ Mês inválido. Use valores entre 1 e 12.');
            return 1;
        }

        if ($ano < 2020 || $ano > 2100) {
            $this->error('❌ Ano inválido.');
            return 1;
        }

        $this->info("╔══════════════════════════════════════════════════════════╗");
        $this->info("║  Reprocessamento de Receitas Mensais (Batch Mode)       ║");
        $this->info("╚══════════════════════════════════════════════════════════╝");
        $this->newLine();
        $this->info("📅 Competência: {$mes}/{$ano}");

        if ($customerId) {
            $this->info("👤 Cliente ID: {$customerId}");
        } else {
            $this->info("👥 Todos os clientes");
        }

        $this->info("📦 Batch size: {$batchSize} CDRs por job");
        $this->info("⚙️  Modo: " . ($sync ? 'Síncrono (sem queue)' : 'Assíncrono (com queue)'));
        $this->newLine();

        // Busca faturas a reprocessar
        $query = RevenueSummary::where('mes', $mes)
            ->where('ano', $ano);

        if ($customerId) {
            $query->where('customer_id', $customerId);
        }

        $faturas = $query->get();

        if ($faturas->isEmpty()) {
            $this->warn('⚠️  Nenhuma fatura encontrada para reprocessar.');
            $this->comment('💡 Dica: As faturas são criadas automaticamente quando há CDRs tarifados.');
            return 0;
        }

        $this->info("📊 Encontradas {$faturas->count()} fatura(s)");
        $this->newLine();

        // Pula confirmação se --force foi passado (chamadas via web interface)
        if (!$this->option('force') && !$this->confirm('Deseja continuar com o reprocessamento?', true)) {
            $this->comment('Operação cancelada pelo usuário.');
            return 0;
        }

        $this->newLine();
        $bar = $this->output->createProgressBar($faturas->count());
        $bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% - %message%');
        $bar->setMessage('Iniciando...');
        $bar->start();

        $totalJobsDispatched = 0;
        $totalCdrsToProcess = 0;

        foreach ($faturas as $fatura) {
            $bar->setMessage("Cliente #{$fatura->customer_id}");

            // Reseta o vínculo dos CDRs com a fatura para permitir reprocessamento
            DB::table('cdrs')
                ->where('customer_id', $fatura->customer_id)
                ->whereMonth('calldate', $mes)
                ->whereYear('calldate', $ano)
                ->where('revenue_summary_id', $fatura->id)
                ->update(['revenue_summary_id' => null]);

            // Reseta os valores da fatura
            DB::table('revenue_summaries')
                ->where('id', $fatura->id)
                ->update([
                    'minutos_fixo' => 0,
                    'minutos_movel' => 0,
                    'minutos_internacional' => 0,
                    'minutos_usados' => 0,
                    'minutos_excedentes' => 0,
                    'minutos_excedentes_fixo' => 0,
                    'minutos_excedentes_movel' => 0,
                    'minutos_excedentes_internacional' => 0,
                    'minutos_total' => 0,
                    'excedente_fixo' => 0,
                    'excedente_movel' => 0,
                    'excedente_internacional' => 0,
                    'excedente_total' => 0,
                    'custo_excedente' => 0,
                    // Mantém: valor_plano, franquia_minutos, produtos_*
                    'custo_total' => $fatura->valor_plano,
                    'updated_at' => now(),
                ]);

            // Busca IDs dos CDRs tarifados (só precisa dos IDs)
            $cdrIds = Cdr::where('customer_id', $fatura->customer_id)
                ->whereMonth('calldate', $mes)
                ->whereYear('calldate', $ano)
                ->where('status', 'Tarifada')
                ->orderBy('calldate')
                ->pluck('id')
                ->toArray();

            $totalCdrsToProcess += count($cdrIds);

            if (empty($cdrIds)) {
                $bar->advance();
                continue;
            }

            // Divide em batches
            $batches = array_chunk($cdrIds, $batchSize);
            $totalJobsDispatched += count($batches);

            foreach ($batches as $batchIds) {
                if ($sync) {
                    // Modo síncrono - executa diretamente
                    $job = new ProcessMonthlyRevenueBatch(
                        $fatura->customer_id,
                        $mes,
                        $ano,
                        $batchIds
                    );
                    $job->handle();
                } else {
                    // Modo assíncrono - despacha para queue
                    ProcessMonthlyRevenueBatch::dispatch(
                        $fatura->customer_id,
                        $mes,
                        $ano,
                        $batchIds
                    );
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        // Resumo final
        $this->info("✅ Reprocessamento iniciado com sucesso!");
        $this->newLine();

        $this->table(
            ['Métrica', 'Valor'],
            [
                ['Faturas processadas', number_format($faturas->count(), 0, ',', '.')],
                ['CDRs a processar', number_format($totalCdrsToProcess, 0, ',', '.')],
                ['Jobs despachados', number_format($totalJobsDispatched, 0, ',', '.')],
                ['Batch size', $batchSize],
                ['Modo', $sync ? 'Síncrono' : 'Assíncrono'],
            ]
        );

        if (!$sync) {
            $this->newLine();
            $this->comment("💡 Comandos úteis:");
            $this->comment("   Processar queue: php artisan queue:work redis --verbose");
            $this->comment("   Monitorar logs:  tail -f storage/logs/laravel.log | grep 'Revenue batch'");
            $this->newLine();
            $this->comment("💡 Os jobs estão na fila e serão processados em background.");
        } else {
            $this->newLine();
            $this->info("✅ Processamento síncrono concluído!");
        }

        return 0;
    }
}
