<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Página Principal')
    @vite(['resources/js/app.js'])
</head>

<body>
    @extends('master')
    @section('content')
        {{-- Carga de componente Vue --}}
        <div id="app">

            {{-- Sólo para pruebas- Mostrar usuario conectado --}}
            @auth
                <div class="container" style="color: red; font-size: 1.5rem">
                    <p>Usuario conectado: {{ Auth::user()->name }}</p>
                    <p>Con ID: {{ Auth::user()->id }}</p>
                </div>
            @endauth

            {{-- Imagen index + mensaje --}}
            @guest
                <div class="container d-flex flex-column align-items-center">
                    <img src="{{ asset('img/furgoneta-reparto.jpg') }}" alt="Furgoneta de reparto" id="furgoneta">
                    <p class="h1">¡Bienvenido/a!</p>
                    <p class="h1">Por favor, accede con tu usuario o regístrate</p>
                </div>
            @endguest

            {{-- Componente card envíos --}}
            {{-- Comprueba que el rol del usuario autenticado sea cliente, administrador o gestor --}}
            {{-- Se muestra el total de envíos y permite acceder a la sección de envíos --}}
            @if (Auth::check() && in_array(Auth::user()->rol, ['cliente', 'administrador', 'gestor_trafico']))
                <card-component title-text="📦"
                    @if (Auth::check() && Auth::user()->rol == 'cliente') body-text="{{ $numEnviosCliente }} {{ $numEnviosCliente == 1 ? 'Envío' : 'Envíos' }}"
                @elseif (Auth::check() && in_array(Auth::user()->rol, ['gestor_trafico', 'administrador']))
                    body-text="{{ $numEnviosTotales }} {{ $numEnviosTotales == 1 ? 'Envío' : 'Envíos' }}" @endif
                    card-url="{{ route('envios.index') }}" class="btn btn-light"></card-component>
            @endif

            {{-- Componente card repartos --}} {{-- Muestra el total de repartos y permite acceder a la sección de repartos --}}
            @if (Auth::check() && in_array(Auth::user()->rol, ['gestor_trafico', 'administrador']))
                <card-component title-text="🚚"
                    @if (Auth::check() && Auth::user()->rol == 'gestor_trafico') body-text="{{ $numRepartosGestor }} {{ $numRepartosGestor == 1 ? 'Reparto' : 'Repartos' }}"
                @elseif (Auth::check() && Auth::user()->rol == 'administrador')
                    body-text="{{ $numRepartosTotales }} {{ $numRepartosTotales == 1 ? 'Reparto' : 'Repartos' }}" @endif
                    card-url="{{ route('repartos.index') }}" class="btn btn-light"></card-component>
            @endif

            {{-- Solo Admin --}}
            {{-- Componente card de vehiculos --}}
            @if (Auth::check() && Auth::user()->rol == 'administrador')
                <card-component title-text="🔧{{-- ⚙️ --}}" body-text="Vehículos"
                    card-url="{{ route('vehiculos.index') }}" class="btn btn-light">
                </card-component>
                {{-- Componente card de usuarios --}}
                <card-component title-text="👤" body-text="Usuarios" card-url="{{ route('users.index') }}"
                    class="btn btn-light">
                </card-component>
            @endif

        </div>
    @endsection
</body>

</html>
