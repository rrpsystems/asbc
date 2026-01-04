<?php

namespace App\Observers;

use App\Models\Rate;
use App\Services\RateCacheService;
use Illuminate\Support\Facades\Log;

class RateObserver
{
    public function __construct(
        private readonly RateCacheService $rateCache
    ) {}

    /**
     * Handle the Rate "created" event.
     */
    public function created(Rate $rate): void
    {
        Log::info('Nova tarifa criada', [
            'rate_id' => $rate->id,
            'carrier_id' => $rate->carrier_id,
            'tarifa' => $rate->tarifa,
            'prefixo' => $rate->prefixo
        ]);

        // Não precisa invalidar cache para novo registro
    }

    /**
     * Handle the Rate "updated" event.
     */
    public function updated(Rate $rate): void
    {
        Log::info('Tarifa atualizada, invalidando cache', [
            'rate_id' => $rate->id,
            'carrier_id' => $rate->carrier_id,
            'tarifa' => $rate->tarifa,
            'prefixo' => $rate->prefixo
        ]);

        $this->rateCache->invalidate($rate);
    }

    /**
     * Handle the Rate "deleted" event.
     */
    public function deleted(Rate $rate): void
    {
        Log::warning('Tarifa deletada, invalidando cache', [
            'rate_id' => $rate->id,
            'carrier_id' => $rate->carrier_id,
            'tarifa' => $rate->tarifa,
            'prefixo' => $rate->prefixo
        ]);

        $this->rateCache->invalidate($rate);
    }

    /**
     * Handle the Rate "saving" event (antes de salvar).
     * Atualiza prefix_length automaticamente
     */
    public function saving(Rate $rate): void
    {
        // Atualiza prefix_length automaticamente
        $rate->prefix_length = strlen($rate->prefixo ?? '');
    }
}
