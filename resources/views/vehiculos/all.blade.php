<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Vehículos')
    @vite(['resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @extends('master')
    @section('content')
        <div id="app">
            {{-- Header y botón --}}
            @if (Auth::user()->rol == 'administrador')
                <div class="container d-flex flex-row justify-content-between">
                    <div>
                        <h1>{{ __('messages.vehicles') }}</h1>
                    </div>
                    {{-- Componentes botón Vue (nuevo envío) --}}
                    <div id="button-app" class="d-flex flex-row gap-3">
                        <button-component button-text="✚ {{ __('messages.newVehicle') }}"
                            button-url="{{ route('vehiculos.create') }}" class="btn boton-accion1 h-75"></button-component>
                    </div>
                </div>
                {{-- Tabla --}}
                <div class="container">
                    <table class="table align-middle text-center">
                        <thead class="tabla-header">
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">{{ __('messages.numberPlate') }}</th>
                                <th scope="col">{{ __('messages.maxLoad') }}</th>
                                <th scope="col">{{ __('messages.edit') }}</th>
                                <th scope="col">{{ __('messages.delete') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vehiculos as $vehiculo)
                                <tr>
                                    <th scope="row">{{ $vehiculo->id }}</th>
                                    <td>{{ $vehiculo->matricula }}</td>
                                    <td>{{ $vehiculo->carga_max }}</td>
                                    <td>
                                        {{-- Formulario editar vehiculos --}}
                                        <form action="{{ route('vehiculos.edit', $vehiculo->id) }}" method="GET">
                                            @csrf
                                            <input type="submit" value="✏️" class="btn icono-grande">
                                        </form>
                                    </td>
                                    <td>
                                        {{-- Borrar vehículos --}}
                                        <button class="btn icono-mediano"
                                            v-on:click="openModal('{{ route('vehiculos.destroy', $vehiculo->id) }}','DELETE')">
                                            ❌
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            {{-- Componente Vue modal --}}
                            <modal-component v-if="showModal" :show="showModal" :route="route"
                                :method="method" v-on:close="closeModal"
                                lang="{{ LaravelLocalization::getCurrentLocale() }}"></modal-component>
                        </tbody>
                    </table>
                    {{-- Paginación --}}
                    <div class="d-flex justify-content-center py-3">
                        {{ $vehiculos->links('pagination::bootstrap-4') }}
                    </div>
                    {{-- Componente vue mensajes --}}
                    @if (session('message'))
                        <message-component :message="'{{ session('message') }}'"
                            lang="{{ LaravelLocalization::getCurrentLocale() }}" />
                    @endif
                </div>
            @endif
        </div>
    @endsection
</body>

</html>
