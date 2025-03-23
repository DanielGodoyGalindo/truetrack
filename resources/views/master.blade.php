<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Link a bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>@yield('title') - TrueTrack</title>
    <!-- Imagotipo -->
    {{-- <link rel="shortcut icon" href="{{ asset('img\pizza-battle-imagotipo-naranja.svg') }}"
        type="image/x-icon"> --}}
    <!-- Fuentes de google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- Hoja de estilos -->
    <link rel="stylesheet" href="{{ asset('css\style.css') }}">
    <!-- Galeria de iconos -->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> --}}

</head>

<body>
    <header class="mb-4 border-bottom border-dark">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="{{ route('index') }}"
                    class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <img src="{{ asset('img\Logo_TrueTrack.png') }}" alt="Logo TrueTrack" width="200px" height="70px">
                </a>
                <div class="col-md-10 text-end">
                    <a type="button" class="btn btn-outline-primary me-2" href="{{route('login')}}">Login</a>
                    <a type="button" class="btn btn-primary" href="{{route('register')}}">Registrarse</a>
                  </div>
            </div>
        </div>
    </header>
    <!-- Contenido de la pagina -->
    <main class="container-fluid d-flex flex-column align-items-center">
        @yield('content')
    </main>

    {{-- @include('includes.footer') --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
