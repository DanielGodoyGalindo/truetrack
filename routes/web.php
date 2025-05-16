<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\RepartoController;
use App\Http\Controllers\VehiculoController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/* Route::get('/', function () {
    return view('index');
})->name('index'); */

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

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

    Route::middleware(['auth', 'role:transportista'])->group(function () {
        // Ruta para que los transportistas vean sus repartos
        Route::get('/repartosTransportista/{id}', [UserController::class, 'driverDistributions'])->name('driver.distributions');
        // Ruta para mostrar los envíos dentro de un reparto para un transportista
        Route::get('/repartoTransportista/{id}', [UserController::class, 'driverDeliveries'])->name('driver.deliveries');
        // Ruta para cambiar el estado de un reparto a finalizado
        Route::post('repartoTransportista/finalizar/{id}', [UserController::class, 'driverCompleteDistribution'])->name('driver.completeDistribution');
    });


    ///////////////////
    /* Rutas varias */
    //////////////////

    // Ruta para devolver el número de envios y repartos totales
    Route::get('/', [EnvioController::class, 'showDatosIndex'])->name('index');
    // Ruta para mostrar los envios entregados y anulados
    Route::get('/envios/completed', [EnvioController::class, 'showCompleted'])
        ->middleware(['auth', 'role:cliente,gestor_trafico,administrador'])->name('envios.showCompleted');
    // Ruta para mostrar los repartos completados (estado finalizado)
    Route::get('/repartos/deliveriesCompleted', [RepartoController::class, 'showDeliveriesCompleted'])
        ->middleware(['auth', 'role:gestor_trafico,administrador'])->name('repartos.showDeliveriesCompleted');


    /////////////////////
    /* Rutas resource */
    ////////////////////

    // Rutas con método resource, el middleware de auth indica que sólo se puede acceder si el usuario está autenticado
    Route::resource('users', UserController::class)->middleware(['auth', 'role:administrador']);
    Route::resource('envios', EnvioController::class)->middleware(['auth', 'role:cliente,gestor_trafico,administrador']);
    Route::resource('repartos', RepartoController::class)->middleware(['auth', 'role:gestor_trafico,administrador']);
    Route::resource('vehiculos', VehiculoController::class)->middleware(['auth', 'role:administrador']);


    ///////////////////////////////
    /* Rutas envíos no resource */
    //////////////////////////////

    // Se pasa el parametro del id para saber cual es el envio del que se quiere mandar un email
    Route::middleware(['auth', 'role:cliente'])->group(function () {
        Route::post('/envios/mail/{id}', [EnvioController::class, 'email'])->name('envios.email');
        Route::post('/envios/send-email', [EnvioController::class, 'sendEmail'])->name('envios.sendEmail');
        Route::post('/envios/anular/{id}', [EnvioController::class, 'setNull'])->name('envios.setNull');
    });
    // Ruta para que Rol Transportista pueda actualizar el estado de un envío
    Route::post('/envios/actualizar/{id}', [EnvioController::class, 'actualizarEnvio'])->middleware(['auth', 'role:transportista'])->name('envios.actualizar');


    /////////////////////////////////
    /* Rutas repartos no resource */
    ////////////////////////////////

    // Ruta para añadir envios a un reparto, se pasa el id del reparto en el que el usuario ha hecho clic en la vista repartos.all
    Route::middleware(['auth', 'role:gestor_trafico'])->group(function () {
        Route::get('/repartos/{id}/addDeliveries', [RepartoController::class, 'addDeliveries'])->name('repartos.addDeliveries');
        // Ruta para actualizar la vista repartos.deliveries (para ver cómo se van asignando / sacando los envios de un reparto)
        Route::get('/repartos/{id}/showDeliveries', [RepartoController::class, 'showDeliveries'])->name('repartos.showDeliveries');
        // Ruta para usar en el botón de asignar envío a un reparto
        Route::post('/repartos/{id}/asignar', [RepartoController::class, 'assignDelivery'])->name('repartos.asignar');
        // Ruta para usar en el botón de quitar un envío de un reparto
        Route::post('/repartos/{id}/removeDelivery', [RepartoController::class, 'removeFromDelivery'])->name('repartos.removeFromDelivery');
    });
});

require __DIR__ . '/auth.php';
