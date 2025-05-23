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
                <h1>{{ $usuario ? __('messages.editUser') : __('messages.newUser') }}</h1>
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
                        {{-- Nombre --}}
                        <label for="nombre" class="form-label">{{ __('messages.name') }}:</label>
                        <input name="nombre" type="text" placeholder="{{ __('messages.name') }}" class="input25 form-control"
                            value="{{ $usuario ? $usuario->name : '' }}" minlength="3" required>
                    </div>
                    <div class="d-flex flex-column">
                        {{-- Email --}}
                        <label for="email" class="form-label">Email:</label>
                        <input name="email" type="email" placeholder="{{ __('messages.emailPlaceholder') }}" class="input25 form-control"
                            value="{{ $usuario ? $usuario->email : '' }}" pattern="^[\w\.-]+@[\w\.-]+\.\w{2,}$" required>
                    </div>
                    @if (!$usuario)
                        <div class="d-flex flex-column">
                            {{-- Contraseña --}}
                            <label for="password" class="form-label">Password:</label>
                            <input name="password" type="password" placeholder="********" class="input25 form-control"
                                minlength="8" required>
                        </div>
                    @endif
                    <div class="d-flex flex-column">
                        {{-- Rol de usuario --}}
                        <label for="rol" class="form-label">{{ __('messages.role') }}: </label>
                        <select name="rol" id="rol" class="input25 form-select">
                            @foreach ($roles as $rol)
                                <option value="{{ $rol }}"
                                    {{ old('rol', $usuario->rol ?? '') == $rol ? 'selected' : '' }}>
                                    {{ $rol }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn boton-accion1 mt-3 text-center">{{ __('messages.save') }}</button>
                    </div>
                    </form>
                </div>
            </div>
        @endsection
</body>
