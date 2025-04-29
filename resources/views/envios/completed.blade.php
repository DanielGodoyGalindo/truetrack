<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Envios Completados')
    @vite(['resources/js/app.js'])
</head>

<body>
    @extends('master')
    @section('content')
        <div id="app">

            {{-- Header y botón --}}
            @if (Auth::user()->rol == 'cliente') {{-- Clientes --}}
                <div class="container d-flex flex-row justify-content-between">
                    {{-- Si es cliente, mostrar su nombre --}}
                    <h1>Envíos @if (Auth::user()->rol == 'cliente')
                            de {{ Auth::user()->name }} completados
                        @endif
                    </h1>
                </div>
            @else
                {{-- Gestores y Admin --}}
                <h1 class="container">Envíos finalizados</h1>
            @endif

            {{-- Tabla --}}
            <div class="container">
                <table class="table align-middle text-center">
                    <thead class="tabla-header">
                        <tr>
                            <th scope="col">Id</th>
                            @if (in_array(Auth::user()->rol, ['gestor_trafico', 'administrador']))
                                <th scope="col">Cliente</th>
                            @endif
                            <th scope="col">Destinatario</th>
                            <th scope="col">Estado</th>
                            @if (Auth::user()->rol == 'gestor_trafico')
                                <th scope="col">Num. reparto</th>
                            @endif
                            <th scope="col">Bultos y kilos</th>
                            @if (Auth::user()->rol == 'administrador')
                                <th scope="col">Borrar</th>
                            @endif
                            @if (Auth::user()->rol == 'cliente')
                                <th scope="col" class="text-center">Mail</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>


                        {{-- Datos para Clientes --}}
                        @if (Auth::user()->rol == 'cliente')
                            @foreach ($enviosCompletadosCli as $envio)
                                <tr>
                                    <th scope="row">{{ $envio->id }}</th>
                                    <td>{{ $envio->destinatario }}</td>
                                    <td>{{ Str::title($envio->estado) }}</td>
                                    <td>{{ $envio->bultos }} bultos - {{ $envio->kilos }} kilos</td>
                                    <td class="text-center">
                                        {{-- Formulario mandar emails --}}
                                        <form action="{{ route('envios.email', $envio->id) }}" method="POST">
                                            @csrf
                                            <input type="submit" value="📧" class="btn icono-grande">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        {{-- Datos para Gestores y Admin --}}
                        @if (in_array(Auth::user()->rol, ['gestor_trafico', 'administrador']))
                            @foreach ($enviosCompletadosNoCli as $envio)
                                <tr>
                                    <th scope="row">{{ $envio->id }}</th>
                                    <td>{{ $envio->cliente->name }}</td>
                                    <td>{{ $envio->destinatario }}</td>
                                    <td>{{ Str::title($envio->estado) }}</td>
                                    @if (Auth::user()->rol == 'gestor_trafico')
                                        <td>{{ $envio->reparto_id ?? 'No asignado' }}</td>
                                    @endif
                                    <td>{{ $envio->bultos }} bultos - {{ $envio->kilos }} kilos</td>
                                    {{-- Borrar envíos --}}
                                    @if (Auth::user()->rol == 'administrador')
                                        <td>
                                            <form action="{{ route('envios.destroy', $envio->id) }}" method="POST"
                                                class="w-50">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" value="✖" class="btn boton-rojo col-12">
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
                {{-- Fin tabla --}}
            </div>

            {{-- Paginación --}}
            <div class="container d-flex justify-content-center py-3">
                @if (Auth::user()->rol == 'cliente')
                    {{ $enviosCompletadosCli->links('pagination::bootstrap-4') }}
                @elseif (in_array(Auth::user()->rol, ['gestor_trafico', 'administrador']))
                    {{ $enviosCompletadosNoCli->links('pagination::bootstrap-4') }}
                @endif
            </div>

            {{-- Componente botón Vue (volver) --}}
            <div id="button-app" class="container text-center">
                <button-component button-text="Volver" button-url="{{ route('envios.index') }}"
                    class="btn boton-accion1"></button-component>
            </div>
        </div>
    @endsection
</body>

</html>
