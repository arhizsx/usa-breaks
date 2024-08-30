<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/scheduled', function () {
        return view('scheduled');
    })->name('scheduled');

    Route::get('/scraped', function () {
        return view('scraped');
    })->name('scraped');

});
