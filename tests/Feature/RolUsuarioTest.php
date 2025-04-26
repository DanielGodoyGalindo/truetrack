<?php

use App\Models\User;

test('Comprobación rol de usuario', function () {

    // Crear nuevo usuario
    $usuario = new User([
        'name' => 'Usuario de prueba',
        'email' => 'usuarioprueba@gmail.com',
        'password' => 'usuarioprueba',
        'password_confirmation' => 'usuarioprueba',
        'rol' => 'gestor_trafico',
    ]);

    // Comprobar su rol
    expect($usuario->rol)->toBe('gestor_trafico');

});
