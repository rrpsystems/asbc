<?php

namespace App\Services;

use App\Jobs\ProcessMonthlyRevenueBatch;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class RevenueBatchDispatcher
{
    private const BATCH_SIZE = 100;
    private const BATCH_TIMEOUT_SECONDS = 600; // 10 minutos
    private const LOCK_TIMEOUT = 10; // 10 segundos
    private const CACHE_DRIVER = 'redis'; // Força uso do Redis para batches

    /**
     * Adiciona um CDR ao batch pendente
     * Se o batch atingir o tamanho máximo, despacha automaticamente
     *
     * ESTRATÉGIA SIMPLIFICADA:
     * - Sempre processa IMEDIATAMENTE (não usa cache)
     * - Isso garante que revenue_summary_id seja preenchido instantaneamente
     * - Evita problemas com Redis/cache que estavam impedindo o processamento
     */
    public function addCdrToBatch(int $cdrId, int $customerId, int $mes, int $ano): void
    {
        try {
            // NOVA ABORDAGEM: Processa imediatamente ao invés de acumular em cache
            // Isso resolve o problema de batches que nunca eram processados
            $this->dispatchBatch($customerId, $mes, $ano, [$cdrId]);

            Log::debug('CDR processado imediatamente no batch de receita', [
                'cdr_id' => $cdrId,
                'customer_id' => $customerId,
                'mes' => $mes,
                'ano' => $ano,
            ]);

        } catch (\Exception $e) {
            Log::error('Erro ao processar CDR no batch de receita', [
                'cdr_id' => $cdrId,
                'customer_id' => $customerId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Adiciona múltiplos CDRs de uma vez ao batch de receita
     * Mais eficiente que chamar addCdrToBatch() múltiplas vezes
     *
     * @param array $cdrIds IDs dos CDRs tarifados
     * @param int $customerId ID do cliente
     * @param int $mes Mês (1-12)
     * @param int $ano Ano
     */
    public function addCdrBatchToPeriod(array $cdrIds, int $customerId, int $mes, int $ano): void
    {
        try {
            if (empty($cdrIds)) {
                return;
            }

            // Processa todos os CDRs de uma vez em um único job
            $this->dispatchBatch($customerId, $mes, $ano, $cdrIds);

            Log::info('Batch de CDRs processado para período', [
                'customer_id' => $customerId,
                'mes' => $mes,
                'ano' => $ano,
                'cdrs_count' => count($cdrIds),
            ]);

        } catch (\Exception $e) {
            Log::error('Erro ao processar batch de CDRs para período', [
                'customer_id' => $customerId,
                'mes' => $mes,
                'ano' => $ano,
                'cdrs_count' => count($cdrIds),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Processa todos os batches pendentes
     * Deve ser chamado periodicamente via schedule
     */
    public function flushPendingBatches(): void
    {
        $pattern = 'revenue_batch_pending:*';
        $processedCount = 0;

        Log::info('Iniciando flush de batches pendentes');

        try {
            // Tenta usar Redis scan se disponível
            if ($this->isRedisAvailable()) {
                $processedCount = $this->flushWithRedisScan($pattern);
            } else {
                // Fallback: usa abordagem com lista de chaves conhecidas
                $processedCount = $this->flushWithKnownKeys();
            }
        } catch (\Exception $e) {
            Log::error('Erro ao fazer flush de batches', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        Log::info('Flush de batches concluído', [
            'batches_processados' => $processedCount,
        ]);
    }

    /**
     * Flush usando Redis SCAN (mais eficiente)
     */
    private function flushWithRedisScan(string $pattern): int
    {
        $cursor = null;
        $processedCount = 0;

        do {
            // Scan retorna [cursor, keys]
            $result = Redis::scan($cursor, ['match' => $pattern, 'count' => 100]);

            // Se Redis::scan retornar null, interrompe o loop
            if ($result === null || $result === false) {
                break;
            }

            [$cursor, $keys] = $result;

            // Se $keys for null ou não for array, pula esta iteração
            if (!is_array($keys)) {
                continue;
            }

            foreach ($keys as $key) {
                // Remove prefixo do Redis se existir
                $key = str_replace('laravel_database_', '', $key);
                $key = str_replace('laravel_cache:', '', $key);

                $cdrIds = $this->getCacheStore()->get($key);

                if (empty($cdrIds)) {
                    $this->getCacheStore()->forget($key);
                    continue;
                }

                // Parse da key: revenue_batch_pending:{customerId}:{mes}:{ano}
                if (preg_match('/revenue_batch_pending:(\d+):(\d+):(\d+)/', $key, $matches)) {
                    $customerId = (int) $matches[1];
                    $mes = (int) $matches[2];
                    $ano = (int) $matches[3];

                    $this->dispatchBatch($customerId, $mes, $ano, $cdrIds);
                    $this->getCacheStore()->forget($key);
                    $processedCount++;

                    Log::info('Batch pendente processado no flush', [
                        'customer_id' => $customerId,
                        'mes' => $mes,
                        'ano' => $ano,
                        'cdrs_count' => count($cdrIds),
                    ]);
                }
            }
        } while ($cursor !== 0 && $cursor !== '0');

        return $processedCount;
    }

    /**
     * Flush usando lista de chaves conhecidas (fallback para database cache)
     */
    private function flushWithKnownKeys(): int
    {
        // Mantém lista de batches ativos em uma chave especial
        $activeKeys = $this->getCacheStore()->get('revenue_batch_active_keys', []);
        $processedCount = 0;

        foreach ($activeKeys as $index => $key) {
            $cdrIds = $this->getCacheStore()->get($key);

            if (empty($cdrIds)) {
                // Remove da lista de ativos
                unset($activeKeys[$index]);
                continue;
            }

            // Parse da key
            if (preg_match('/revenue_batch_pending:(\d+):(\d+):(\d+)/', $key, $matches)) {
                $customerId = (int) $matches[1];
                $mes = (int) $matches[2];
                $ano = (int) $matches[3];

                $this->dispatchBatch($customerId, $mes, $ano, $cdrIds);
                $this->getCacheStore()->forget($key);
                $processedCount++;

                // Remove da lista de ativos
                unset($activeKeys[$index]);

                Log::info('Batch pendente processado no flush', [
                    'customer_id' => $customerId,
                    'mes' => $mes,
                    'ano' => $ano,
                    'cdrs_count' => count($cdrIds),
                ]);
            }
        }

        // Atualiza lista de chaves ativas
        $this->getCacheStore()->put('revenue_batch_active_keys', array_values($activeKeys), now()->addDay());

        return $processedCount;
    }

    /**
     * Registra uma chave como ativa (usado quando database cache)
     */
    private function registerActiveKey(string $key): void
    {
        if ($this->isRedisAvailable()) {
            return; // Não precisa quando usa Redis
        }

        $activeKeys = $this->getCacheStore()->get('revenue_batch_active_keys', []);

        if (!in_array($key, $activeKeys)) {
            $activeKeys[] = $key;
            $this->getCacheStore()->put('revenue_batch_active_keys', $activeKeys, now()->addDay());
        }
    }

    /**
     * Despacha um batch para processamento
     */
    private function dispatchBatch(int $customerId, int $mes, int $ano, array $cdrIds): void
    {
        if (empty($cdrIds)) {
            return;
        }

        ProcessMonthlyRevenueBatch::dispatch($customerId, $mes, $ano, $cdrIds);

        Log::info('Revenue batch despachado', [
            'customer_id' => $customerId,
            'mes' => $mes,
            'ano' => $ano,
            'cdrs_count' => count($cdrIds),
        ]);
    }

    /**
     * Gera a chave do batch no cache
     */
    private function getBatchKey(int $customerId, int $mes, int $ano): string
    {
        $key = "revenue_batch_pending:{$customerId}:{$mes}:{$ano}";

        // Registra chave se usando database cache
        $this->registerActiveKey($key);

        return $key;
    }

    /**
     * Retorna estatísticas dos batches pendentes
     */
    public function getPendingBatchesStats(): array
    {
        $stats = [
            'total_batches' => 0,
            'total_cdrs' => 0,
            'batches' => [],
        ];

        try {
            if ($this->isRedisAvailable()) {
                $stats = $this->getStatsWithRedisScan();
            } else {
                $stats = $this->getStatsWithKnownKeys();
            }
        } catch (\Exception $e) {
            Log::error('Erro ao obter stats de batches', [
                'error' => $e->getMessage(),
            ]);
        }

        return $stats;
    }

    /**
     * Obtém stats usando Redis SCAN
     */
    private function getStatsWithRedisScan(): array
    {
        $pattern = 'revenue_batch_pending:*';
        $cursor = null;
        $stats = [
            'total_batches' => 0,
            'total_cdrs' => 0,
            'batches' => [],
        ];

        do {
            [$cursor, $keys] = Redis::scan($cursor, ['match' => $pattern, 'count' => 100]);

            foreach ($keys as $key) {
                $key = str_replace('laravel_database_', '', $key);
                $key = str_replace('laravel_cache:', '', $key);

                $cdrIds = $this->getCacheStore()->get($key);

                if (!empty($cdrIds)) {
                    $stats['total_batches']++;
                    $stats['total_cdrs'] += count($cdrIds);

                    if (preg_match('/revenue_batch_pending:(\d+):(\d+):(\d+)/', $key, $matches)) {
                        $stats['batches'][] = [
                            'customer_id' => (int) $matches[1],
                            'mes' => (int) $matches[2],
                            'ano' => (int) $matches[3],
                            'cdrs_count' => count($cdrIds),
                        ];
                    }
                }
            }
        } while ($cursor !== 0 && $cursor !== '0');

        return $stats;
    }

    /**
     * Obtém stats usando chaves conhecidas
     */
    private function getStatsWithKnownKeys(): array
    {
        $activeKeys = $this->getCacheStore()->get('revenue_batch_active_keys', []);

        // Garante que é um array
        if (!is_array($activeKeys)) {
            $activeKeys = [];
        }

        $stats = [
            'total_batches' => 0,
            'total_cdrs' => 0,
            'batches' => [],
        ];

        foreach ($activeKeys as $key) {
            $cdrIds = $this->getCacheStore()->get($key);

            if (!empty($cdrIds)) {
                $stats['total_batches']++;
                $stats['total_cdrs'] += count($cdrIds);

                if (preg_match('/revenue_batch_pending:(\d+):(\d+):(\d+)/', $key, $matches)) {
                    $stats['batches'][] = [
                        'customer_id' => (int) $matches[1],
                        'mes' => (int) $matches[2],
                        'ano' => (int) $matches[3],
                        'cdrs_count' => count($cdrIds),
                    ];
                }
            }
        }

        return $stats;
    }

    /**
     * Obtém o cache store apropriado (Redis se disponível)
     */
    private function getCacheStore()
    {
        try {
            // Tenta usar Redis se disponível
            return Cache::store(self::CACHE_DRIVER);
        } catch (\Exception $e) {
            // Fallback para cache padrão
            Log::warning('Redis não disponível, usando cache padrão para batches', [
                'error' => $e->getMessage(),
            ]);
            return Cache::store();
        }
    }

    /**
     * Verifica se Redis está disponível
     */
    private function isRedisAvailable(): bool
    {
        try {
            Redis::ping();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
