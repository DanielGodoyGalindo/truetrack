<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Crear envío')
</head>

<body>
    @extends('master')
    @section('content')
        <div id="app">
            <div class="container">
                <h1>{{ $envio ? 'Editar envio' : 'Nuevo envio' }}</h1>
                {{-- Formulario --}}
                @if ($envio)
                    <form action="{{ route('envios.update', $envio->id) }}" method="POST">
                        @method('PUT')
                    @else
                        <form action="{{ route('envios.store') }}" method="POST">
                @endif
                @csrf
                <div class="mb-3">
                    <label for="destinatario">Destinatario:</label>
                    <input type="text" name="destinatario" class="form-control w-25" placeholder="Nombre y apellidos"
                        value="{{ $envio ? Str::before($envio->destinatario, ' -') : '' }}" required>
                </div>
                <div class="mb-3">
                    <label for="direccion_destinatario">Dirección de destino:</label>
                    <input type="text" name="direccion_destinatario" class="form-control w-50"
                        placeholder="Dirección completa" value="{{ $envio ? Str::after($envio->destinatario, '- ') : '' }}"
                        required>
                </div>
                <div class="mb-3">
                    <label for="bultos">Número de bultos:</label>
                    <input type="number" name="bultos" class="form-control w-25" placeholder="Bultos" min="1"
                        max="100" value="{{ $envio ? $envio->bultos : '' }}" required>
                </div>
                <div class="mb-3">
                    <label for="kilos">Número de kilos:</label>
                    <input type="number" name="kilos" class="form-control w-25" placeholder="Kilos" step="0.01"
                        min="1" max="1000" value="{{ $envio ? $envio->kilos : '' }}" required>
                </div>
                <button type="submit" class="btn boton-accion1">Guardar</button>
                </form>
            </div>
        </div>
    @endsection
</body>
