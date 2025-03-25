{{-- @section('Página Principal', 'TrueTrack')
@section('header', 'TrueTrack') --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Indice')
</head>

<body>
    @include('master')

    {{-- Seccion Envíos --}}
    <div class="container">
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
    </div>

</body>

</html>
