<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$calls = \App\Models\Cdr::where('customer_id', 2)
    ->whereMonth('calldate', 12)
    ->whereYear('calldate', 2025)
    ->where('tarifa', 'Internacional')
    ->where('cobrada', 'S')
    ->select('id', 'calldate', 'numero', 'tempo_cobrado', 'valor_venda', 'cobrada')
    ->get();

echo "Total DDI cobradas: " . $calls->count() . "\n\n";

foreach ($calls as $call) {
    echo "ID: {$call->id}, Data: {$call->calldate}, Número: {$call->numero}, ";
    echo "Tempo: {$call->tempo_cobrado}s, Valor: R$ {$call->valor_venda}, Cobrada: {$call->cobrada}\n";
}
