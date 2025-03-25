<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\RepartoController;
use App\Http\Controllers\VehiculoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas con método resource, el middleware de auth indica que sólo se puede acceder si el usuario está autenticado
Route::resource('users', UserController::class)->middleware('auth');
Route::resource('envios', EnvioController::class);
Route::resource('repartos', RepartoController::class)->middleware('auth');
Route::resource('vehiculos', VehiculoController::class)->middleware('auth');

require __DIR__ . '/auth.php';
