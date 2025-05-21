<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Envios')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <div>
                        <h1>{{ __('messages.shipments') }} @if (Auth::user()->rol == 'cliente')
                                {{ __('messages.of') }} {{ Auth::user()->name }}
                            @endif
                        </h1>
                    </div>
                    {{-- Componentes botón Vue (nuevo envío y finalizados) --}}
                    <div id="button-app" class="d-flex flex-row gap-3">
                        <button-component button-text="✚ {{ __('messages.newShipment') }}"
                            button-url="{{ route('envios.create') }}" class="btn boton-accion1 h-75"></button-component>
                        <button-component button-text="{{ __('messages.finished') }}"
                            button-url="{{ route('envios.showCompleted') }}"
                            class="btn boton-accion1 h-75"></button-component>
                    </div>
                </div>
            @elseif (in_array(Auth::user()->rol, ['gestor_trafico', 'administrador']))
                {{-- Gestores y Admin --}}
                <div class="container d-flex flex-row">
                    <h1 class="container">{{ __('messages.shipments') }}</h1>
                    {{-- Componente botón Vue (finalizados) --}}
                    <div id="button-app">
                        <button-component button-text="{{ __('messages.finished') }}" button-url="{{ route('envios.showCompleted') }}"
                            class="btn boton-accion1"></button-component>
                    </div>
                </div>
            @endif

            {{-- Tabla --}}
            <div class="container">
                <table class="table align-middle text-center">
                    <thead class="tabla-header">
                        <tr>
                            <th scope="col">Id</th>
                            @if (in_array(Auth::user()->rol, ['gestor_trafico', 'administrador']))
                                <th scope="col">{{ __('messages.client') }}</th>
                            @endif
                            <th scope="col">{{ __('messages.addressee') }}</th>
                            <th scope="col">{{ __('messages.status') }}</th>
                            @if (Auth::user()->rol == 'gestor_trafico')
                                <th scope="col">{{ __('messages.deliveryRouteNum') }}</th>
                            @endif
                            <th scope="col">{{ __('messages.packages&Weight') }}</th>
                            @if (Auth::user()->rol == 'cliente')
                                <th scope="col" class="text-center">Mail</th>
                                <th scope="col" class="text-center">{{ __('messages.edit') }}</th>
                                <th scope="col" class="text-center">{{ __('messages.cancel') }}</th>
                            @endif
                            @if (Auth::user()->rol == 'administrador')
                                <th scope="col">{{ __('messages.delete') }}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>

                        {{-- Datos para Clientes --}}
                        @if (Auth::user()->rol == 'cliente')
                            @foreach ($enviosCliente as $envio)
                                <tr>
                                    <th scope="row">{{ $envio->id }}</th>
                                    <td class="text-start">{{ $envio->destinatario }}</td>
                                    <td @class([
                                        'texto-parpadeo-verde' => $envio->estado == 'en reparto',
                                        'texto-parpadeo-rojo' => $envio->estado == 'no entregado',
                                    ])>
                                        {{ Str::title($envio->estado) }}</td>
                                    <td>{{ $envio->bultos }} bultos - {{ $envio->kilos }} kilos</td>
                                    <td class="text-center">
                                        {{-- Formulario mandar emails --}}
                                        <form action="{{ route('envios.email', $envio->id) }}" method="POST">
                                            @csrf
                                            <input type="submit" value="📧" class="btn icono-grande">
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        {{-- Formulario editar --}}
                                        <form action="{{ route('envios.edit', $envio->id) }}" method="GET">
                                            @csrf
                                            <input type="submit" value="✏️" class="btn icono-grande">
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        {{-- Botón anular envío --}}
                                        <button class="btn icono-mediano"
                                            v-on:click="openModal('{{ route('envios.setNull', $envio->id) }}','POST')">
                                            ❌
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
                                    <td class="text-start">{{ $envio->destinatario }}</td>
                                    <td>{{ Str::title($envio->estado) }}</td>
                                    @if (Auth::user()->rol == 'gestor_trafico')
                                        <td>{{ $envio->reparto_id ?? 'No asignado' }}</td>
                                    @endif
                                    <td>{{ $envio->bultos }} bultos - {{ $envio->kilos }} kilos</td>
                                    {{-- Borrar envíos --}}
                                    @if (Auth::user()->rol == 'administrador')
                                        <td>
                                            {{-- <form action="{{ route('envios.destroy', $envio->id) }}" method="POST"
                                                    class="w-50">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="submit" value="✖" class="btn boton-rojo col-12">
                                                </form> --}}
                                            {{-- Botón borrar envío --}}
                                            <button class="btn icono-mediano"
                                                v-on:click="openModal('{{ route('envios.destroy', $envio->id) }}','DELETE')">
                                                ❌
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                        {{-- Componente Vue modal --}}
                        <modal-component v-if="showModal" :show="showModal" :route="route"
                            :method="method" v-on:close="closeModal"></modal-component>
                    </tbody>
                </table>
                {{-- Fin tabla --}}

                {{-- Paginación --}}
                <div class="d-flex justify-content-center py-3">
                    @if (Auth::user()->rol == 'cliente')
                        {{ $enviosCliente->links('pagination::bootstrap-4') }}
                    @elseif (in_array(Auth::user()->rol, ['gestor_trafico', 'administrador']))
                        {{ $enviosTotales->links('pagination::bootstrap-4') }}
                    @endif
                </div>
                {{-- Componente vue mensajes --}}
                @if (session('message'))
                    <message-component :message="'{{ session('message') }}'" />
                @endif
            </div>
        </div>
    @endsection
</body>

</html>
