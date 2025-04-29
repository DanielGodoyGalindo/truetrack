<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Repartos')
    @vite(['resources/js/app.js'])
</head>

<body>
    @extends('master')
    @section('content')
        <div id="app">
            {{-- Header e info del reparto --}}
            <div class="container d-flex flex-row justify-content-around">
                <h1>Reparto {{ $reparto->id }}</h1>
                <div>
                    <p>Gestor de tráfico: {{ $reparto->gestor->name }}</p>
                    <p>Transportista: {{ $reparto->transportista->name }}</p>
                    <p>Vehículo: {{ $reparto->vehiculo->matricula }}</p>
                    <p>Carga máxima: {{ $reparto->vehiculo->carga_max }} kg</p>
                </div>
            </div>

            {{-- Tablas para asignar envios a reparto --}}
            <div class="container">
                {{-- Tabla con envios pendientes de reparto --}}
                <div class="container">
                    <h2 class="pt-2">Envíos disponibles</h2>
                    <table class="table align-middle text-center">
                        <thead class="tabla-header">
                            <tr>
                                <th>Envío Id</th>
                                <th>Destinatario</th>
                                <th>Estado</th>
                                <th>Peso</th>
                                <th>Asignar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($enviosPendientes as $envio)
                                <tr>
                                    <td>{{ $envio->id }}</td>
                                    <td>{{ $envio->destinatario }}</td>
                                    <td>{{ Str::title($envio->estado) }}</td>
                                    <td>{{ $envio->kilos }} kgs</td>
                                    <td>
                                        {{-- Botón para asignar envíos --}}
                                        <form action="{{ route('repartos.asignar', $reparto->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="envio_id" value="{{ $envio->id }}">
                                            <button type="submit" class="btn {{-- btn-outline-success --}} boton-verde">Añadir al
                                                reparto</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Paginación para la primera tabla --}}
                    <div class="d-flex justify-content-center py-3">
                        {{ $enviosPendientes->links('pagination::bootstrap-4') }}
                    </div>
                </div>

                {{-- Tabla con envíos asignados al reparto actual --}}
                <div class="container">
                    <h2 class="pt-5">Envíos asignados</h2>
                    <table class="table align-middle text-center">
                        <thead class="tabla-header2">
                            <tr>
                                <th>Envío Id</th>
                                <th>Destinatario</th>
                                {{-- <th>Estado</th> --}}
                                <th>Kilos</th>
                                <th>Quitar del reparto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($enviosAsignados as $envio)
                                <tr>
                                    <td>{{ $envio->id }}</td>
                                    <td>{{ $envio->destinatario }}</td>
                                    {{-- <td>{{ Str::title($envio->estado) }}</td> --}}
                                    <td>{{ $envio->kilos }} kgs</td>
                                    <td>
                                        <form action="{{ route('repartos.removeFromDelivery', $reparto->id) }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="envio_id" value="{{ $envio->id }}">
                                            <button type="submit" class="btn">❌</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mostrar información de kilos --}}
                <div class="container pt-5 d-flex justify-content-around">
                    {{-- Null coalescing operator: Muestra el valor de la izquierda, y si es no está definido o es null, muestra el de la derecha --}}
                    <span class="h4"> Kilos cargados: {{ $kilosCargados ?? 0 }} kgs</span>
                </div>
                {{-- Componente barra progreso --}}
                <progress-bar-component :valor="{{ $kilosCargados }}"
                    :total="{{ $reparto->vehiculo->carga_max }}"></progress-bar-component>
            </div>
            {{-- Componente vue para mensajes --}}
            <div id="message-app">
                @if (session('message'))
                    <message-component :message="'{{ session('message') }}'" />
                @endif
            </div>
        </div>
    @endsection
</body>
