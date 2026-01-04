<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::view('/', 'dashboard')->name('dashboard');
    Route::get('/config/user', 'App\Http\Controllers\Config\UserController@index')->name('config.user');
    Route::get('/config/customer', 'App\Http\Controllers\Config\CustomerController@index')->name('config.customer');
    Route::get('/config/carrier', 'App\Http\Controllers\Config\CarrierController@index')->name('config.carrier');
    Route::get('/config/did', \App\Livewire\Dids\ListCustomersForDids::class)->name('config.did');
    Route::get('/config/rate', 'App\Http\Controllers\Config\RateController@index')->name('config.rate');
    Route::get('/config/audio', \App\Livewire\Config\Audio\Index::class)->name('config.audio');
    Route::get('/config/reseller', \App\Livewire\Resellers\Index::class)->name('config.reseller');
    Route::get('/config/reseller/create', \App\Livewire\Resellers\Create::class)->name('config.reseller.create');
    Route::get('/config/reseller/{id}/update', \App\Livewire\Resellers\Update::class)->name('config.reseller.update');
    Route::get('/audio/play/{id}', function ($id) {
        $audio = \App\Models\Audio::findOrFail($id);

        // Decode hex content from PostgreSQL bytea
        // PostgreSQL returns bytea as \x followed by hex string
        $binaryContent = $audio->content;

        // If content starts with \x, it's hex encoded
        if (is_resource($binaryContent)) {
            // If it's a resource (stream), read it
            $binaryContent = stream_get_contents($binaryContent);
        }

        // Convert from hex to binary if needed
        if (is_string($binaryContent) && str_starts_with($binaryContent, '\x')) {
            $hexString = substr($binaryContent, 2); // Remove \x prefix
            $binaryContent = hex2bin($hexString);
        }

        return response($binaryContent)
            ->header('Content-Type', $audio->mime_type)
            ->header('Content-Length', strlen($binaryContent))
            ->header('Accept-Ranges', 'bytes')
            ->header('Content-Disposition', 'inline; filename="' . $audio->filename . '"');
    })->name('audio.play');

    Route::get('/report/cdr', 'App\Http\Controllers\Report\CdrController@index')->name('report.cdr');

    // Alertas
    Route::get('/alerts', 'App\Http\Controllers\AlertController@index')->name('alerts.index');

    // Faturas - Listagem por cliente (rota principal)
    Route::get('/report/invoice', \App\Livewire\Invoices\ListCustomers::class)->name('report.invoice');
    Route::get('/report/invoice/details/{id}', 'App\Http\Controllers\Report\InvoiceController@details')->name('report.invoice.details');

    Route::get('/report/carrier', \App\Livewire\Carriers\Reports\Index::class)->name('report.carrier');
    Route::get('/report/cost-allocation', \App\Livewire\Carriers\CostAllocation::class)->name('report.cost-allocation');
    Route::get('/report/quality-analysis', 'App\Http\Controllers\Report\QualityController@analysis')->name('report.quality-analysis');
    Route::get('/report/profitability', 'App\Http\Controllers\Report\ProfitabilityController@index')->name('report.profitability');
    Route::get('/report/revenue-forecast', 'App\Http\Controllers\Report\ForecastController@revenue')->name('report.revenue-forecast');
    Route::get('/report/fraud-detection', 'App\Http\Controllers\Report\FraudController@detection')->name('report.fraud-detection');
    Route::get('/report/route-analysis', 'App\Http\Controllers\Report\RouteController@analysis')->name('report.route-analysis');

    Route::get('/dashboard/financial', \App\Livewire\Dashboard\Financial::class)->name('dashboard.financial');

    // Manutenção
    Route::get('/maintenance', \App\Livewire\Maintenance\Index::class)->name('maintenance.index');

    // Produtos e Serviços
    Route::get('/customers/products', \App\Livewire\Customers\Products\ListCustomers::class)->name('customers.products.list');
    Route::get('/customers/{customerId}/products', \App\Livewire\Customers\Products\Index::class)->name('customers.products');

    // Faturas por Cliente
    Route::get('/customers/invoices', \App\Livewire\Invoices\ListCustomers::class)->name('customers.invoices.list');
    Route::get('/customers/{customerId}/invoices', \App\Livewire\Invoices\CustomerInvoices::class)->name('customers.invoices');

    // DIDs por Cliente - Gestão detalhada
    Route::get('/customers/{customerId}/dids', \App\Livewire\Dids\ManageCustomerDids::class)->name('customers.dids');

    // Rotas para Revendas (área do reseller)
    Route::prefix('reseller')->name('reseller.')->group(function () {
        Route::get('/dashboard', \App\Livewire\Resellers\Dashboard::class)->name('dashboard');
        Route::get('/settings', \App\Livewire\Resellers\Settings::class)->name('settings');
        Route::get('/customers', \App\Livewire\Resellers\Customers::class)->name('customers');
        Route::get('/reports', \App\Livewire\Resellers\Reports::class)->name('reports');
    });

    Route::get('/services', function () {
        return view('dashboard');
    })->name('services');

    Route::get('/services/active', function () {
        return view('dashboard');
    })->name('services.active');

    Route::get('/orders', function () {
        return view('dashboard');
    })->name('orders');

    Route::get('/settings', function () {
        return view('dashboard');
    })->name('settings');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
