<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Usuarios')
    @vite(['resources/js/app.js'])
</head>

<body>
    @extends('master')
    @section('content')
        <div id="app">
            <div class="container">
                <h1>{{ $usuario ? 'Editar usuario' : 'Nuevo usuario' }}</h1>
                {{-- Formulario --}}
                @if ($usuario)
                    <form action="{{ route('users.update', $usuario->id) }}" method="POST">
                        @method('PUT')
                    @else
                        <form action="{{ route('users.store') }}" method="POST">
                @endif
                @csrf
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex flex-column">
                        <label for="nombre">Nombre:</label>
                        <input name="nombre" type="text" placeholder="Nombre" class="input25"
                            value="{{ $usuario ? $usuario->name : '' }}" required>
                    </div>
                    <div class="d-flex flex-column">
                        <label for="email">Email:</label>
                        <input name="email" type="email" placeholder="nombre@dominio.com" class="input25"
                            value="{{ $usuario ? $usuario->email : '' }}" required>
                    </div>
                    @if (!$usuario)
                        <div class="d-flex flex-column">
                            <label for="password">Password:</label>
                            <input name="password" type="password" placeholder="********" class="input25" minlength="8" required>
                        </div>
                    @endif
                    <div class="d-flex flex-column">
                        <label for="rol">Rol: </label>
                        <select name="rol" id="rol" class="input25">
                            @foreach ($roles as $rol)
                                <option value="{{ $rol }}"
                                    {{ old('rol', $usuario->rol ?? '') == $rol ? 'selected' : '' }}>
                                    {{ $rol }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn boton-accion1 mt-3 text-center">Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        @endsection
</body>
