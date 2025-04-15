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


//////////////////////////
/* Rutas autenticación */
/////////////////////////

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//////////////////////////
/* Rutas transportistas */
//////////////////////////

// Ruta para que los transportistas vean sus repartos
Route::get('/repartosTransportista/{id}', [UserController::class, 'driverDistributions'])->middleware('auth')->name('driver.distributions');
// Ruta para mostrar los envíos dentro de un reparto para un transportista
Route::get('/repartoTransportista/{id}', [UserController::class, 'driverDeliveries'])->middleware('auth')->name('driver.deliveries');


///////////////////
/* Rutas varias */
//////////////////

// Ruta para devolver el número de envios y repartos totales
Route::get('/', [EnvioController::class, 'showDatosIndex'])->name('index');
// Ruta para mostrar los envios entregados y anulados
Route::get('/envios/completed', [EnvioController::class, 'showCompleted'])->middleware('auth')->name('envios.showCompleted');
// Ruta para mostrar los repartos completados (estado finalizado)
Route::get('/repartos/deliveriesCompleted', [RepartoController::class, 'showDeliveriesCompleted'])->middleware('auth')->name('repartos.showDeliveriesCompleted');


/////////////////////
/* Rutas resource */
////////////////////

// Rutas con método resource, el middleware de auth indica que sólo se puede acceder si el usuario está autenticado
Route::resource('users', UserController::class)->middleware('auth');
Route::resource('envios', EnvioController::class)->middleware('auth');
Route::resource('repartos', RepartoController::class)->middleware('auth');
Route::resource('vehiculos', VehiculoController::class)->middleware('auth');


///////////////////////////////
/* Rutas envíos no resource */
//////////////////////////////

// Se pasa el parametro del id para saber cual es el envio del que se quiere mandar un email
Route::post('/envios/mail/{id}', [EnvioController::class, 'email'])->middleware('auth')->name('envios.email');
Route::post('/envios/send-email', [EnvioController::class, 'sendEmail'])->middleware('auth')->name('envios.sendEmail');
Route::post('/envios/anular/{id}', [EnvioController::class, 'setNull'])->middleware('auth')->name('envios.setNull');
// Ruta para que Rol Transportista pueda actualizar el estado de un envío
Route::post('/envios/actualizar/{id}', [EnvioController::class, 'actualizarEnvio'])->name('envios.actualizar');


/////////////////////////////////
/* Rutas repartos no resource */
////////////////////////////////

// Ruta para añadir envios a un reparto, se pasa el id del reparto en el que el usuario ha hecho clic en la vista repartos.all
Route::get('/repartos/{id}/addDeliveries', [RepartoController::class, 'addDeliveries'])->middleware('auth')->name('repartos.addDeliveries');
// Ruta para actualizar la vista repartos.deliveries (para ver cómo se van asignando / sacando los envios de un reparto)
Route::get('/repartos/{id}/showDeliveries', [RepartoController::class, 'showDeliveries'])->middleware('auth')->name('repartos.showDeliveries');
// Ruta para usar en el botón de asignar envío a un reparto
Route::post('/repartos/{id}/asignar', [RepartoController::class, 'assignDelivery'])->middleware('auth')->name('repartos.asignar');
// Ruta para usar en el botón de quitar un envío de un reparto
Route::post('/repartos/{id}/removeDelivery', [RepartoController::class, 'removeFromDelivery'])->middleware('auth')->name('repartos.removeFromDelivery');

require __DIR__ . '/auth.php';
