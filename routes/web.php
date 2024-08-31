<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/scheduled', function () {
        return view('scheduled');
    })->name('scheduled');

    Route::get('/processed', function () {
        return view('scraped');
    })->name('scraped');

    Route::get('/orders', function () {
        return view('orders');
    })->name('orders');



    Route::get('/data/{action}',  [DataController::class, 'data']);

    Route::post('/data/post',  [DataController::class, 'data_post']);

});
