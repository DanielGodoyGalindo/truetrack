<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Reparto {{ $reparto->id }}')
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    @vite('resources/js/app.js')
</head>

<body>
    @extends('master')
    @section('content')
        <div id="app">
            <form action="{{ route('driver.updateDistribution', $reparto->id) }}" method="POST">
                @csrf
                {{-- Header --}}
                <div class="container d-flex flex-row justify-content-between">
                    <h1>Reparto {{ $reparto->id }}</h1>
                    <div>
                        <p>Gestor de tráfico: {{ $reparto->gestor->name }}</p>
                        <p>Transportista: {{ $reparto->transportista->name }}</p>
                        <p>Vehículo: {{ $reparto->vehiculo->matricula }}</p>
                    </div>
                    {{-- Componente botón --}}
                    <div id="button-app" class="align-self-end">
                        <button-component button-text="Guardar estados"
                            button-url="{{ route('driver.updateDistribution', $reparto->id) }}"
                            class="btn btn-primary"></button-component>
                    </div>
                </div>

                {{-- Tabla --}}
                <div class="container">
                    <h3>Mis entregas:</h3>
                    <table class="table align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th scope="col">Envío Id</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Destinatario</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Bultos y kilos</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Datos --}}
                            @foreach ($envios as $envio)
                                <tr>
                                    <th scope="row">{{ $envio->id }}</th>
                                    <td>{{ $envio->cliente->name }}</td>
                                    <td>{{ $envio->destinatario }}</td>
                                    <td>
                                        <select name="envios[{{ $envio->id }}]"> {{-- Guardar envios y su estado en array asociativo --}}
                                            @foreach ($estados as $estado)
                                                <option value="{{ $estado }}"
                                                    {{ $estado == $envio->estado ? 'selected' : '' }}>{{ $estado }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td> {{ $envio->bultos }} b. - {{ $envio->kilos }} kg</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- Fin tabla --}}
            </form>
        </div>
    @endsection
</body>

</html>
