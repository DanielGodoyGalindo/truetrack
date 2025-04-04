<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Envios')
</head>

<body>
    @include('master')
    <div class="d-flex flex-row justify-content-around">
        {{-- Si es cliente, mostrar su nombre --}}
        <h1>Envíos @if (Auth::user()->rol == 'cliente')
                de {{ Auth::user()->name }}
            @endif
        </h1>
        {{-- Componente botón Vue --}}
        @if (Auth::user()->rol == 'cliente')
            <div id="button-app">
                <button-component button-text="✚ Nuevo envío" button-url="{{ route('envios.create') }}"
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
                        <th scope="col">Cliente</th>
                    @endif
                    <th scope="col">Destinatario</th>
                    <th scope="col">Estado</th>
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
                @foreach ($envios as $envio)
                    <tr>
                        <th scope="row">{{ $envio->id }}</th>
                        @if (Auth::user()->rol == 'administrador')
                            <td>{{ $envio->cliente->name }}</td>
                        @endif
                        <td>{{ $envio->destinatario }}</td>
                        <td>{{ $envio->estado }}</td>
                        <td>{{ $envio->bultos }} bultos - {{ $envio->kilos }} kilos</td>
                        @if (Auth::user()->rol == 'cliente')
                            <td class="text-center">
                                {{-- Formulario mandar emails --}}
                                <form action="{{ route('envios.email', $envio->id) }}" method="POST">
                                    @csrf
                                    <input type="submit" value="Enviar" class="btn btn-info">
                                </form>
                            </td>
                            <td class="text-center">
                                {{-- Formulario para anular envíos --}}
                                <form action="{{ route('envios.setNull', $envio->id) }}" method="POST">
                                    @csrf
                                    <input type="submit" value="Anular" class="btn btn-danger">
                                </form>
                            </td>
                        @endif
                        {{-- Borrar envíos --}}
                        @if (Auth::user()->rol == 'administrador')
                            <td>
                                <form action="{{ route('envios.destroy', $envio->id) }}" method="POST" class="w-50">
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
        {{ $envios->links('pagination::bootstrap-4') }}
    </div>
</body>

</html>
