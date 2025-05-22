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
            @if (Auth::check() && Auth::user()->rol == 'transportista')
                {{-- Header --}}
                <div class="container d-flex flex-row justify-content-between">
                    <h1>{{ __('messages.deliveryRoute') }} {{ $reparto->id }}</h1>
                    <div>
                        <p>{{ __('messages.trafficManager') }}: {{ $reparto->gestor->name }}</p>
                        <p>{{ __('messages.vanDriver') }}: {{ $reparto->transportista->name }}</p>
                        <p>{{ __('messages.vehicle') }}: {{ $reparto->vehiculo->matricula }}</p>
                    </div>
                </div>

                {{-- Tabla --}}
                <div class="container">
                    <h3>{{ __('messages.myDeliveries') }}:</h3>
                    <table class="table align-middle ">
                        <thead class="tabla-header">
                            <tr>
                                <th scope="col">{{ __('messages.deliveryId') }}</th>
                                <th scope="col">{{ __('messages.client') }}</th>
                                <th scope="col">{{ __('messages.addressee') }}</th>
                                <th scope="col">{{ __('messages.status') }}</th>
                                <th scope="col">{{ __('messages.packages&Weight') }}</th>
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
                                        {{-- Elemento select para seleccionar estado de envio --}}
                                        <form action="{{ route('envios.actualizar', $envio->id) }}" method="POST">
                                            @csrf
                                            <div class="d-flex gap-3 justify-content-center">
                                                <select class="form-select w-50" name="estado" id="estado-{{ $envio->id }}"
                                                    onchange="cambiarEstado({{ $envio->id }})">
                                                    @foreach ($estados as $estado)
                                                        <option value="{{ $estado }}"
                                                            {{ $estado == $envio->estado ? 'selected' : '' }}>
                                                            {{ $estado }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                {{-- Input para añadir información de no entrega --}}
                                                <div id="envio-{{ $envio->id }}"
                                                    style="display: {{ $envio->estado == 'no entregado' ? 'block' : 'none' }}">
                                                    <input id="info-{{ $envio->id }}" type="text" name="informacion"
                                                        value="{{ $envio->informacion }}"
                                                        placeholder="Razón no entrega" class="form-control" required>
                                                </div>
                                                <button type="submit" class="btn boton-accion1">{{ __('messages.update') }}</button>
                                            </div>
                                        </form>
                                    </td>
                                    <td> {{ $envio->bultos }} b. - {{ $envio->kilos }} kg</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- Fin tabla --}}

                    {{-- Botón que aparece cuando todos los envios están marcados como entregados o no entregados --}}
                    <form action=" {{ route('driver.completeDistribution', $reparto->id) }}" method="POST"
                        class="text-center">
                        @csrf
                        <span>
                            @if ($enviosPendientes > 0)
                                {{ $enviosPendientes }} {{ $enviosPendientes == 1 ? 'envío' : 'envíos' }}
                                {{ __('messages.toFinish') }}
                            @endif
                        </span>

                        {{-- Mostrar botón de finalizar reparto --}}
                        <input type="submit" value="{{ __('messages.finalizeDistribution') }}"
                            @if ($numEnvios == 0 || ($numEnvios > 0 && $enviosPendientes > 0)) @disabled(true) class="btn btn-secondary"
                        @else @disabled(false) class="btn boton-verde" @endif>
                    </form>
                </div>
            @else
                <p>No tienes permiso para acceder a esta sección</p>
            @endif
        </div>
    @endsection

</body>

<script>
    /* Mostrar u ocultar input si usuario selecciona estado 'no entregado' */
    function cambiarEstado(envioId) {
        // Interpolación y String literals
        const elementoSelect = document.querySelector(`#estado-${envioId}`);
        const elementoDiv = document.querySelector(`#envio-${envioId}`);
        const elementoInput = document.querySelector(`#info-${envioId}`)
        if (elementoSelect.value == 'no entregado') {
            elementoDiv.style.display = 'block';
            elementoInput.setAttribute('required', 'required');
        } else {
            elementoDiv.style.display = 'none';
            elementoInput.removeAttribute('required');
        }
    }
</script>

</html>
