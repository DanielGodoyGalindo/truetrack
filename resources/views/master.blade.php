<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Link a bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>@yield('title') - TrueTrack</title>
    <!-- Fuentes de google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- Hoja de estilos -->
    <link rel="stylesheet" href="{{ asset('css\style.css') }}">
</head>

<body>
    {{-- Carga de app Vue --}}
    <div id="app" class="d-flex flex-column min-vh-100">
        {{-- Barra de navegación --}}
        <header class="mb-4">
            <div>
                @include('layouts.barraNavegacion')
            </div>
        </header>
        {{-- Contenido de la pagina --}}
        <main class="flex-grow-1">
            @yield('content')
        </main>
        {{-- Footer --}}
        @include('layouts.footer')
    </div>
</body>

</html>
