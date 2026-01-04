<?php

namespace App\Console\Commands;

use App\Models\Cdr;
use App\Services\CallTariffService;
use Illuminate\Console\Command;

class TestTariffCommand extends Command
{
    protected $signature = 'tariff:test {cdr_id}';
    protected $description = 'Test tariff calculation for a specific CDR';

    public function handle(CallTariffService $tariffService)
    {
        $cdrId = $this->argument('cdr_id');
        $cdr = Cdr::find($cdrId);

        if (!$cdr) {
            $this->error("CDR {$cdrId} not found");
            return 1;
        }

        $this->info("Testing CDR {$cdrId}:");
        $this->table(
            ['Field', 'Value'],
            [
                ['ID', $cdr->id],
                ['Carrier', $cdr->carrier_id],
                ['Tarifa', $cdr->tarifa],
                ['Numero', $cdr->numero],
                ['Billsec', $cdr->billsec],
                ['Status', $cdr->status],
            ]
        );

        try {
            $result = $tariffService->calcularTarifa($cdr);

            $this->info("\nSUCCESS! Tariff calculated:");
            $this->table(
                ['Field', 'Value'],
                [
                    ['Compra', $result['compra']],
                    ['Venda', $result['venda']],
                    ['Tempo Cobrado', $result['tempo_cobrado']],
                    ['Rate ID', $result['rate_id']],
                ]
            );

            return 0;

        } catch (\Exception $e) {
            $this->error("\nERROR: " . $e->getMessage());
            $this->error("Class: " . get_class($e));
            $this->error("File: " . $e->getFile() . ':' . $e->getLine());

            if ($this->option('verbose')) {
                $this->error("\nStack trace:");
                $this->line($e->getTraceAsString());
            }

            return 1;
        }
    }
}
