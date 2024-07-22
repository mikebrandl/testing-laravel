<?php

use App\Http\Controllers\FruitController;
use App\Http\Controllers\FruitControllerWithRepository;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::apiResource('fruit', FruitController::class);
Route::patch('fruit/{fruit}', [FruitController::class, 'patch']);

Route::apiResource('repo/fruit', FruitControllerWithRepository::class);
Route::patch('repo/fruit/{fruit}', [FruitControllerWithRepository::class, 'patch']);
