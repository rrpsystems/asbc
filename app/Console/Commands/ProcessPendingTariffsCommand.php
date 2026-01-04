<?php

namespace App\Console\Commands;

use App\Models\Cdr;
use App\Services\CallTariffService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ProcessPendingTariffsCommand extends Command
{
    protected $signature = 'tariff:process-pending
                            {--batch-size=1000 : Number of CDRs to process per batch}
                            {--limit= : Maximum number of CDRs to process (optional)}
                            {--carrier= : Process only specific carrier_id (optional)}';

    protected $description = 'Process pending CDRs in efficient batches (no queue)';

    private int $processedCount = 0;
    private int $successCount = 0;
    private int $errorCount = 0;
    private array $errorsByType = [];

    public function handle(CallTariffService $tariffService)
    {
        $batchSize = (int) $this->option('batch-size');
        $limit = $this->option('limit') ? (int) $this->option('limit') : null;
        $carrierId = $this->option('carrier');

        $this->info("🚀 Iniciando processamento de CDRs pendentes");
        $this->info("📊 Tamanho do lote: {$batchSize}");
        if ($limit) {
            $this->info("📊 Limite: {$limit} CDRs");
        }
        if ($carrierId) {
            $this->info("📊 Carrier: {$carrierId}");
        }

        $startTime = microtime(true);

        // Conta total de pendentes
        $query = Cdr::where('status', 'Pendente');
        if ($carrierId) {
            $query->where('carrier_id', $carrierId);
        }
        $totalPending = $query->count();

        $this->info("📋 Total de CDRs pendentes: " . number_format($totalPending, 0, ',', '.'));

        if ($totalPending === 0) {
            $this->info("✅ Nenhum CDR pendente para processar");
            return 0;
        }

        // Processa em lotes
        $processedTotal = 0;
        $maxToProcess = $limit ?? $totalPending;

        $this->output->progressStart(min($maxToProcess, $totalPending));

        while ($processedTotal < $maxToProcess) {
            $currentBatchSize = min($batchSize, $maxToProcess - $processedTotal);

            $query = Cdr::where('status', 'Pendente');
            if ($carrierId) {
                $query->where('carrier_id', $carrierId);
            }

            $cdrs = $query->limit($currentBatchSize)->get();

            if ($cdrs->isEmpty()) {
                break;
            }

            $this->processBatch($cdrs, $tariffService);

            $processedTotal += $cdrs->count();
            $this->output->progressAdvance($cdrs->count());
        }

        $this->output->progressFinish();

        $duration = microtime(true) - $startTime;
        $this->showResults($duration);

        return 0;
    }

    private function processBatch($cdrs, CallTariffService $tariffService): void
    {
        $updates = [
            'Tarifada' => [],
            'Tarifa_Nao_Encontrada' => [],
            'Dados_Invalidos' => [],
            'Erro_Tarifa' => [],
        ];

        foreach ($cdrs as $cdr) {
            $this->processedCount++;

            try {
                // Calcula tarifa
                $result = $tariffService->calcularTarifa($cdr);

                // Adiciona ao batch de update
                $updates['Tarifada'][] = [
                    'id' => $cdr->id,
                    'valor_compra' => $result['compra'],
                    'valor_venda' => $result['venda'],
                    'tempo_cobrado' => $result['tempo_cobrado'],
                ];

                $this->successCount++;

            } catch (\App\Exceptions\Tariff\RateNotFoundException $e) {
                $updates['Tarifa_Nao_Encontrada'][] = ['id' => $cdr->id];
                $this->errorCount++;
                $this->errorsByType['Tarifa_Nao_Encontrada'] = ($this->errorsByType['Tarifa_Nao_Encontrada'] ?? 0) + 1;

            } catch (\App\Exceptions\Tariff\InvalidCdrDataException $e) {
                $updates['Dados_Invalidos'][] = ['id' => $cdr->id];
                $this->errorCount++;
                $this->errorsByType['Dados_Invalidos'] = ($this->errorsByType['Dados_Invalidos'] ?? 0) + 1;

            } catch (\Exception $e) {
                $updates['Erro_Tarifa'][] = ['id' => $cdr->id];
                $this->errorCount++;
                $this->errorsByType['Erro_Generico'] = ($this->errorsByType['Erro_Generico'] ?? 0) + 1;

                // Log apenas erros genéricos (inesperados)
                $this->warn("Erro ao processar CDR {$cdr->id}: " . $e->getMessage());
            }
        }

        // Aplica updates em bulk
        $this->applyBulkUpdates($updates);
    }

    private function applyBulkUpdates(array $updates): void
    {
        // Update CDRs tarifados
        if (!empty($updates['Tarifada'])) {
            foreach ($updates['Tarifada'] as $data) {
                DB::table('cdrs')
                    ->where('id', $data['id'])
                    ->update([
                        'status' => 'Tarifada',
                        'valor_compra' => $data['valor_compra'],
                        'valor_venda' => $data['valor_venda'],
                        'tempo_cobrado' => $data['tempo_cobrado'],
                        'updated_at' => now(),
                    ]);
            }
        }

        // Update CDRs com erro (apenas status)
        foreach (['Tarifa_Nao_Encontrada', 'Dados_Invalidos', 'Erro_Tarifa'] as $status) {
            if (!empty($updates[$status])) {
                $ids = array_column($updates[$status], 'id');
                DB::table('cdrs')
                    ->whereIn('id', $ids)
                    ->update([
                        'status' => $status,
                        'updated_at' => now(),
                    ]);
            }
        }
    }

    private function showResults(float $duration): void
    {
        $this->newLine(2);
        $this->info("═══════════════════════════════════════════════");
        $this->info("           📊 RESULTADO DO PROCESSAMENTO");
        $this->info("═══════════════════════════════════════════════");
        $this->newLine();

        $this->table(
            ['Métrica', 'Valor'],
            [
                ['Total Processados', number_format($this->processedCount, 0, ',', '.')],
                ['✅ Sucesso', number_format($this->successCount, 0, ',', '.')],
                ['❌ Erros', number_format($this->errorCount, 0, ',', '.')],
                ['⏱️  Tempo Total', round($duration, 2) . 's'],
                ['⚡ Velocidade', round($this->processedCount / $duration, 0) . ' CDRs/s'],
            ]
        );

        if (!empty($this->errorsByType)) {
            $this->newLine();
            $this->warn("Erros por Tipo:");
            $rows = [];
            foreach ($this->errorsByType as $type => $count) {
                $rows[] = [$type, number_format($count, 0, ',', '.')];
            }
            $this->table(['Tipo', 'Quantidade'], $rows);
        }

        $successRate = $this->processedCount > 0
            ? round(($this->successCount / $this->processedCount) * 100, 2)
            : 0;

        $this->newLine();
        $this->info("✅ Taxa de Sucesso: {$successRate}%");
        $this->info("═══════════════════════════════════════════════");
    }
}
