<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$calls = \App\Models\Cdr::orderBy('calldate', 'desc')->limit(10)->get(['disposition', 'calldate']);

echo "Últimas 10 chamadas:\n";
foreach ($calls as $call) {
    echo "Data: {$call->calldate} - Disposition: '{$call->disposition}'\n";
}
