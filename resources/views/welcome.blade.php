<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi App con Vue</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    {{-- Cargar componente --}}
    <div id="app">
        <example-component></example-component>
    </div>     
</body>
</html>
