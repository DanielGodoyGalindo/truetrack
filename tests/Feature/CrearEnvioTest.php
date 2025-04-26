<?php

use App\Models\Envio;
use Illuminate\Support\Facades\DB;

test('Crear envío', function () {

    // Crear envío
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

    // Comprobar que existe en la BDD
    $this->assertDatabaseHas('envios', [
        'destinatario' => 'Pepito Perez',
        'estado' => 'pendiente',
    ]);
});
