<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Envios Completados Reparto')
    @vite(['resources/js/app.js'])
</head>

<body>
    @extends('master')
    @section('content')
        <div id="app">

            {{-- Header y botón --}}
            <div class="container d-flex flex-row justify-content-between">
                <h1>Envíos del reparto {{ $reparto->id }}</h1>
            </div>

            {{-- Tabla --}}
            <div class="container">
                <table class="table align-middle">
                    <thead class="tabla-header">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Destinatario</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Num. reparto</th>
                            <th scope="col">Bultos y kilos</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Datos --}}
                        @foreach ($envios as $envio)
                            <tr>
                                <th scope="row">{{ $envio->id }}</th>
                                <td>{{ $envio->cliente->name }}</td>
                                <td>{{ $envio->destinatario }}</td>
                                <td>{{ Str::title($envio->estado) }}</td>
                                <td>{{ $envio->reparto_id ?? 'No asignado' }}</td>
                                <td>{{ $envio->bultos }} bultos - {{ $envio->kilos }} kilos</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- Paginación --}}
            <div class="container d-flex justify-content-center py-3">
                {{ $envios->links('pagination::bootstrap-4') }}
            </div>
            {{-- Componente botón Vue (volver) --}}
            <div id="button-app" class="container text-center">
                <button-component button-text="Volver" button-url="{{ route('repartos.showDeliveriesCompleted') }}"
                    class="btn boton-accion1"></button-component>
            </div>
        </div>
    @endsection
</body>

</html>
