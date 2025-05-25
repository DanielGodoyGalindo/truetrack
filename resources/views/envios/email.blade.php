<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Enviar email')
    @vite(['resources/js/app.js'])
</head>

<body>
    @extends('master')
    @section('content')
        <div id="app">
            <div class="container">
                <h1>{{ __('messages.sendMessage') }}</h1>
                <div class="d-flex flex-row-reverse justify-content-around mt-4">
                    <div>
                        <p><b>{{ __('messages.client') }}:</b> {{ $envio->cliente->name }}</p>
                        <p><b>{{ __('messages.addressee') }}:</b> {{ $envio->destinatario }}</p>
                        <p><b>{{ Str::title(__('messages.packages')) }}:</b> {{ $envio->bultos }}</p>
                        <p><b>{{ Str::title(__('messages.kilograms')) }}:</b> {{ $envio->bultos }}</p>
                        <p><b>{{ __('messages.status') }}:</b> {{ Str::title($envio->estado) }}</p>
                        @if ($envio->informacion)
                            <p><b>Info:</b> {{ Str::title($envio->informacion) }} ➡️
                                {{ $envio->updated_at->format('d/m/Y H:i') }}h</p>
                        @endif
                    </div>
                    {{-- Formulario --}}
                    <form action="{{ route('envios.sendEmail') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email">{{ __('messages.addressesAddress') }}:</label>
                            <input type="email" name="email" class="form-control border border-2" placeholder="Email"
                                value="{{ $envio->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="mensaje">{{ __('messages.message') }}:</label>
                            <textarea name="mensaje" class="form-control border border-2" placeholder="{{ __('messages.typeMessage') }}"
                                rows="10" cols="33" required></textarea>
                        </div>
                        <div class="d-flex gap-3 justify-content-start">
                            <button type="submit" class="btn boton-accion2">{{ __('messages.send') }}</button>
                        </div>
                        <textarea name="cabecera" hidden>{{ $cabecera }}</textarea>
                    </form>
                </div>
                {{-- Componente botón Vue (volver) --}}
                <div class="d-flex justify-content-center mt-4">
                    <button-component button-text="{{ __('messages.back') }}" button-url="{{ route('envios.index') }}"
                        class="btn boton-accion1"></button-component>
                </div>
            </div>
        </div>
    @endsection
</body>
