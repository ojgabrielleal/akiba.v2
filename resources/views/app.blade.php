<!DOCTYPE html>
<html lang="pt-BR">
<head>
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
