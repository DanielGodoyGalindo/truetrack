<?php

use App\Models\Envio;
use Illuminate\Support\Facades\DB;

test('Actualizar estado envío', function () {

    // Crear envío
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    $envio = Envio::create([
        'cliente_id' => 3,
        'reparto_id' => null,
        'destinatario' => 'David Fernandez',
        'estado' => 'pendiente',
        'bultos' => 7,
        'kilos' => 42.10,
        'informacion' => 'nuevo envio',
    ]);
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    // Actualizar estado y comprobar
    $envio->update(['estado' => 'en reparto']);
    expect($envio->estado)->toBeString();
    expect($envio->estado)->toBe('en reparto');
});
