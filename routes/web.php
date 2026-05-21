<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoriaServicioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas públicas (autenticación)
|--------------------------------------------------------------------------
*/

// La raíz redirige al dashboard si hay sesión, o al login si no.
Route::get('/', fn () => redirect()->route(Auth::check() ? 'dashboard' : 'login'));

// Login y registro: solo accesibles para invitados (sin sesión).
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('register');
    Route::post('/registro', [AuthController::class, 'registrar']);
});

// Cierre de sesión.
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rutas protegidas (requieren sesión iniciada)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Panel principal según el rol.
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD de cada módulo. El control fino por rol está en cada controlador
    // (HasMiddleware) y, para usuarios, restringido a Administrador.
    Route::resource('usuarios', UserController::class)
        ->parameters(['usuarios' => 'usuario']);

    Route::resource('eventos', EventoController::class)
        ->parameters(['eventos' => 'evento']);

    Route::resource('categorias', CategoriaServicioController::class)
        ->parameters(['categorias' => 'categoria']);

    Route::resource('proveedores', ProveedorController::class)
        ->parameters(['proveedores' => 'proveedor']);

    Route::resource('servicios', ServicioController::class)
        ->parameters(['servicios' => 'servicio']);

    Route::resource('reservas', ReservaController::class)
        ->parameters(['reservas' => 'reserva']);

    Route::resource('pagos', PagoController::class)
        ->parameters(['pagos' => 'pago']);
});
