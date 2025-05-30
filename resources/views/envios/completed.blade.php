<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Envios Completados')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/app.js'])
</head>

<body>
    @extends('master')
    @section('content')
        <div id="app">

            <div class="d-flex container">
                {{-- Header y botón --}}
                @if (Auth::user()->rol == 'cliente') {{-- Clientes --}}
                    <div class="container d-flex flex-row justify-content-between">
                        {{-- Si es cliente, mostrar su nombre --}}
                        <h1>{{ __('messages.shipments') }} @if (Auth::user()->rol == 'cliente')
                                {{ __('messages.of') }} {{ Auth::user()->name }} finalizados
                            @endif
                        </h1>
                    </div>
                @else
                    {{-- Gestores y Admin --}}
                    <h1 class="container">{{ __('messages.finishedShipments') }}</h1>
                @endif

                {{-- Inputs de fechas --}}
                <form method="GET" action="{{ route('envios.showCompleted') }}">
                    <div class="d-flex gap-2">
                        <div>
                            <label for="fecha1">{{ __('messages.from') }}:</label>
                            <input type="date" name="fecha1" value="{{ request('fecha1') }}" class="form-control"
                                required>
                        </div>
                        <div>
                            <label for="fecha2">{{ __('messages.until') }}:</label>
                            <input type="date" name="fecha2" value="{{ request('fecha2') }}" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-2 mb-3">
                        <button type="submit" class="btn boton-accion1">{{ __('messages.filterByDates') }}</button>
                    </div>

                </form>
            </div>

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
                            <th scope="col">{{ __('messages.creationDate') }}</th>
                            @if (Auth::user()->rol == 'administrador')
                                <th scope="col">{{ __('messages.delete') }}</th>
                            @endif
                            @if (Auth::user()->rol == 'cliente')
                                <th scope="col" class="text-center">Email</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>


                        {{-- Datos para Clientes --}}
                        @if (Auth::user()->rol == 'cliente')
                            @foreach ($enviosCompletadosCli as $envio)
                                <tr>
                                    <th scope="row">{{ $envio->id }}</th>
                                    <td class="text-start">{{ $envio->destinatario }}</td>
                                    <td>{{ Str::title($envio->estado) }}</td>
                                    <td>{{ $envio->bultos }} {{ __('messages.packages') }} - {{ $envio->kilos }}
                                        {{ __('messages.kilograms') }}</td>
                                    <td>{{ $envio->created_at->format('d-m-Y') }}</td>
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
                                    <td class="text-start">{{ $envio->destinatario }}</td>
                                    <td>{{ Str::title($envio->estado) }}</td>
                                    @if (Auth::user()->rol == 'gestor_trafico')
                                        <td>{{ $envio->reparto_id ?? 'No asignado' }}</td>
                                    @endif
                                    <td>{{ $envio->bultos }} {{ __('messages.packages') }} - {{ $envio->kilos }}
                                        {{ __('messages.kilograms') }}</td>
                                    <td>{{ $envio->created_at->format('d-m-Y') }}</td>
                                    {{-- Borrar envíos --}}
                                    @if (Auth::user()->rol == 'administrador')
                                        <td>
                                            {{-- <form action="{{ route('envios.destroy', $envio->id) }}" method="POST"
                                                class="w-50">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" value="✖" class="btn boton-rojo col-12">
                                            </form> --}}
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
                            :method="method" v-on:close="closeModal"
                            lang="{{ LaravelLocalization::getCurrentLocale() }}"></modal-component>
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
                <button-component button-text="{{ __('messages.back') }}" button-url="{{ route('envios.index') }}"
                    class="btn boton-accion1"></button-component>
            </div>
        </div>
    @endsection
</body>

</html>
