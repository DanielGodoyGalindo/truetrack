<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Repartos')
    @vite(['resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @extends('master')
    @section('content')
        <div id="app">
            <div
                @if (Auth::user()->rol == 'gestor_trafico') class="container d-flex flex-row justify-content-between" 
                @else class="container" @endif>
                {{-- Si es gestor de tráfico, mostrar su nombre --}}
                <h1>{{ __('messages.deliveryRoutes') }} @if (Auth::user()->rol == 'gestor_trafico')
                        {{ __('messages.of') }} {{ Auth::user()->name }}
                    @endif
                </h1>
                @if (Auth::user()->rol == 'gestor_trafico')
                    {{-- Componentes botón Vue (nuevo reparto y finalizados) --}}
                    <div id="button-app" class="d-flex flex-row gap-3">
                        <button-component button-text="✚ {{ __('messages.newDistribution') }}"
                            button-url="{{ route('repartos.create') }}" class="btn boton-accion1 h-75"></button-component>
                        <button-component button-text="{{ __('messages.finished') }}"
                            button-url="{{ route('repartos.showDeliveriesCompleted') }}"
                            class="btn boton-accion1 h-75"></button-component>
                    </div>
                @endif
            </div>
            {{-- Tabla --}}
            <div class="container">
                <table class="table align-middle">
                    <thead class="tabla-header">
                        <tr class="text-center">
                            <th scope="col">Id</th>
                            @if (Auth::user()->rol == 'administrador')
                                <th scope="col">{{ __('messages.trafficManager') }}</th>
                            @endif
                            <th scope="col">{{ __('messages.vanDriver') }}</th>
                            <th scope="col">{{ __('messages.vehicle') }}</th>
                            <th scope="col">{{ __('messages.status') }}</th>
                            @if (Auth::user()->rol == 'administrador')
                                <th scope="col" class="text-center">{{ __('messages.delete') }}</th>
                            @endif
                            @if (Auth::user()->rol == 'gestor_trafico')
                                <th scope="col">{{ __('messages.assignShipments') }}</th>
                                <th scope="col">{{ __('messages.edit') }}</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        {{-- Datos para gestores --}}
                        @if (Auth::user()->rol == 'gestor_trafico')
                            @foreach ($repartosGestor as $reparto)
                                <tr class="text-center">
                                    <th scope="row">{{ $reparto->id }}</th>
                                    <td>{{ $reparto->transportista->name }}</td>
                                    <td>{{ $reparto->vehiculo->matricula }}</td>
                                    <td>{{ Str::title($reparto->estado) }}</td>
                                    {{-- Asignar envios --}}
                                    <td>
                                        <form action="{{ route('repartos.addDeliveries', $reparto->id) }}" method="GET">
                                            @csrf
                                            {{-- @method('POST') --}}
                                            <input type="submit" value="🚚" class="btn fs-3">
                                        </form>
                                    </td>
                                    <td>
                                        {{-- Formulario editar --}}
                                        <form action="{{ route('repartos.edit', $reparto->id) }}" method="GET">
                                            @csrf
                                            <input type="submit" value="✏️" class="btn icono-grande">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        {{-- Datos para admin --}}
                        @if (Auth::user()->rol == 'administrador')
                            @foreach ($repartosAdmin as $reparto)
                                <tr class="text-center">
                                    <th scope="row">{{ $reparto->id }}</th>
                                    <td>{{ $reparto->gestor->name }}</td>
                                    <td>{{ $reparto->transportista->name }}</td>
                                    <td>{{ $reparto->vehiculo->matricula }}</td>
                                    <td>{{ Str::title($reparto->estado) }}</td>
                                    {{-- Borrar repartos --}}
                                    <td>
                                        <button class="btn icono-mediano"
                                            v-on:click="openModal('{{ route('repartos.destroy', $reparto->id) }}','DELETE')">
                                            ❌
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            {{-- Componente Vue modal --}}
                            <modal-component v-if="showModal" :show="showModal" :route="route"
                                :method="method" v-on:close="closeModal"
                                lang="{{ LaravelLocalization::getCurrentLocale() }}"></modal-component>
                        @endif
                    </tbody>
                </table>
            </div>
            {{-- Fin tabla --}}

            {{-- Paginación --}}
            <div class="d-flex justify-content-center py-3">
                @if (Auth::user()->rol == 'gestor_trafico')
                    {{ $repartosGestor->links('pagination::bootstrap-4') }}
                @elseif (Auth::user()->rol == 'administrador')
                    {{ $repartosAdmin->links('pagination::bootstrap-4') }}
                @endif
            </div>

            {{-- Componente vue mensajes --}}
            @if (session('message'))
                <message-component :message="'{{ session('message') }}'"
                    lang="{{ LaravelLocalization::getCurrentLocale() }}" />
            @endif

        </div>
    @endsection
</body>

</html>
