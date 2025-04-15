<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Reparto')
    @vite(['resources/js/app.js'])
</head>

<body>
    @extends('master')
    @section('content')
        <div id="app">
            {{-- Header --}}
            <div class="container d-flex flex-row justify-content-between">
                <h1>Reparto {{ $reparto->id }}</h1>
                <div>
                    <p>Gestor de tráfico: {{ $reparto->gestor->name }}</p>
                    <p>Transportista: {{ $reparto->transportista->name }}</p>
                    <p>Vehículo: {{ $reparto->vehiculo->matricula }}</p>
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

                                    {{-- Guardar envios y su estado en array asociativo --}}
                                    <form action="{{ route('envios.actualizar', $envio->id) }}" method="POST">
                                        @csrf
                                        {{-- @method('POST') --}}
                                        <select name="estado">
                                            @foreach ($estados as $estado)
                                                <option value="{{ $estado }}"
                                                    {{ $estado == $envio->estado ? 'selected' : '' }}>{{ $estado }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div id="envio-{{ $envio->id }}"
                                            style="display: {{ $envio->estado == 'no entregado' ? 'block' : 'none' }}">
                                            <input type="text" name="informacion" value="{{ $envio->informacion }}"
                                                placeholder="Razón no entrega...">
                                        </div>
                                        <button type="submit">Actualizar</button>
                                    </form>

                                </td>
                                <td> {{ $envio->bultos }} b. - {{ $envio->kilos }} kg</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Fin tabla --}}
                {{-- </form> --}}
            </div>
        @endsection
</body>

</html>
