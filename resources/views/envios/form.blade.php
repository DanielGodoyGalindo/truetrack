<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Crear envío')
</head>

<body>
    @include('master')
    <div class="container">
        <h1>Crear envío</h1>
        {{-- Formulario --}}
        <form action="{{ route('envios.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="destinatario">Destinatario:</label>
                <input type="text" name="destinatario" class="form-control w-25" placeholder="Nombre y apellidos"
                    required>
            </div>
            <div class="mb-3">
                <label for="direccion_destinatario">Dirección de destino:</label>
                <input type="text" name="direccion_destinatario" class="form-control w-50"
                    placeholder="Dirección completa" required>
            </div>
            <div class="mb-3">
                <label for="bultos">Número de bultos:</label>
                <input type="number" name="bultos" class="form-control w-25" placeholder="Bultos" min="1"
                    max="100" required>
            </div>
            <div class="mb-3">
                <label for="kilos">Número de kilos:</label>
                <input type="number" name="kilos" class="form-control w-25" placeholder="Kilos" step="0.01"
                    min="1" max="1000" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</body>
