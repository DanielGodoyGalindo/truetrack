<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Crear reparto')
    @vite(['resources/js/app.js'])
</head>

<body>
    @extends('master')
    @section('content')
        <div id="app">
            <div class="container">
                <h1>{{ $reparto ? __('messages.editDistribution') : __('messages.newDistribution') }}</h1>
                {{-- Formulario --}}
                @if ($reparto)
                    <form action="{{ route('repartos.update', $reparto->id) }}" method="POST">
                        @method('PUT')
                    @else
                        <form action="{{ route('repartos.store') }}" method="POST">
                @endif
                @csrf
                <div class="mb-3">
                    {{-- Componente select de transportistas --}}
                    <select-component name="transportista" :options='@json($transportistas)' id="transportistas-select"
                        @if ($reparto) :selected='@json($reparto->transportista->name)' @endif
                        label="{{ __('messages.selectVanDriver') }}">
                    </select-component>
                    {{-- Componente select de vehiculos --}}
                    <select-component name="vehiculo" :options='@json($vehiculos)' id="vehiculos-select"
                        @if ($reparto) :selected='@json($reparto->vehiculo->matricula)' @endif
                        label="{{ __('messages.selectVehicle') }}">
                    </select-component>
                    <button type="submit" class="btn boton-accion1 mt-5">Guardar</button>
                    </form>
                </div>
            </div>
        @endsection
</body>
