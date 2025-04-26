<?php

test('Acceso a Index', function () {

    // Obtener respuesta http
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertViewIs('index');
    
});
