<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetFailedTariffsCommand extends Command
{
    protected $signature = 'tariff:reset-failed
                            {--status=* : Status to reset (Erro_Permanente, Dados_Invalidos, Tarifa_Nao_Encontrada)}
                            {--all : Reset all error statuses}';

    protected $description = 'Reset failed CDR tariff statuses back to Pendente for reprocessing';

    public function handle()
    {
        $statusesToReset = $this->option('all')
            ? ['Erro_Permanente', 'Dados_Invalidos', 'Tarifa_Nao_Encontrada', 'Erro_Tarifa']
            : $this->option('status');

        if (empty($statusesToReset)) {
            $this->error('Please specify --status or --all');
            return 1;
        }

        // Show current counts
        $this->info('Current status counts:');
        $counts = DB::table('cdrs')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->orderBy('total', 'desc')
            ->get();

        $this->table(['Status', 'Count'], $counts->map(fn($c) => [$c->status, $c->total]));

        // Calculate affected records
        $toUpdate = DB::table('cdrs')
            ->whereIn('status', $statusesToReset)
            ->count();

        if ($toUpdate === 0) {
            $this->info('No records to update.');
            return 0;
        }

        $this->warn("About to reset {$toUpdate} CDRs from [" . implode(', ', $statusesToReset) . "] to Pendente");

        if (!$this->option('no-interaction') && !$this->confirm('Continue?')) {
            $this->info('Cancelled.');
            return 0;
        }

        // Perform update
        $updated = DB::table('cdrs')
            ->whereIn('status', $statusesToReset)
            ->update(['status' => 'Pendente']);

        $this->info("✅ Successfully updated {$updated} CDRs to Pendente");

        // Show updated counts
        $this->info("\nUpdated status counts:");
        $newCounts = DB::table('cdrs')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->orderBy('total', 'desc')
            ->get();

        $this->table(['Status', 'Count'], $newCounts->map(fn($c) => [$c->status, $c->total]));

        return 0;
    }
}
