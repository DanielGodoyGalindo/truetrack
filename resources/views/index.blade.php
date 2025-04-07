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

    {{-- Sólo para pruebas- Mostrar usuario conectado --}}
    <p>Usuario conectado: {{ Auth::user()->name ?? 'nadie' }}</p>

    {{-- Componente card envíos --}}
    {{-- Comprueba que el rol del usuario autenticado sea cliente, administrador o gestor --}}
    {{-- Se muestra el total de envíos y permite acceder a la sección de envíos --}}
    @if (Auth::check() && in_array(Auth::user()->rol, ['cliente', 'administrador', 'gestor_trafico']))
        <div id="card-envios">
            <card-component title-text="📦"
                @if (Auth::check() && Auth::user()->rol == 'cliente') body-text="{{ $numEnviosCliente }} Envíos"
                @elseif (Auth::check() && in_array(Auth::user()->rol, ['gestor_trafico', 'administrador']))
                    body-text="{{ $numEnviosTotales }} Envíos" @endif
                card-url="{{ route('envios.index') }}" class="btn btn-light"></card-component>
            @vite(['resources/js/app.js'])
        </div>
    @endif

    {{-- Componente card repartos --}} {{-- Muestra el total de repartos y permite acceder a la sección de repartos --}}
    @if (Auth::check() && in_array(Auth::user()->rol, ['gestor_trafico', 'administrador']))
        <div id="card-repartos">
            <card-component title-text="🚚"
                @if (Auth::check() && Auth::user()->rol == 'gestor_trafico') body-text="{{ $numRepartosGestor }} Repartos"
                @elseif (Auth::check() && Auth::user() == 'administrador')
                    body-text="{{ $numRepartosTotales }} Repartos" @endif
                card-url="{{ route('repartos.index') }}" class="btn btn-light"></card-component>
            @vite(['resources/js/app.js'])
        </div>
    @endif

</body>

</html>
