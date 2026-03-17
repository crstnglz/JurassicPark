<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('cells', CellController::class);
    Route::apiResource('dinosaurs', DinosaurController::class);
    Route::apiResource('users', UserController::class);

    Route::post('/simulation/normal', [SimulationController::class, 'normal']);
    Route::post('/simulation/breach', [SimulationController::class, 'breach']);
});
