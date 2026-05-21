<?php

use App\Http\Controllers\Api\AuthApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas de la API (servicio web) - prefijo /api
|--------------------------------------------------------------------------
| Servicio web de autenticación del proyecto ADOESC. Expone dos endpoints
| que reciben usuario/contraseña y responden en formato JSON.
*/

// Servicio de registro de un nuevo usuario.
Route::post('/registro', [AuthApiController::class, 'registro']);

// Servicio de inicio de sesión (autenticación).
Route::post('/login', [AuthApiController::class, 'login']);
