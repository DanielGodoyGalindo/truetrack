<?php

use Illuminate\Support\Facades\Hash;

test('Registro de usuario', function () {

    // Obtener respeusta http
    $respuesta = $this->post('/register', [
        'name' => 'Usuario de prueba',
        'email' => 'usuarioprueba@gmail.com',
        'password' => 'usuarioprueba',
        'password_confirmation' => 'usuarioprueba',
        'rol' => 'transportista',
    ]);

    // Comprobar que redirige a dashboard y que la BDD tiene el usuario creado
    $respuesta->assertRedirect('/dashboard');
    $this->assertDatabaseHas(
        'users',
        [
            'name' => 'Usuario de prueba',
            'email' => 'usuarioprueba@gmail.com',
        ]
    );
});
