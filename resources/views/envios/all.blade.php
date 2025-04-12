<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Envios')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/js/app.js')
</head>

<body>
    @extends('master')
    <div id="app">
        @section('content')
            {{-- Header y botón --}}
            @if (Auth::user()->rol == 'cliente') {{-- Clientes --}}
                <div class="container d-flex flex-row justify-content-between">
                    {{-- Si es cliente, mostrar su nombre --}}
                    <div>
                        <h1>Envíos @if (Auth::user()->rol == 'cliente')
                                de {{ Auth::user()->name }}
                            @endif
                        </h1>
                    </div>
                    {{-- Componentes botón Vue (nuevo envío y finalizados) --}}
                    <div id="button-app" class="d-flex flex-row gap-3">
                        <button-component button-text="✚ Nuevo envío" button-url="{{ route('envios.create') }}"
                            class="btn btn-primary h-75"></button-component>
                        <button-component button-text="Finalizados" button-url="{{ route('envios.showCompleted') }}"
                            class="btn btn-primary h-75"></button-component>
                    </div>
                </div>
            @elseif (in_array(Auth::user()->rol, ['gestor_trafico', 'administrador']))
                {{-- Gestores y Admin --}}
                <div class="container d-flex flex-row">
                    <h1 class="container">Envíos</h1>
                    {{-- Componente botón Vue (finalizados) --}}
                    <div id="button-app">
                        <button-component button-text="Finalizados" button-url="{{ route('envios.showCompleted') }}"
                            class="btn btn-primary"></button-component>
                        @vite(['resources/js/app.js'])
                    </div>
                </div>
            @endif

            {{-- Tabla --}}
            <div class="container">
                <div id="deleteModal-app">
                    <table class="table align-middle">
                        <thead class="table-secondary">
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
                                @if (Auth::user()->rol == 'cliente')
                                    <th scope="col" class="text-center">Mail</th>
                                    <th scope="col" class="text-center">Anular</th>
                                @endif
                                @if (Auth::user()->rol == 'administrador')
                                    <th scope="col">Borrar</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            {{-- forEach original --}}
                            {{-- @foreach ($enviosCliente as $envio)
                        <tr>
                        <th scope="row">{{ $envio->id }}</th>
                        @if (in_array(Auth::user()->rol, ['gestor_trafico', 'administrador']))
                            <td>{{ $envio->cliente->name }}</td>
                        @endif
                        <td>{{ $envio->destinatario }}</td>
                        <td>{{ $envio->estado }}</td>
                        @if (Auth::user()->rol == 'gestor_trafico')
                            <td>{{ $envio->reparto_id ?? 'No asignado' }}</td>
                        @endif
                        <td>{{ $envio->bultos }} bultos - {{ $envio->kilos }} kilos</td>
                        @if (Auth::user()->rol == 'cliente')
                            <td class="text-center"> --}}
                            {{-- Formulario mandar emails --}}
                            {{-- <form action="{{ route('envios.email', $envio->id) }}" method="POST">
                                    @csrf
                                    <input type="submit" value="Enviar" class="btn btn-info">
                                </form>
                            </td>
                            <td class="text-center"> --}}
                            {{-- Formulario para anular envíos --}}
                            {{-- <form action="{{ route('envios.setNull', $envio->id) }}" method="POST">
                                    @csrf
                                    <input type="submit" value="Anular" class="btn btn-danger">
                                </form>
                            </td>
                        @endif --}}
                            {{-- Borrar envíos --}}
                            {{-- @if (Auth::user()->rol == 'administrador')
                            <td>
                                <form action="{{ route('envios.destroy', $envio->id) }}" method="POST" class="w-50">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="✖" class="btn btn-danger col-12">
                                </form>
                            </td>
                        @endif
                        </tr>
                        @endforeach --}}


                            {{-- Datos para Clientes --}}
                            @if (Auth::user()->rol == 'cliente')
                                @foreach ($enviosCliente as $envio)
                                    <tr>
                                        <th scope="row">{{ $envio->id }}</th>
                                        <td>{{ $envio->destinatario }}</td>
                                        <td>{{ $envio->estado }}</td>
                                        <td>{{ $envio->bultos }} bultos - {{ $envio->kilos }} kilos</td>
                                        <td class="text-center">
                                            {{-- Formulario mandar emails --}}
                                            <form action="{{ route('envios.email', $envio->id) }}" method="POST">
                                                @csrf
                                                <input type="submit" value="Enviar" class="btn btn-info">
                                            </form>
                                        </td>

                                        {{-- Formulario para anular envíos
                                        <td class="text-center">
                                            <form action="{{ route('envios.setNull', $envio->id) }}" method="POST">
                                                @csrf
                                                <input type="submit" value="Anular" class="btn btn-danger">
                                            </form> 
                                        </td> --}}

                                        <td class="text-center">
                                            {{-- Botón anular envío --}}
                                            <button class="btn btn-danger"
                                                v-on:click="openModal('{{ route('envios.setNull', $envio->id) }}')">
                                                Anular
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                            @endif

                            {{-- Datos para Gestores y Admin --}}
                            @if (in_array(Auth::user()->rol, ['gestor_trafico', 'administrador']))
                                @foreach ($enviosTotales as $envio)
                                    <tr>
                                        <th scope="row">{{ $envio->id }}</th>
                                        <td>{{ $envio->cliente->name }}</td>
                                        <td>{{ $envio->destinatario }}</td>
                                        <td>{{ $envio->estado }}</td>
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
                                                    <input type="submit" value="✖" class="btn btn-danger col-12">
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                            {{-- Componente Vue modal --}}
                            <modal-component v-if="showModal" :show="showModal" :route="route"
                                v-on:close="closeModal"></modal-component>
                        </tbody>
                    </table>
                    {{-- Fin tabla --}}
                </div>

                {{-- Paginación --}}
                <div class="d-flex justify-content-center py-3">
                    @if (Auth::user()->rol == 'cliente')
                        {{ $enviosCliente->links('pagination::bootstrap-4') }}
                    @elseif (in_array(Auth::user()->rol, ['gestor_trafico', 'administrador']))
                        {{ $enviosTotales->links('pagination::bootstrap-4') }}
                    @endif
                </div>
            </div>
        </div>
    @endsection
</body>

</html>
