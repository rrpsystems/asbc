<?php

namespace App\Console\Commands;

use App\Jobs\ProcessCdrBatchJob;
use App\Models\Cdr;
use Illuminate\Console\Command;

class ProcessarCdrsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cdr:processar {--limit=10000 : Limite de CDRs a processar} {--batch-size=1000 : Tamanho de cada batch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processa CDRs pendentes usando sistema de batch';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $limit = $this->option('limit');
        $batchSize = $this->option('batch-size');

        $this->info("Buscando CDRs pendentes (Limite: {$limit})...");

        // Conta total de pendentes
        $totalPendentes = Cdr::where('status', 'Pendente')->count();

        if ($totalPendentes === 0) {
            $this->info("Nenhum CDR pendente encontrado.");
            return 0;
        }

        // Limita ao valor especificado
        $totalToProcess = min($totalPendentes, $limit);

        $this->info("Encontrados {$totalPendentes} CDRs pendentes. Processando {$totalToProcess}...");

        // Calcula número de batches
        $batches = ceil($totalToProcess / $batchSize);

        $this->info("Despachando {$batches} jobs de processamento em batch (batch size: {$batchSize})...");

        $bar = $this->output->createProgressBar($batches);
        $bar->start();

        for ($i = 0; $i < $batches; $i++) {
            $offset = $i * $batchSize;
            ProcessCdrBatchJob::dispatch($batchSize, null, $offset);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ {$batches} jobs de batch despachados com sucesso! O processamento ocorrerá em background.");
        $this->info("   Cada job processará até {$batchSize} CDRs.");

        return 0;
    }
}
