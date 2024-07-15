<?php

use App\Http\Controllers\FruitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::apiResource('fruit', FruitController::class);
Route::patch('fruit/{fruit}', [FruitController::class, 'patch']);
