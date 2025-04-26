<?php

use App\Models\Envio;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('Eliminar envío', function () {

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

    $envio->delete();
    // Comprobar si el envio con el id indicado no existe
    expect(Envio::where('id', $envio->id)->exists())->toBeFalse();
    // Otra manera de comprobar es usar aserciones
    // $this->assertDatabaseMissing('envios', ['id' => $envio->id]);
});
