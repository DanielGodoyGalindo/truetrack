<?php

use App\Models\Envio;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

test('Envío de datos desde EnvioController', function () {

    // Crear envío para comprobar qu se devuelve cuando se llama al controlador
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    Envio::create([
        'cliente_id' => 1,
        'reparto_id' => null,
        'destinatario' => 'Pepito Perez',
        'estado' => 'pendiente',
        'bultos' => 3,
        'kilos' => 12.50,
        'informacion' => 'nuevo envio',
    ]);
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    // Crear usuario para que esté autenticado para poder acceder a la ruta "/envios"
    $usuario = User::create([
        'name' => 'cliente1',
        'email' => 'cliente1@gmail.com',
        'password' => Hash::make('cliente1'),
        'rol' => 'cliente',
    ]);

    // Autenticarse como el usuario, redireccionar y comprobar que se recibe respuesta con datos
    $this->actingAs($usuario);
    $respuesta = $this->get('/envios');
    $respuesta->assertViewHas('enviosCliente');

});
