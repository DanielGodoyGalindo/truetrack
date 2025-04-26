<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('Login de usuario', function () {

    // Crear usuario
    $usuario = User::create([
        'name' => 'usuario',
        'email' => 'usuario@gmail.com',
        'password' => Hash::make('usuarioprueba'),
        'rol' => 'cliente',
    ]);

    $respuestaHttp = $this->post('/login', [
        'email' => $usuario->email,
        'password' => 'usuarioprueba',
    ]);

    $respuestaHttp->assertRedirect('/');
    $this->assertAuthenticatedAs($usuario);
});
