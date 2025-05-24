<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Usuarios')
    @vite(['resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @extends('master')
    @section('content')
        <div id="app">
            {{-- Header y botón --}}
            @if (Auth::user()->rol == 'administrador')
                <div class="container d-flex flex-row justify-content-between">
                    <div>
                        <h1>{{ __('messages.users') }}</h1>
                    </div>
                    {{-- Componentes botón Vue (nuevo usuario) --}}
                    <div id="button-app" class="d-flex flex-row gap-3">
                        <button-component button-text="✚ {{ __('messages.newUser') }}"
                            button-url="{{ route('users.create') }}" class="btn boton-accion1 h-75"></button-component>
                    </div>
                </div>
                {{-- Tabla --}}
                <div class="container">
                    <table class="table align-middle text-center">
                        <thead class="tabla-header">
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">{{ __('messages.name') }}</th>
                                <th scope="col">Email</th>
                                <th scope="col">{{ __('messages.role') }}</th>
                                <th scope="col">{{ __('messages.edit') }}</th>
                                <th scope="col">{{ __('messages.delete') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <th scope="row">{{ $usuario->id }}</th>
                                    <td>{{ $usuario->name }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>{{ $usuario->rol }}</td>
                                    <td>
                                        {{-- Formulario editar usuarios --}}
                                        <form action="{{ route('users.edit', $usuario->id) }}" method="GET">
                                            @csrf
                                            <input type="submit" value="✏️" class="btn icono-grande">
                                        </form>
                                    </td>
                                    <td>
                                        {{-- Borrar usuarios --}}
                                        <button class="btn icono-mediano"
                                            v-on:click="openModal('{{ route('users.destroy', $usuario->id) }}','DELETE')">
                                            ❌
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            {{-- Componente Vue modal --}}
                            <modal-component v-if="showModal" :show="showModal" :route="route"
                                :method="method" v-on:close="closeModal"
                                lang="{{ LaravelLocalization::getCurrentLocale() }}"></modal-component>
                        </tbody>
                    </table>
                    {{-- Paginación --}}
                    <div class="d-flex justify-content-center py-3">
                        {{ $usuarios->links('pagination::bootstrap-4') }}
                    </div>
                    {{-- Componente vue mensajes --}}
                    @if (session('message'))
                        <message-component :message="'{{ session('message') }}'"
                            lang="{{ LaravelLocalization::getCurrentLocale() }}" />
                    @endif
                </div>
            @endif
        </div>
    @endsection
</body>

</html>
