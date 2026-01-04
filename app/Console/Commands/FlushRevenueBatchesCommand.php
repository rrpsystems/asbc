<?php

namespace App\Console\Commands;

use App\Services\RevenueBatchDispatcher;
use Illuminate\Console\Command;

class FlushRevenueBatchesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'revenue:flush-batches
                            {--stats : Mostrar estatísticas dos batches pendentes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processa todos os batches de resumo mensal pendentes';

    /**
     * Execute the console command.
     */
    public function handle(RevenueBatchDispatcher $dispatcher): int
    {
        if ($this->option('stats')) {
            $this->showStats($dispatcher);
            return self::SUCCESS;
        }

        $this->info('Processando batches pendentes de resumo mensal...');

        try {
            $dispatcher->flushPendingBatches();
            $this->info('✅ Batches processados com sucesso!');
            return self::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Erro ao processar batches: {$e->getMessage()}");
            $this->error($e->getTraceAsString());
            return self::FAILURE;
        }
    }

    /**
     * Mostra estatísticas dos batches pendentes
     */
    private function showStats(RevenueBatchDispatcher $dispatcher): void
    {
        $this->info('📊 Estatísticas de Batches Pendentes');
        $this->line('');

        $stats = $dispatcher->getPendingBatchesStats();

        $this->table(
            ['Métrica', 'Valor'],
            [
                ['Total de Batches', $stats['total_batches']],
                ['Total de CDRs Pendentes', $stats['total_cdrs']],
            ]
        );

        if (!empty($stats['batches'])) {
            $this->line('');
            $this->info('Detalhes dos Batches:');

            $this->table(
                ['Customer ID', 'Mês', 'Ano', 'CDRs no Batch'],
                array_map(function ($batch) {
                    return [
                        $batch['customer_id'],
                        $batch['mes'],
                        $batch['ano'],
                        $batch['cdrs_count'],
                    ];
                }, $stats['batches'])
            );
        }
    }
}
