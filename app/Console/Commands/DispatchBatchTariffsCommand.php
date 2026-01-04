<?php

namespace App\Console\Commands;

use App\Jobs\ProcessCdrBatchJob;
use App\Models\Cdr;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DispatchBatchTariffsCommand extends Command
{
    protected $signature = 'tariff:dispatch-batches
                            {--batch-size=1000 : Number of CDRs per batch job}
                            {--max-batches= : Maximum number of batch jobs to dispatch}
                            {--carrier= : Process only specific carrier_id}';

    protected $description = 'Dispatch batch jobs to process pending CDRs asynchronously';

    public function handle()
    {
        $batchSize = (int) $this->option('batch-size');
        $maxBatches = $this->option('max-batches') ? (int) $this->option('max-batches') : null;
        $carrierId = $this->option('carrier');

        $this->info('🚀 Despachando jobs de processamento em lote');
        $this->info("📊 Tamanho do lote: {$batchSize} CDRs por job");

        // Conta total de pendentes
        $query = Cdr::where('status', 'Pendente');
        if ($carrierId) {
            $query->where('carrier_id', $carrierId);
            $this->info("📊 Carrier: {$carrierId}");
        }

        $totalPending = $query->count();

        $this->info("📋 Total de CDRs pendentes: " . number_format($totalPending, 0, ',', '.'));

        if ($totalPending === 0) {
            $this->info('✅ Nenhum CDR pendente para processar');
            return 0;
        }

        // Calcula quantos lotes serão necessários
        $totalBatches = (int) ceil($totalPending / $batchSize);

        if ($maxBatches) {
            $totalBatches = min($totalBatches, $maxBatches);
            $this->info("📊 Limite de lotes: {$maxBatches}");
        }

        $this->info("📦 Total de lotes a criar: {$totalBatches}");
        $this->info("📊 CDRs que serão processados: " . number_format(min($totalPending, $totalBatches * $batchSize), 0, ',', '.'));

        if (!$this->confirm('Deseja continuar?', true)) {
            $this->info('Cancelado pelo usuário');
            return 0;
        }

        // Despacha os jobs em lote
        $this->output->progressStart($totalBatches);

        for ($i = 0; $i < $totalBatches; $i++) {
            $offset = $i * $batchSize;

            ProcessCdrBatchJob::dispatch($batchSize, $carrierId, $offset);

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();

        $this->newLine(2);
        $this->info('═══════════════════════════════════════════════');
        $this->info('              ✅ JOBS DESPACHADOS');
        $this->info('═══════════════════════════════════════════════');
        $this->newLine();

        $this->table(
            ['Métrica', 'Valor'],
            [
                ['Jobs Criados', number_format($totalBatches, 0, ',', '.')],
                ['CDRs por Job', number_format($batchSize, 0, ',', '.')],
                ['Total CDRs', number_format(min($totalPending, $totalBatches * $batchSize), 0, ',', '.')],
            ]
        );

        $this->newLine();
        $this->info('💡 Dica: Monitore o processamento com:');
        $this->line('   php artisan queue:work --verbose');
        $this->newLine();
        $this->info('💡 Verifique jobs falhados com:');
        $this->line('   php artisan queue:failed');
        $this->newLine();
        $this->info('💡 Monitore logs em tempo real:');
        $this->line('   tail -f storage/logs/laravel.log');
        $this->newLine();
        $this->info('═══════════════════════════════════════════════');

        return 0;
    }
}
