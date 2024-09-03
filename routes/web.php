<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\DownloadController;

Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/queued', function () {
        return view('queued');
    })->name('queued');

    Route::get('/processed', function () {
        return view('scraped');
    })->name('scraped');

    Route::get('/orders', function () {
        return view('orders');
    })->name('orders');

    Route::get('/data/{action}',  [DataController::class, 'data']);

    Route::post('/data/post',  [DataController::class, 'data_post']);


});
