<?php

use App\Models\Vehiculo;

test('Crear vehículo', function () {

    // Crear vehículo
    $vehiculo = Vehiculo::create([
        'matricula' => '4321DGG',
        'carga_max' => 700,
    ]);

    // Comprobar que existe en la BDD y que la propiedad es entero
    expect(Vehiculo::where('matricula', '4321DGG')->exists())->toBeTrue();
    expect($vehiculo->carga_max)->toBeInt();
    expect($vehiculo->carga_max)->toEqual(700);
});
