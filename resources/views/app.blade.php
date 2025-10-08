<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    @inertiaHead
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @inertia
    <audio id="stream">
        <source src="/api/cast/stream" type="audio/mp3" />
        seu navegador não suporta HTML5
    </audio>
</body>
</html>