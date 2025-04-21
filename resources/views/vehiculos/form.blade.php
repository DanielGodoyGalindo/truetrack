<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Nuevo vehículo')
    @vite(['resources/js/app.js'])
</head>

<body>
    @extends('master')
    @section('content')
        <div id="app">
            <div class="container">
                <h1>Nuevo vehículo</h1>
                {{-- Formulario --}}
                @if ($vehiculo)
                    <form action="{{ route('vehiculos.update', $vehiculo->id) }}" method="POST">
                        @method('PUT')
                        <p>editando</p>
                    @else
                        <form action="{{ route('vehiculos.store') }}" method="POST">
                        <p>guardando</p>
                @endif
                @csrf
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex flex-column">
                        <label for="matricula">Matrícula:</label>
                        <input name="matricula" type="text" placeholder="1234AAA" pattern="^\d{4}\w{3}$" class="input25"
                            value="{{ $vehiculo ? $vehiculo->matricula : '' }}" required>
                    </div>
                    <div class="d-flex flex-column">
                        <label for="cargaMax">Carga máxima: </label>
                        <select name="cargaMax" id="cargaMax" class="input25">
                            @foreach ($cargasMax as $cargaMax)
                                <option value="{{ $cargaMax }}"
                                    {{ old('cargaMax', $vehiculo->carga_max ?? '') == $cargaMax ? 'selected' : '' }}>
                                    {{ $cargaMax }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn boton-accion1 mt-3 text-center">Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        @endsection
</body>
