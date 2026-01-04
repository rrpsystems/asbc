<?php

namespace App\Console\Commands;

use App\Jobs\CallTariffJob;
use App\Models\Cdr;
use Illuminate\Console\Command;

class ReprocessTariffCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'tariff:reprocess
                            {--status= : Status dos CDRs (ex: Erro_Tarifa, Tarifa_Nao_Encontrada)}
                            {--limit=100 : Quantidade máxima de CDRs}
                            {--cdr-id= : ID específico de um CDR}
                            {--force : Força reprocessamento mesmo se já tarifado}';

    /**
     * The console command description.
     */
    protected $description = 'Reprocessa tarifação de CDRs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Processa CDR específico
        if ($cdrId = $this->option('cdr-id')) {
            return $this->processSingleCdr((int)$cdrId);
        }

        // Processa múltiplos CDRs
        return $this->processMultipleCdrs();
    }

    /**
     * Processa um único CDR
     */
    private function processSingleCdr(int $cdrId): int
    {
        $cdr = Cdr::find($cdrId);

        if (!$cdr) {
            $this->error("❌ CDR #{$cdrId} não encontrado");
            return 1;
        }

        $this->info("📋 CDR #{$cdrId}");
        $this->info("   Status atual: {$cdr->status}");
        $this->info("   Número: {$cdr->numero}");
        $this->info("   Billsec: {$cdr->billsec}s");

        if ($cdr->status === 'Tarifada' && !$this->option('force')) {
            $this->warn("⚠️  CDR já está tarifado. Use --force para reprocessar");
            return 0;
        }

        if ($this->confirm('Despachar job para este CDR?', true)) {
            CallTariffJob::dispatch($cdrId);
            $this->info("✅ Job despachado com sucesso!");
            $this->comment("💡 Execute: php artisan queue:work redis --once");
        }

        return 0;
    }

    /**
     * Processa múltiplos CDRs
     */
    private function processMultipleCdrs(): int
    {
        $query = Cdr::query();

        // Filtro por status
        if ($status = $this->option('status')) {
            $query->where('status', $status);
            $this->info("🔍 Filtrando por status: {$status}");
        } else {
            if ($this->option('force')) {
                $this->info("🔍 Processando TODOS os CDRs (--force ativado)");
            } else {
                $query->where('status', '!=', 'Tarifada');
                $this->info("🔍 Processando apenas CDRs não tarifados");
            }
        }

        // Limite
        $limit = (int)$this->option('limit');
        $total = $query->count();

        if ($total === 0) {
            $this->warn('⚠️  Nenhum CDR encontrado para processar');
            return 0;
        }

        $toProcess = min($limit, $total);

        $this->info("📊 Estatísticas:");
        $this->table(
            ['Métrica', 'Valor'],
            [
                ['Total encontrado', number_format($total, 0, ',', '.')],
                ['Será processado', number_format($toProcess, 0, ',', '.')],
                ['Limite configurado', number_format($limit, 0, ',', '.')],
            ]
        );

        if (!$this->confirm("Despachar {$toProcess} jobs?", true)) {
            $this->comment('Operação cancelada');
            return 0;
        }

        $cdrs = $query->limit($limit)->get(['id', 'status']);

        $bar = $this->output->createProgressBar($cdrs->count());
        $bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %message%');
        $bar->setMessage('Despachando jobs...');
        $bar->start();

        $dispatched = 0;
        $errors = 0;

        foreach ($cdrs as $cdr) {
            try {
                CallTariffJob::dispatch($cdr->id);
                $dispatched++;
                $bar->setMessage("CDR #{$cdr->id} despachado");
            } catch (\Exception $e) {
                $errors++;
                $bar->setMessage("Erro no CDR #{$cdr->id}");
                $this->error("\n❌ Erro ao despachar CDR #{$cdr->id}: {$e->getMessage()}");
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        // Resumo final
        $this->info("✅ Processo concluído!");
        $this->table(
            ['Resultado', 'Quantidade'],
            [
                ['Jobs despachados', $dispatched],
                ['Erros', $errors],
            ]
        );

        if ($dispatched > 0) {
            $this->newLine();
            $this->comment("💡 Para processar os jobs:");
            $this->comment("   php artisan queue:work redis --verbose");
            $this->newLine();
            $this->comment("💡 Para monitorar:");
            $this->comment("   tail -f storage/logs/laravel.log | grep Tariff");
        }

        return 0;
    }
}
