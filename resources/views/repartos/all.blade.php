<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Repartos')
</head>

<body>
    @include('master')
    <div class="d-flex flex-row justify-content-around">
        {{-- Si es cliente, mostrar su nombre --}}
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
                </tr>
            </thead>
            <tbody>
                @foreach ($repartos as $reparto)
                    <tr>
                        <th scope="row">{{ $reparto->id }}</th>
                        @if (Auth::user()->rol == 'administrador')
                            <td>{{ $reparto->gestor->name }}</td>
                        @endif
                        <td>{{ $reparto->transportista->name }}</td>
                        <td>{{ $reparto->vehiculo->matricula }}</td>
                        <td>{{ $reparto->estado }}</td>
                        {{-- Borrar repartos --}}
                        @if (Auth::user()->rol == 'administrador')
                            <td>
                                <form action="{{ route('repartos.destroy', $reparto->id) }}" method="POST" class="w-50">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="✖" class="btn btn-danger col-12">
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- Fin tabla --}}
    {{-- Paginación --}}
    <div class="d-flex justify-content-center py-3">
        {{ $repartos->links('pagination::bootstrap-4') }}
    </div>
</body>

</html>
