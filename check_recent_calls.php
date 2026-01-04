<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Busca as 10 últimas chamadas
$calls = \App\Models\Cdr::with(['customer', 'carrier'])
    ->orderBy('calldate', 'desc')
    ->limit(10)
    ->get();

echo "Últimas 10 chamadas do banco:\n";
echo str_repeat("=", 100) . "\n";

foreach ($calls as $call) {
    echo sprintf(
        "Data: %s | Cliente: %-20s | Destino: %-12s | Duração: %5ds | Disposition: '%s'\n",
        $call->calldate,
        substr($call->customer->razaosocial ?? 'N/A', 0, 20),
        $call->numero,
        $call->billsec,
        $call->disposition
    );
}

echo str_repeat("=", 100) . "\n";
