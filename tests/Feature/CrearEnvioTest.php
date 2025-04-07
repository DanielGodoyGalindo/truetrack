<?php

use App\Models\Envio;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('Crear envío', function () {

    $cliente = User::create([
        'name' => 'cliente1',
        'email' => 'cliente1@gmail.com',
        'password' => Hash::make('cliente1'),
        'rol' => 'cliente',
    ]);

    $envio = Envio::create([
        'cliente_id' => $cliente->id,
        'reparto_id' => null,
        'destinatario' => 'Pepito Perez',
        'estado' => 'pendiente',
        'bultos' => 3,
        'kilos' => 12.50,
        'informacion' => 'nuevo envio',
    ]);

    $this->assertDatabaseHas('envios', [
        'destinatario' => 'Pepito Perez',
        'estado' => 'pendiente',
    ]);
});
