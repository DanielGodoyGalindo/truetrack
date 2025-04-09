<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\RepartoController;
use App\Http\Controllers\VehiculoController;
use Illuminate\Support\Facades\Route;

/* Route::get('/', function () {
    return view('index');
})->name('index'); */

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
Route::resource('envios', EnvioController::class)->middleware('auth');
Route::resource('repartos', RepartoController::class)->middleware('auth');
Route::resource('vehiculos', VehiculoController::class)->middleware('auth');

// Se pasa el parametro del id para saber cual es el envio del que se quiere mandar un email
Route::post('/envios/mail/{id}', [EnvioController::class, 'email'])->middleware('auth')->name('envios.email');
Route::post('/envios/send-email', [EnvioController::class, 'sendEmail'])->middleware('auth')->name('envios.sendEmail');
Route::post('/envios/anular/{id}', [EnvioController::class, 'setNull'])->middleware('auth')->name('envios.setNull');

// Ruta para devolver el número de envios y repartos totales
Route::get('/', [EnvioController::class, 'showDatosIndex'])->name('index');
/* Ruta para devolver el número de repartos totales */
// Route::get('/', [RepartoController::class, 'showNumRepartos'])->name('index');

// Ruta para añadir envios a un reparto, se pasa el id del reparto en el que el usuario ha hecho clic en la vista repartos.all
Route::post('/repartos/addDeliveries/{id}', [RepartoController::class, 'addDeliveries'])->middleware('auth')->name('repartos.addDeliveries');
// Ruta para actualizar la vista repartos.deliveries (para ver cómo se van asignando / sacando loe envios de un reparto)
Route::get('/repartos/{id}/showDeliveries', [RepartoController::class, 'showDeliveries'])->middleware('auth')->name('repartos.showDeliveries');
// Ruta para usar en el botón de asignar envío a un reparto
Route::post('/repartos/{id}/asignar', [RepartoController::class, 'assignDelivery'])->middleware('auth')->name('repartos.asignar');
// Ruta para usar en el botón de quitar un envío de un reparto
Route::post('/repartos/{id}/removeDelivery', [RepartoController::class, 'removeFromDelivery'])->middleware('auth')->name('repartos.removeFromDelivery');

require __DIR__ . '/auth.php';
