<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test',  [DataController::class, 'api_test']);

Route::get('/card-update/{card_id}/{status}',  [DataController::class, 'cardUpdate']);

Route::post('/apipost',  [DataController::class, 'api']);
