<?php

namespace App\Services;

use App\Models\Rate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RateCacheService
{
    private const CACHE_TTL = 3600; // 1 hora
    private const CACHE_PREFIX = 'rate';

    /**
     * Busca rate com cache
     */
    public function findRate(int $carrierId, string $tarifa, string $numero): ?Rate
    {
        $cacheKey = $this->getCacheKey($carrierId, $tarifa, $numero);

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($carrierId, $tarifa, $numero) {
            Log::debug('Rate cache miss', [
                'carrier_id' => $carrierId,
                'tarifa' => $tarifa,
                'numero_prefix' => substr($numero, 0, 5)
            ]);

            return $this->queryRate($carrierId, $tarifa, $numero);
        });
    }

    /**
     * Pré-carrega rates para um grupo de CDRs
     */
    public function preloadRates(iterable $cdrs): array
    {
        $rates = [];
        $toFetch = [];

        foreach ($cdrs as $cdr) {
            $cacheKey = $this->getCacheKey($cdr->carrier_id, $cdr->tarifa, $cdr->numero);

            // Tenta buscar do cache primeiro
            $rate = Cache::get($cacheKey);

            if ($rate !== null) {
                $rates[$cacheKey] = $rate;
            } else {
                $toFetch[] = [
                    'cdr' => $cdr,
                    'key' => $cacheKey
                ];
            }
        }

        // Busca em lote as que não estavam em cache
        foreach ($toFetch as $item) {
            $cdr = $item['cdr'];
            $rate = $this->queryRate($cdr->carrier_id, $cdr->tarifa, $cdr->numero);

            if ($rate) {
                Cache::put($item['key'], $rate, self::CACHE_TTL);
                $rates[$item['key']] = $rate;
            }
        }

        Log::info('Rates preloaded', [
            'total' => count($cdrs),
            'cache_hits' => count($rates) - count($toFetch),
            'cache_misses' => count($toFetch),
            'hit_rate' => count($cdrs) > 0 ? round(((count($rates) - count($toFetch)) / count($cdrs)) * 100, 2) : 0
        ]);

        return $rates;
    }

    /**
     * Invalida cache de uma rate específica
     */
    public function invalidate(Rate $rate): void
    {
        // Remove todas as variações de prefixo
        $patterns = $this->generatePrefixPatterns($rate->prefixo ?? '');

        $cleared = 0;
        foreach ($patterns as $pattern) {
            $key = sprintf('%s:%d:%s:%s',
                self::CACHE_PREFIX,
                $rate->carrier_id,
                $rate->tarifa,
                md5($pattern)
            );

            if (Cache::forget($key)) {
                $cleared++;
            }
        }

        Log::info('Rate cache invalidated', [
            'rate_id' => $rate->id,
            'carrier_id' => $rate->carrier_id,
            'tarifa' => $rate->tarifa,
            'patterns_checked' => count($patterns),
            'keys_cleared' => $cleared
        ]);
    }

    /**
     * Invalida todo o cache de rates
     */
    public function invalidateAll(): void
    {
        // Flush apenas as chaves com o prefixo
        $pattern = self::CACHE_PREFIX . ':*';

        Log::warning('Invalidating all rate cache', [
            'pattern' => $pattern
        ]);

        // No Redis, podemos usar SCAN para encontrar chaves
        // Por simplicidade, vamos flush geral (ajustar se necessário)
        Cache::tags(['rates'])->flush();
    }

    /**
     * Gera chave de cache
     */
    private function getCacheKey(int $carrierId, string $tarifa, string $numero): string
    {
        // Usa hash do número para não expor dados sensíveis
        $numeroHash = md5($numero);

        return sprintf('%s:%d:%s:%s',
            self::CACHE_PREFIX,
            $carrierId,
            $tarifa,
            $numeroHash
        );
    }

    /**
     * Query otimizada para buscar rate
     */
    private function queryRate(int $carrierId, string $tarifa, string $numero): ?Rate
    {
        return Rate::where('carrier_id', $carrierId)
            ->where('tarifa', $tarifa)
            ->where('ativo', true)
            ->where(function ($query) use ($numero) {
                $query->whereRaw('? LIKE prefixo || \'%\'', [$numero])
                    ->orWhereNull('prefixo');
            })
            ->orderByRaw('LENGTH(COALESCE(prefixo, \'\')) DESC')
            ->first();
    }

    /**
     * Gera padrões de prefixo para invalidação
     */
    private function generatePrefixPatterns(string $prefixo): array
    {
        if (empty($prefixo)) {
            return [''];
        }

        $patterns = [];
        $len = strlen($prefixo);

        // Gera todos os possíveis números que podem fazer match
        // Ex: prefixo "119" → pode fazer match com qualquer número 119*
        for ($i = 1; $i <= $len; $i++) {
            $patterns[] = substr($prefixo, 0, $i);
        }

        return $patterns;
    }

    /**
     * Retorna estatísticas do cache
     */
    public function getStats(): array
    {
        // Implementar contadores se necessário
        return [
            'cache_ttl' => self::CACHE_TTL,
            'cache_prefix' => self::CACHE_PREFIX,
        ];
    }
}
