<?php

use App\Http\Controllers\CeldaController;
use App\Http\Controllers\CloudinaryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function() {
        return auth()->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    //CRUD USER
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::put('/users/{id}', [UserController::class, 'update']);

    Route::post('/subircloud', [CloudinaryController::class, 'subirImagenCloud']);
    Route::post('/update-password', [AuthController::class, 'updatePassword']);

    //CRUD CELDAS
    Route::get('/celdas', [CeldaController::class, 'inder']);
    Route::post('/celdas', [CeldaController::class, 'store']);
    Route::get('/celdas/{id}', [CeldaController::class, 'show']);
    Route::put('/celdas/{id}', [CeldaController::class, 'update']);
    Route::delete('/celdas/{id}', [CeldaController::class, 'destroy']);
});
