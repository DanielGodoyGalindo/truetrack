<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @section('title', 'Enviar email')
</head>

<body>
    @include('master')
    <div class="container">
        <h1>Enviar mensaje</h1>
        <div class="d-flex flex-row justify-content-around mt-4">
            <div>
                <p>Cliente: {{ $envio->cliente->name }}</p>
                <p>Destinatario: {{ $envio->destinatario }}</p>
                <p>Bultos: {{ $envio->bultos }}</p>
                <p>Kilos: {{ $envio->kilos }}</p>
                <p>Estado: {{ $envio->estado }}</p>
            </div>
            {{-- Formulario --}}
            <form action="{{ route('envios.sendEmail') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email">Dirección de destinatario:</label>
                    <input type="email" name="email" class="form-control border border-2" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <label for="mensaje">Mensaje:</label>
                    <textarea name="mensaje" class="form-control border border-2" placeholder="Escribe aquí el mensaje.." rows="10" cols="33" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>
</body>
