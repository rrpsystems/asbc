<?php

namespace App\Listeners;

use App\Events\MonthlyRevenueUpdated;
use App\Services\AlertService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CheckFranchiseAlert implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly AlertService $alertService
    ) {}

    /**
     * Handle the event.
     */
    public function handle(MonthlyRevenueUpdated $event): void
    {
        try {
            $this->alertService->checkFranchiseUsage(
                $event->customerId,
                $event->mes,
                $event->ano
            );

            Log::info('Franchise alert check completed', [
                'customer_id' => $event->customerId,
                'mes' => $event->mes,
                'ano' => $event->ano,
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao verificar alertas de franquia', [
                'customer_id' => $event->customerId,
                'mes' => $event->mes,
                'ano' => $event->ano,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Não relança exceção para não travar a fila
            // Alertas não devem bloquear o processamento principal
        }
    }

    /**
     * Determine the time at which the listener should timeout.
     */
    public function retryUntil(): \DateTime
    {
        return now()->addMinutes(5);
    }

    /**
     * Handle a job failure.
     */
    public function failed(MonthlyRevenueUpdated $event, \Throwable $exception): void
    {
        Log::error('Franchise alert check failed permanently', [
            'customer_id' => $event->customerId,
            'mes' => $event->mes,
            'ano' => $event->ano,
            'error' => $exception->getMessage(),
        ]);
    }
}
