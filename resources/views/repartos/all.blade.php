<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Repartos')
</head>

<body>
    @extends('master')
    @section('content')
        <div id="app">
            <div
                @if (Auth::user()->rol == 'gestor_trafico') class="container d-flex flex-row justify-content-between" 
                @else class="container" @endif>
                {{-- Si es gestor de tráfico, mostrar su nombre --}}
                <h1>Repartos @if (Auth::user()->rol == 'gestor_trafico')
                        de {{ Auth::user()->name }}
                    @endif
                </h1>
                @if (Auth::user()->rol == 'gestor_trafico')
                    {{-- Componentes botón Vue (nuevo reparto y finalizados) --}}
                    <div id="button-app" class="d-flex flex-row gap-3">
                        <button-component button-text="✚ Nuevo reparto" button-url="{{ route('repartos.create') }}"
                            class="btn btn-primary h-75"></button-component>
                        <button-component button-text="Finalizados"
                            button-url="{{ route('repartos.showDeliveriesCompleted') }}"
                            class="btn btn-primary h-75"></button-component>
                        @vite(['resources/js/app.js'])
                    </div>
                @endif
            </div>
            {{-- Tabla --}}
            <div class="container">
                <table class="table align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th scope="col">Id</th>
                            @if (Auth::user()->rol == 'administrador')
                                <th scope="col">Gestor tráfico</th>
                            @endif
                            <th scope="col">Transportista</th>
                            <th scope="col">Vehículo</th>
                            <th scope="col">Estado</th>
                            @if (Auth::user()->rol == 'administrador')
                                <th scope="col" class="text-center">Borrar</th>
                            @endif
                            @if (Auth::user()->rol == 'gestor_trafico')
                                <th scope="col">Asignar envíos</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        {{-- Datos para gestores --}}
                        @if (Auth::user()->rol == 'gestor_trafico')
                            @foreach ($repartosGestor as $reparto)
                                <tr>
                                    <th scope="row">{{ $reparto->id }}</th>
                                    <td>{{ $reparto->transportista->name }}</td>
                                    <td>{{ $reparto->vehiculo->matricula }}</td>
                                    <td>{{ Str::title($reparto->estado) }}</td>
                                    {{-- Asignar envios --}}
                                    <td>
                                        <form action="{{ route('repartos.addDeliveries', $reparto->id) }}" method="POST">
                                            @csrf
                                            <input type="submit" value="🚚" class="btn fs-3">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        {{-- Datos para admin --}}
                        @if (Auth::user()->rol == 'administrador')
                            @foreach ($repartosAdmin as $reparto)
                                <tr>
                                    <th scope="row">{{ $reparto->id }}</th>
                                    <td>{{ $reparto->gestor->name }}</td>
                                    <td>{{ $reparto->transportista->name }}</td>
                                    <td>{{ $reparto->vehiculo->matricula }}</td>
                                    <td>{{ Str::title($reparto->estado) }}</td>
                                    {{-- Borrar repartos --}}
                                    <td>
                                        <form action="{{ route('repartos.destroy', $reparto->id) }}" method="POST"
                                            class="w-50">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" value="✖" class="btn btn-danger col-12">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
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

        </div>
    @endsection
</body>

</html>
