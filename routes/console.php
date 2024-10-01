<?php

use App\Jobs\CallTariffJob;
use App\Models\Cdr;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

//use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Agendamento de tarefas
Schedule::call(function () {
    // Cdr::where('status', 'Processada')->chunk(1000, function ($cdrs) {
    Cdr::chunk(1000, function ($cdrs) {
        foreach ($cdrs as $cdr) {
            CallTariffJob::dispatch($cdr);
        }
    });
})->everyMinute();

// Artisan::command('schedule:work', function (Schedule $schedule) {
//     // Processa as chamadas pendentes a cada 10 minutos
//     $schedule->call(function () {
//         Cdr::where('status', 'Pendente')->chunk(100, function ($cdrs) {
//             foreach ($cdrs as $cdr) {
//                 CallTariffJob::dispatch($cdr);
//             }
//         });
//     })->everyTenMinutes();
// });
