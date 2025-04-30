<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Enviar email')
    @vite(['resources/js/app.js'])
</head>

<body>
    @extends('master')
    @section('content')
        <div id="app">
            <div class="container">
                <h1>Enviar mensaje</h1>
                <div class="d-flex flex-row-reverse justify-content-around mt-4">
                    <div>
                        <p><b>Cliente:</b> {{ $envio->cliente->name }}</p>
                        <p><b>Destinatario:</b> {{ $envio->destinatario }}</p>
                        <p><b>Bultos:</b> {{ $envio->bultos }}</p>
                        <p><b>Kilos:</b> {{ $envio->kilos }}</p>
                        <p><b>Estado:</b> {{ Str::title($envio->estado) }}</p>
                    </div>
                    {{-- Formulario --}}
                    <form action="{{ route('envios.sendEmail') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email">Dirección de destinatario:</label>
                            <input type="email" name="email" class="form-control border border-2" placeholder="Email"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="mensaje">Mensaje:</label>
                            <textarea name="mensaje" class="form-control border border-2" placeholder="Escribe aquí el mensaje.." rows="10"
                                cols="33" required></textarea>
                        </div>
                        <div class="d-flex gap-3 justify-content-start">
                            <button type="submit" class="btn boton-accion2">Enviar</button>
                        </div>
                    </form>
                </div>
                {{-- Componente botón Vue (volver) --}}
                <div class="d-flex justify-content-center mt-4">
                    <button-component button-text="Volver" button-url="{{ route('envios.index') }}"
                        class="btn boton-accion1"></button-component>
                </div>
            </div>
        </div>
    @endsection
</body>
