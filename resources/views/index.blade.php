{{-- @section('Página Principal', 'TrueTrack')
@section('header', 'TrueTrack') --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Indice')
</head>

<body>
    @include('master')

    {{-- Tarjeta Envíos Bootstrap --}}
    {{--     <div class="container">
        <div class="card">
            <div class="card-header">
                Envíos
            </div>
            <div class="card-body">
                <h5 class="card-title">Listado de todos los envíos</h5>
                <p class="card-text">Accede a este apartado para ver todos los envíos y sus estados.</p>
                <a href="{{ route('envios.index') }}" class="btn btn-primary">Acceder</a>
            </div>
        </div>
    </div> --}}

    {{-- Componente card envíos --}}
    {{-- Se muestra el total de envíos y permite acceder a la sección de envíos --}}
    @if (Auth::check() && Auth::user()->rol == ('cliente' || 'administrador'))
        <div id="card-app">
            <card-component title-text="📦" body-text="{{ $numEnvios }} Envíos" card-url="{{ route('envios.index') }}"
                class="btn btn-light"></card-component>
            @vite(['resources/js/app.js'])
        </div>
    @endif



</body>

</html>
