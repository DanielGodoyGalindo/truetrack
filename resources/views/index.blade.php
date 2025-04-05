{{-- @section('Página Principal', 'TrueTrack')
@section('header', 'TrueTrack') --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Página Principal')
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
    @if (Auth::check() && Auth::user()->rol == ('cliente' || 'administrador' || 'gestor_trafico'))
        <div id="card-envios">
            <card-component title-text="📦" body-text="{{ $numEnvios }} Envíos" card-url="{{ route('envios.index') }}"
                class="btn btn-light"></card-component>
            @vite(['resources/js/app.js'])
        </div>
    @endif

    {{-- Componente card repartos --}}
    {{-- Muestra el total de repartos y permite acceder a la sección de repartos --}}
    @if (Auth::check() && Auth::user()->rol == ('gestor_trafico' || 'administrador'))
        <div id="card-repartos">
            <card-component title-text="🚚" body-text="{{ $numRepartos }} Repartos"
                card-url="{{ route('repartos.index') }}" class="btn btn-light"></card-component>
            @vite(['resources/js/app.js'])
        </div>
    @endif

</body>

</html>
