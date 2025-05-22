<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Mis Repartos')
    @vite(['resources/js/app.js'])
</head>

<body>
    @extends('master')
    @section('content')
        <div id="app">
            @if (Auth::check() && Auth::user()->rol == 'transportista')
                {{-- Header --}}
                <div class="container">
                    <h1>{{ __('messages.myDistributions') }}</h1>
                </div>

                {{-- Tabla --}}
                <div class="container">
                    <h3>{{ __('messages.vanDriver') }}: {{ Auth::user()->name }}</h3>
                    <table class="table align-middle text-center">
                        <thead class="tabla-header">
                            <tr>
                                <th scope="col">{{ __('messages.deliveryRouteNum') }}</th>
                                <th scope="col">{{ __('messages.trafficManager') }}</th>
                                <th scope="col">{{ __('messages.vehicle') }}</th>
                                <th scope="col">{{ __('messages.select') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Datos --}}
                            @foreach ($repartos as $reparto)
                                <tr>
                                    <th scope="row">{{ $reparto->id }}</th>
                                    <td>{{ $reparto->gestor->name }}</td>
                                    <td>{{ $reparto->vehiculo->matricula }}</td>
                                    <td>
                                        {{-- Componente botón Vue --}}
                                        <div id="button-app">
                                            <button-component button-text="{{ __('messages.seeDistribution') }}"
                                                button-url="{{ route('driver.deliveries', [$reparto->id]) }}"
                                                class="boton-accion1"></button-component>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- Fin tabla --}}
                </div>
            @else
                <span>No tienes permiso para acceder a esta sección</span>
            @endif
        </div>
    @endsection

</body>

</html>
