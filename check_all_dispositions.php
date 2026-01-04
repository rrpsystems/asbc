<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Busca todos os valores únicos de disposition
$dispositions = \Illuminate\Support\Facades\DB::table('cdrs')
    ->select('disposition', \DB::raw('COUNT(*) as total'))
    ->groupBy('disposition')
    ->orderBy('total', 'desc')
    ->get();

echo "Todos os valores de DISPOSITION no banco:\n";
echo str_repeat("=", 60) . "\n";

foreach ($dispositions as $disp) {
    $percentage = 0; // Você pode calcular a porcentagem se quiser
    echo sprintf("%-30s | Total: %8d\n",
        "'{$disp->disposition}'",
        $disp->total
    );
}

echo str_repeat("=", 60) . "\n";
echo "Total de tipos diferentes: " . $dispositions->count() . "\n";
