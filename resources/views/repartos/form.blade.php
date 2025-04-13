<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Crear reparto')
</head>

<body>
    @extends('master')
    @section('content')
        <div id="app">
            <div class="container">
                <h1>Crear reparto</h1>
                {{-- Formulario --}}
                <form action="{{ route('repartos.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        {{-- Componente select de transportistas --}}
                        <div id="select-app1">
                            <select-component name="transportista" :options='@json($transportistas)'
                                id="transportistas-select" label="Seleccione un transportista:">
                            </select-component>
                            @vite(['resources/js/app.js'])
                        </div>
                        {{-- Componente select de vehiculos --}}
                        <div id="select-app2">
                            <select-component name="vehiculo" :options='@json($vehiculos)' id="vehiculos-select"
                                label="Seleccione un vehiculo:">
                            </select-component>
                            @vite(['resources/js/app.js'])
                        </div>
                        <button type="submit" class="btn btn-primary mt-5">Guardar</button>
                </form>
            </div>
        </div>
    @endsection
</body>
