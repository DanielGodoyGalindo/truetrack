<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Envios')
</head>

<body>
    @include('master')
    <div class="d-flex flex-row justify-content-around">
        <h1>Envíos</h1>
        <div id="app">
            <button-component button-text="✚ Nuevo envío" class="btn btn-primary"></button-component>
        </div>
        @vite(['resources/js/app.js'])
    </div>
    {{-- Tabla --}}
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Cliente</th>
                <th scope="col">Destinatario</th>
                <th scope="col">Estado</th>
                <th scope="col">Bultos y kilos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($envios as $envio)
                <tr>
                    <th scope="row">{{ $envio->id }}</th>
                    <td>{{ $envio->cliente->name }}</td>
                    <td>{{ $envio->destinatario }}</td>
                    <td>{{ $envio->estado }}</td>
                    <td>{{ $envio->bultos }} bultos - {{ $envio->kilos }} kilos</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- Fin tabla --}}
    {{-- Paginación --}}
    <div class="d-flex justify-content-center py-3">
        {{ $envios->links('pagination::bootstrap-4') }}
    </div>
</body>

</html>
