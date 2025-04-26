<?php

use App\Models\Reparto;
use App\Models\User;
use App\Models\Vehiculo;
use Illuminate\Support\Facades\DB;

test('Crear reparto', function () {

// Crear reparto
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    $reparto = Reparto::create([
        'gestor_id' => 1,
        'transportista_id' => 2,
        'vehiculo_id' => 1,
        'estado' => 'en proceso',
    ]);
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    // Comprobar que existe y que su estado es 'en proceso'
    expect(Reparto::where('gestor_id', 1)->exists())->toBeTrue();
    expect($reparto->estado)->toBe('en proceso');
});
