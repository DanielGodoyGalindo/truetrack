<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Repartos Completados')
    @vite(['resources/js/app.js'])
</head>

<body>

    @extends('master')
    @section('content')
        <div id="app">

            {{-- Header y botón --}}
            <div class="container d-flex flex-row justify-content-between">
                {{-- Si es gestor, mostrar su nombre --}}
                <h1>Repartos
                    @if (Auth::user()->rol == 'gestor_trafico')
                        de {{ Auth::user()->name }}
                    @endif
                    finalizados
                </h1>
            </div>

            {{-- Tabla --}}
            <div class="container">
                <table class="table align-middle">
                    <thead class="tabla-header">
                        <tr>
                            <th scope="col">Id</th>
                            @if (Auth::user()->rol == 'administrador')
                                <th scope="col">Gestor tráfico</th>
                            @endif
                            <th scope="col">Transportista</th>
                            <th scope="col">Vehículo</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Fecha y hora</th>
                        </tr>
                    </thead>

                    {{-- Datos --}}
                    <tbody>
                        @foreach ($finalizados as $reparto)
                            <tr>
                                <th scope="row">{{ $reparto->id }}</th>
                                @if (Auth::user()->rol == 'administrador')
                                    <th> {{ $reparto->gestor->name }} </th>
                                @endif
                                <td>{{ $reparto->transportista->name }}</td>
                                <td>{{ $reparto->vehiculo->matricula }}</td>
                                <td>{{ Str::title($reparto->estado) }}</td>
                                <td>{{ $reparto->updated_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Fin tabla --}}

            </div>

            {{-- Paginación --}}
            <div class="container d-flex justify-content-center py-3">
                {{ $finalizados->links('pagination::bootstrap-4') }}
            </div>

            {{-- Componente botón Vue (volver) --}}
            <div id="button-app" class="container text-center">
                <button-component button-text="Volver" button-url="{{ route('repartos.index') }}"
                    class="btn boton-accion1"></button-component>
            </div>
        </div>
    @endsection
</body>

</html>
