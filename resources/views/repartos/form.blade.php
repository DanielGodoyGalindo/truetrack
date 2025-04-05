<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Crear reparto')
</head>

<body>
    @include('master')
    <div class="container">
        <h1>Crear reparto</h1>
        {{-- Formulario --}}
        <form action="{{ route('repartos.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                {{-- Componente select de transportistas --}}
                <div id="select-app1">
                    <select-component :options='@json($transportistas)' id="transportistas-select"
                        label="Seleccione un transportista:">
                    </select-component>
                    @vite(['resources/js/app.js'])
                </div>

                {{-- Componente select de vehiculos --}}
                <div id="select-app2">
                    <select-component :options='@json($vehiculos)' id="vehiculos-select"
                        label="Seleccione un vehiculo:">
                    </select-component>
                    @vite(['resources/js/app.js'])
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</body>
