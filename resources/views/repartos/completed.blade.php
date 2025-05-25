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
                <h1>{{ __('messages.deliveryRoutes') }}
                    @if (Auth::user()->rol == 'gestor_trafico')
                        {{ __('messages.of') }} {{ Auth::user()->name }}
                    @endif
                    - {{ __('messages.finished') }}
                </h1>
            </div>

            {{-- Tabla --}}
            <div class="container">
                <table class="table align-middle text-center">
                    <thead class="tabla-header">
                        <tr>
                            <th scope="col">Id</th>
                            @if (Auth::user()->rol == 'administrador')
                                <th scope="col">{{ __('messages.trafficManager') }}</th>
                            @endif
                            <th scope="col">{{ __('messages.vanDriver') }}</th>
                            <th scope="col">{{ __('messages.vehicle') }}</th>
                            <th scope="col">{{ __('messages.status') }}</th>
                            <th scope="col">{{ __('messages.dateTime') }}</th>
                            @if (Auth::user()->rol == 'gestor_trafico')
                                <th scope="col">{{ __('messages.seeDistribution') }}</th>
                            @elseif (Auth::user()->rol == 'administrador')
                                <th scope="col">{{ __('messages.delete') }}</th>
                            @endif
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
                                <td>{{ $reparto->updated_at->format('d-m-Y H:i:s') }}</td>
                                <td>
                                    @if (Auth::user()->rol == 'gestor_trafico')
                                        <form action="{{ route('repartos.show', $reparto->id) }}" method="GET">
                                            @csrf
                                            @method('POST')
                                            <input type="submit" value="Ver" class="btn boton-accion1">
                                        </form>
                                    @elseif (Auth::user()->rol == 'administrador')
                                        <button class="btn icono-mediano"
                                            v-on:click="openModal('{{ route('repartos.destroy', $reparto->id) }}','DELETE')">
                                            ❌
                                        </button>
                                    @endif
                                </td>
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
                <button-component button-text="{{ __('messages.back') }}" button-url="{{ route('repartos.index') }}"
                    class="btn boton-accion1"></button-component>
            </div>
        </div>
    @endsection
</body>

</html>
