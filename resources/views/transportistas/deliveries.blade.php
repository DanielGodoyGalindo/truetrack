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
                    <thead class="tabla-header">
                        <tr class="text-center">
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
                                    {{-- Elemento select para seleccionar estado de envio --}}
                                    <form action="{{ route('envios.actualizar', $envio->id) }}" method="POST">
                                        @csrf
                                        <div class="d-flex gap-3">
                                            <select name="estado" id="estado-{{ $envio->id }}"
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
                                                    value="{{ $envio->informacion }}" placeholder="Información no entrega"
                                                    required>
                                            </div>
                                            <button type="submit" class="btn boton-accion1">Actualizar</button>
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
                            para finalizar
                        @endif
                    </span>

                    {{-- Mostrar botón de finalizar reparto --}}
                    <input type="submit" value="Finalizar reparto"
                        @if ($numEnvios == 0 || ($numEnvios > 0 && $enviosPendientes > 0)) @disabled(true) class="btn btn-secondary"
                        @else @disabled(false) class="btn boton-verde" @endif>
                </form>

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
