<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Vehículos')
    @vite(['resources/js/app.js'])
</head>

<body>
    @extends('master')
    @section('content')
        <div id="app">
            <div class="container">
                <h1>{{ $vehiculo ? __('messages.editVehicle') : __('messages.newVehicle') }}</h1>
                {{-- Formulario --}}
                @if ($vehiculo)
                    <form action="{{ route('vehiculos.update', $vehiculo->id) }}" method="POST">
                        @method('PUT')
                    @else
                        <form action="{{ route('vehiculos.store') }}" method="POST">
                @endif
                @csrf
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex flex-column">
                        {{-- Matrícula --}}
                        <label for="matricula" class="form-label">{{ __('messages.numberPlate') }}:</label>
                        <input name="matricula" type="text" placeholder="1234AAA" pattern="^\d{4}\w{3}$"
                            class="input25 form-control" value="{{ $vehiculo ? $vehiculo->matricula : '' }}" required>
                    </div>
                    <div class="d-flex flex-column">
                        {{-- Carga máxima --}}
                        <label for="cargaMax" class="form-label">{{ __('messages.maxLoad') }}: </label>
                        <select name="cargaMax" id="cargaMax" class="input25 form-select">
                            @foreach ($cargasMax as $cargaMax)
                                <option value="{{ $cargaMax }}"
                                    {{ old('cargaMax', $vehiculo->carga_max ?? '') == $cargaMax ? 'selected' : '' }}>
                                    {{ $cargaMax }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit"
                            class="btn boton-accion1 mt-3 text-center">{{ __('messages.save') }}</button>
                    </div>
                    </form>
                </div>
            </div>
        @endsection
</body>
