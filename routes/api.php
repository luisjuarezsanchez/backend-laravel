<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\API\PersonaController;


// Rutas de Login de la app
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Rutas de transferencia de archivo
Route::post('/upload', [FileUploadController::class, 'upload']);

// Ruta de consulta de data
Route::get('/personas', [PersonaController::class, 'getPersonasPaginated']);

// Ruta para vaciar las tablas
Route::delete('/personas/delete-all', [PersonaController::class, 'deleteAll']);
