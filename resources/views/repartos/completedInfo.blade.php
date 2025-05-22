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
            <div class="container" style="min-height: 30vh">
                <table class="table align-middle text-center">
                    <thead class="tabla-header">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">{{ __('messages.client') }}</th>
                            <th scope="col">{{ __('messages.addressee') }}</th>
                            <th scope="col">{{ __('messages.status') }}</th>
                            <th scope="col">{{ __('messages.packages&Weight') }}</th>
                            <th scope="col">{{ __('messages.dateTime') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Datos --}}
                        @foreach ($envios as $envio)
                            <tr>
                                <th scope="row">{{ $envio->id }}</th>
                                <td>{{ $envio->cliente->name }}</td>
                                <td class="text-start">{{ $envio->destinatario }}</td>
                                <td>{{ Str::title($envio->estado) }}</td>
                                <td>{{ $envio->bultos }} {{ __('messages.packages') }} - {{ $envio->kilos }} {{ __('messages.kilograms') }}</td>
                                <td>{{ $envio->updated_at->format('d-m-Y H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- Paginación --}}
            <div class="container d-flex justify-content-center py-3">
                {{ $envios->links('pagination::bootstrap-4') }}
            </div>
            {{-- Motrar ratio entregados / no entregados --}}
            {{-- Componente barra progreso --}}
            <div class="container w-25">
                <progress-bar-component :valor="{{ $entregados }}"
                    :total="{{ $enviosTotales }}"></progress-bar-component>
                <div class="text-center mb-3">
                    <span class="span-info">
                        @if ($enviosTotales > 0)
                            {{ round(($entregados * 100) / $enviosTotales, 2) }}% {{ __('messages.shipmentsDelivered') }}
                        @else
                            0% {{ __('messages.shipmentsDelivered') }}
                        @endif
                    </span>
                </div>
            </div>
            {{-- Componente botón Vue (volver) --}}
            <div class="container text-center">
                <button-component button-text="{{ __('messages.back') }}" button-url="{{ route('repartos.showDeliveriesCompleted') }}"
                    class="btn boton-accion1"></button-component>
            </div>
        </div>
    @endsection
</body>

</html>
