<?php

namespace App\Providers;

use App\Events\MonthlyRevenueUpdated;
use App\Listeners\CheckFranchiseAlert;
use App\Models\Rate;
use App\Observers\RateObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registra observer para invalidar cache quando Rate for atualizada
        Rate::observe(RateObserver::class);

        // Registra listener para verificar alertas de franquia quando resumo mensal for atualizado
        Event::listen(
            MonthlyRevenueUpdated::class,
            CheckFranchiseAlert::class
        );
    }
}
