<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Repartos')
</head>

<body>
    @include('master')
    {{-- Header e info del reparto --}}
    <div class="container d-flex flex-row justify-content-around">
        <h1>Reparto {{ $reparto->id }}</h1>
        <div>
            <p>Gestor de tráfico: {{ $reparto->gestor->name }}</p>
            <p>Transportista: {{ $reparto->transportista->name }}</p>
            <p>Vehículo: {{ $reparto->vehiculo->matricula }}</p>
            <p>Carga máxima: {{ $reparto->vehiculo->carga_max }} kg</p>
        </div>
    </div>
    {{-- Tablas para asignar envios a reparto --}}
    <div class="container">
        {{-- Tabla con envios pendientes de reparto --}}

        {{-- Botón para asignar envios --}}

        {{-- Tabla con los envios del reparto actual --}}

    </div>
