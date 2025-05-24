<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Crear envío')
    @vite(['resources/js/app.js'])
</head>

<body>
    @extends('master')
    @section('content')
        <div id="app">
            <div class="container">
                <h1>{{ $envio ? __('messages.editShipment') : __('messages.newShipment') }}</h1>
                {{-- Formulario --}}
                @if ($envio)
                    <form action="{{ route('envios.update', $envio->id) }}" method="POST">
                        @method('PUT')
                    @else
                        <form action="{{ route('envios.store') }}" method="POST">
                @endif
                @csrf
                {{-- Nombre --}}
                <div class="mb-3">
                    <label for="nombre">{{ __('messages.addressee') }}:</label>
                    <input type="text" name="nombre" class="form-control w-25"
                        placeholder="{{ __('messages.nameSurname') }}" value="{{ $envio ? $nombre : '' }}"
                        pattern="[A-Za-z\s]{3,}" title="Introduce un nombre de al menos 3 letras" required>
                </div>
                {{-- Dirección --}}
                <div class="mb-3">
                    <label for="direccion">{{ __('messages.addressesAddress') }}:</label>
                    <input type="text" name="direccion" class="form-control w-50"
                        placeholder="{{ __('messages.completeAddress') }}" value="{{ $envio ? $direccion : '' }}"
                        minlength="8" title="Introduce una dirección de al menos 8 caracteres" required>
                </div>
                {{-- Código postal --}}
                <div class="mb-3">
                    <label for="codigo_postal">{{ __('messages.postalCode') }}:</label>
                    <input type="text" name="codigo_postal" class="form-control w-10" pattern="[0-9]{5}"
                        title="Introduce un código postal de 5 cifras" placeholder="{{ __('messages.fiveDigits') }}"
                        value="{{ $envio ? $codigo_postal : '' }}" required>
                </div>
                {{-- Población --}}
                <div class="mb-3">
                    <label for="poblacion">{{ __('messages.town') }}:</label>
                    <input type="text" name="poblacion" class="form-control w-25"
                        placeholder="{{ __('messages.townName') }}" value="{{ $envio ? $poblacion : '' }}" minlength="3"
                        title="Introduce una población de al menos 3 caracteres" required>
                </div>
                {{-- Bultos --}}
                <div class="mb-3">
                    <label for="bultos">{{ __('messages.numberOfPackages') }}:</label>
                    <input type="number" name="bultos" class="form-control w-10"
                        placeholder="{{ Str::title(__('messages.packages')) }}" min="1" max="100"
                        value="{{ $envio ? $envio->bultos : '' }}" required>
                </div>
                {{-- Kilos --}}
                <div class="mb-3">
                    <label for="kilos">{{ __('messages.numberOfKilos') }}:</label>
                    <input type="number" name="kilos" class="form-control w-10"
                        placeholder="{{ Str::title(__('messages.kilograms')) }}" step="0.01" min="1"
                        max="1000" value="{{ $envio ? $envio->kilos : '' }}" required>
                </div>
                <button type="submit" class="btn boton-accion1">{{ __('messages.save') }}</button>
                </form>
            </div>
            <message-component :message="'{{ session('message') }}'"
                lang="{{ LaravelLocalization::getCurrentLocale() }}" />
        </div>
    @endsection
</body>
