<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\UnidadNegocioController;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\GerenciaController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\PuestoController;
use App\Http\Controllers\EmpleadoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard')->can('ver-dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Módulo de Usuarios
    Route::resource('users', UserController::class);

    // Módulo de Roles
    Route::resource('roles', RoleController::class);

    // Módulo de Permisos
    Route::resource('permissions', PermissionController::class);

    // Catálogos - Estructura Organizacional (relación: División → Unidad de Negocio → Dirección → Gerencia → Área → Puesto)
    Route::resource('divisiones', DivisionController::class)->parameters(['divisiones' => 'divisione']);
    Route::resource('unidades-negocio', UnidadNegocioController::class)->parameters(['unidades-negocio' => 'unidadNegocio']);
    Route::resource('direcciones', DireccionController::class)->parameters(['direcciones' => 'direccione']);
    Route::resource('gerencias', GerenciaController::class);
    Route::resource('areas', AreaController::class);
    Route::resource('puestos', PuestoController::class);

    // Empleados
    Route::resource('empleados', EmpleadoController::class)->except(['show']);
});

require __DIR__.'/auth.php';
