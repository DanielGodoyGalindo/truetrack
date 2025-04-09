<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Repartos')
</head>

<body>
    @include('master')
    <div class="d-flex flex-row justify-content-around">
        {{-- Si es gestor de tráfico, mostrar su nombre --}}
        <h1>Repartos @if (Auth::user()->rol == 'gestor_trafico')
                de {{ Auth::user()->name }}
            @endif
        </h1>
        {{-- Componente botón Vue --}}
        @if (Auth::user()->rol == 'gestor_trafico')
            <div id="button-app">
                <button-component button-text="✚ Nuevo reparto" button-url="{{ route('repartos.create') }}"
                    class="btn btn-primary"></button-component>
                @vite(['resources/js/app.js'])
            </div>
        @endif
    </div>
    {{-- Tabla --}}
    <div class="container">
        <table class="table">
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


            {{-- Foreach general --}}
            {{-- @foreach ($repartos as $reparto)
                    <tr>
                        <th scope="row">{{ $reparto->id }}</th>
                        @if (Auth::user()->rol == 'administrador')
                            <td>{{ $reparto->gestor->name }}</td>
                        @endif
                        <td>{{ $reparto->transportista->name }}</td>
                        <td>{{ $reparto->vehiculo->matricula }}</td>
                        <td>{{ $reparto->estado }}</td> --}}
            {{-- Borrar repartos --}}
            {{-- @if (Auth::user()->rol == 'administrador')
                            <td>
                                <form action="{{ route('repartos.destroy', $reparto->id) }}" method="POST"
                                    class="w-50">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="✖" class="btn btn-danger col-12">
                                </form>
                            </td>
                        @endif --}}
            {{-- Asignar envios --}}
            {{-- @if (Auth::user()->rol == 'gestor_trafico')
                            <td>
                                <form action="{{ route('repartos.addDeliveries', $reparto->id) }}" method="POST">
                                    @csrf
                                    <input type="submit" value="🚚" class="btn">
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach --}}


            <tbody>
                {{-- Datos para gestores --}}
                @if (Auth::user()->rol == 'gestor_trafico')
                    @foreach ($repartosGestor as $reparto)
                        <tr>
                            <th scope="row">{{ $reparto->id }}</th>
                            <td>{{ $reparto->transportista->name }}</td>
                            <td>{{ $reparto->vehiculo->matricula }}</td>
                            <td>{{ $reparto->estado }}</td>
                            {{-- Asignar envios --}}
                            <td>
                                <form action="{{ route('repartos.addDeliveries', $reparto->id) }}" method="POST">
                                    @csrf
                                    <input type="submit" value="🚚" class="btn">
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
                            <td>{{ $reparto->estado }}</td>
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
</body>

</html>
