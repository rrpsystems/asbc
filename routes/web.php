<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::view('/', 'dashboard')->name('dashboard');
    Route::get('/config/user', 'App\Http\Controllers\Config\UserController@index')->name('config.user');
    Route::get('/config/customer', 'App\Http\Controllers\Config\CustomerController@index')->name('config.customer');
    Route::get('/config/carrier', 'App\Http\Controllers\Config\CarrierController@index')->name('config.carrier');
    Route::get('/config/did', 'App\Http\Controllers\Config\DidController@index')->name('config.did');
    Route::get('/config/rate', 'App\Http\Controllers\Config\RateController@index')->name('config.rate');

    Route::get('/report/cdr', 'App\Http\Controllers\Report\CdrController@index')->name('report.cdr');
    Route::get('/report/invoice', 'App\Http\Controllers\Report\InvoiceController@index')->name('report.invoice');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

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

require __DIR__.'/auth.php';
