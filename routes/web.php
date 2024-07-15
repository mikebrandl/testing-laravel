<?php

use App\Http\Controllers\FruitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::apiResource('fruits', FruitController::class);
Route::patch('fruits/{fruit}', [FruitController::class, 'patch']);
