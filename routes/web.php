<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ImageDownloadController;

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

    Route::get('/failed', function () {
        return view('failed');
    })->name('failed');

    Route::get('/noimg', function () {
        return view('noimg');
    })->name('noimg');

    Route::get('/orders', function () {
        return view('orders');
    })->name('orders');

    Route::get('/data/{action}',  [DataController::class, 'data']);

    Route::post('/data/post',  [DataController::class, 'data_post']);

    Route::get('/download/{order_id}',  [DataController::class, 'download']);

    Route::get('/download-images/{order_id}', [ImageDownloadController::class, 'downloadImages']);

    Route::get('/test-storage', function () {
        $filePath = storage_path('app/test.txt');
        try {
            file_put_contents($filePath, 'This is a test.');
            return response()->json(['message' => 'Storage is writable']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    });

});

