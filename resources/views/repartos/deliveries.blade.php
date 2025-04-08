<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Repartos')
</head>

<body>
    @include('master')
    {{-- Header e info del reparto --}}
    <div class="container d-flex flex-row justify-content-around">
        <h1>Reparto {{ $reparto->id }}</h1>
        <div>
            <p>Gestor de tráfico: {{ $reparto->gestor->name }}</p>
            <p>Transportista: {{ $reparto->transportista->name }}</p>
            <p>Vehículo: {{ $reparto->vehiculo->matricula }}</p>
            <p>Carga máxima: {{ $reparto->vehiculo->carga_max }} kg</p>
        </div>
    </div>

    {{-- Tablas para asignar envios a reparto --}}
    <div class="container">

        {{-- Tabla inicial --}}
        {{-- <table class="table">
                <thead class="table-secondary">
                    <tr>
                        <th scope="col">Envío Id</th>
                        <th scope="col">Destinatario</th>
                        <th scope="col">Bultos y kilos</th>
                        <th scope="col">Añadir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($enviosPendientes as $envio)
                        <tr>
                            <th scope="row">{{ $envio->id }}</th>
                            <td>{{ $envio->destinatario }}</td>
                            <td>{{ $envio->bultos }} - {{ $envio->kilos }}</td>
                            <form action="{{ route('repartos.load2Truck', $reparto->id) }}" method="POST">
                                @csrf
                                <input type="submit" value="+" class="btn">
                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}


        {{-- Tabla con envios pendientes de reparto --}}
        <div class="container">
            <h1>Reparto: {{ $reparto->id }}</h1>
            <h2>Envíos disponibles</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Envio Id</th>
                        <th>Destinatario</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($enviosPendientes as $envio)
                        <tr>
                            <td>{{ $envio->id }}</td>
                            <td>{{ $envio->destinatario }}</td>
                            <td>{{ $envio->estado }}</td>
                            <td>
                                <form action="{{ route('repartos.asignar', $reparto->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="envio_id" value="{{ $envio->id }}">
                                    <button type="submit" class="btn btn-primary">Añadir al reparto</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h2>Envíos asignados</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Envio Id</th>
                        <th>Destinatario</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($enviosAsignados as $envio)
                        <tr>
                            <td>{{ $envio->id }}</td>
                            <td>{{ $envio->destinatario }}</td>
                            <td>{{ $envio->estado }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        {{-- Botón para asignar envios --}}
        {{--         <form method="POST" action="{{ route('repartos.storeDeliveries', $reparto->id) }}">
            @csrf
            <input type="hidden" name="envio_id" value="{{ $envio->id }}">
            <button type="submit" class="btn btn-primary">Añadir al reparto</button>
        </form> --}}

        {{-- Tabla con los envios del reparto actual --}}

    </div>

    </div>
