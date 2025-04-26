<?php

use App\Models\Vehiculo;

test('Eliminar vehículo', function () {

    // Crear vehículo
    $vehiculo = Vehiculo::create([
        'matricula' => '1111GGG',
        'carga_max' => 800,
    ]);

    // Eliminarlo
    $vehiculo->delete();

    // Test
    expect(Vehiculo::where('matricula', '1111GGG')->doesntExist())->toBeTrue();

});
