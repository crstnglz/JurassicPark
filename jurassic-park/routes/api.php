<?php

use App\Http\Controllers\CeldaController;
use App\Http\Controllers\CloudinaryController;
use App\Http\Controllers\DinosaurioController;
use App\Http\Controllers\SimulacionController;
use App\Http\Controllers\TareaController;
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
    Route::get('/users/count', [UserController::class, 'count']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::put('/users/{id}', [UserController::class, 'update']);

    Route::post('/subircloud', [CloudinaryController::class, 'subirImagenCloud']);
    Route::post('/update-password', [AuthController::class, 'updatePassword']);

    //CRUD CELDAS
    Route::get('/celdas', [CeldaController::class, 'index']);
    Route::post('/celdas', [CeldaController::class, 'store']);
    Route::get('/celdas/count', [CeldaController::class, 'count']);
    Route::get('/celdas/{id}', [CeldaController::class, 'show']);
    Route::put('/celdas/{id}', [CeldaController::class, 'update']);
    Route::delete('/celdas/{id}', [CeldaController::class, 'destroy']);

    //CRUD DINO
    Route::get('/dinosaurios', [DinosaurioController::class, 'index']);
    Route::post('/dinosaurios', [DinosaurioController::class, 'store']);
    Route::get('/dinosaurios/count', [DinosaurioController::class, 'count']);
    Route::get('/dinosaurios/{id}', [DinosaurioController::class, 'show']);
    Route::put('/dinosaurios/{id}', [DinosaurioController::class, 'update']);
    Route::delete('/dinosaurios/{id}', [DinosaurioController::class, 'destroy']);
    Route::post('/dinosaurios/{id}/asignar', [DinosaurioController::class, 'asignar']);

    //CRUD TAREAS
    Route::get('/tareas', [TareaController::class, 'index']);
    Route::post('/tareas', [TareaController::class, 'store']);
    Route::put('/tareas/{id}/estado', [TareaController::class, 'cambiarEstado']);
    Route::delete('/tareas/{id}', [TareaController::class, 'destroy']);

    //SIMULACIONES
    Route::post('/simulacion/normal', [SimulacionController::class, 'simularNormal']);
    Route::post('/simulacion/brecha', [SimulacionController::class, 'simularBrecha']);
});


