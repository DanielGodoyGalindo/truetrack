<?php

use App\Models\Reparto;
use Illuminate\Support\Facades\DB;

test('Editar reparto', function () {

    //Crear reparto
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    $reparto = Reparto::create([
        'gestor_id' => 1,
        'transportista_id' => 2,
        'vehiculo_id' => 1,
        'estado' => 'en proceso',
    ]);

    // Actualizar propiedad y comprobar con expectation
    $reparto->update(['vehiculo_id' => 5]);
    $reparto->update(['transportista_id' => 8]);
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    expect($reparto->vehiculo_id)->toBe(5);
    expect($reparto->transportista_id)->toBe(8);
});
