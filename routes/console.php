<?php

use App\Jobs\ProcessCdrBatchJob;
use App\Jobs\MonthlyRevenueJob;
use App\Models\Cdr;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

//use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Agendamento de processamento de CDRs em batch a cada 10 minutos
Schedule::call(function () {
    $totalPendentes = Cdr::where('status', 'Pendente')->count();

    if ($totalPendentes === 0) {
        Log::info('Nenhum CDR pendente para processar');
        return;
    }

    Log::info("Iniciando processamento de {$totalPendentes} CDRs pendentes via scheduler");

    // Processa em batches de 1000
    $batchSize = 1000;
    $batches = ceil($totalPendentes / $batchSize);

    for ($i = 0; $i < $batches; $i++) {
        $offset = $i * $batchSize;
        ProcessCdrBatchJob::dispatch($batchSize, null, $offset);
    }

    Log::info("Despachados {$batches} jobs de processamento em batch");
})->everyTenMinutes();

// Processa batches pendentes de resumo mensal a cada 10 minutos
Schedule::command('revenue:flush-batches')->everyTenMinutes();

// A cada 10 minutos (qualquer horário, 24h)
//->cron('*/10 * * * *');

// A cada 30 minutos (qualquer horário)
//->cron('*/30 * * * *');

// A cada 1 hora (qualquer horário)
//->cron('0 * * * *');
// ou mais legível:
//->hourly();

// A cada 5 minutos
//->cron('*/5 * * * *');

// A cada 15 minutos
//->cron('*/15 * * * *');
//->cron('*/10 0-5 * * *');

// A cada 10 minutos, 24/7
//->everyTenMinutes();

// A cada 30 minutos, 24/7
//->everyThirtyMinutes();

// De hora em hora
//->hourly();

// A cada 2 horas
//->cron('0 */2 * * *');

// A cada 10 minutos apenas durante horário comercial (8h-18h)
//->cron('*/10 8-18 * * *');

// A cada 10 minutos apenas em dias úteis
//->cron('*/10 * * * 1-5');

// Processa relatórios de operadora no primeiro dia de cada mês às 6h
Schedule::command('operadora:processar-mensal')->monthlyOn(1, '06:00');

// Fecha faturas e relatórios do mês anterior no dia 3 de cada mês às 7h
Schedule::command('fatura:fechar-mensal')->monthlyOn(3, '07:00');

// Verifica alertas (fraude, pico de canais) a cada hora
Schedule::command('alerts:check')->hourly();

//->everyMinute();

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
