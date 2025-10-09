<!DOCTYPE html>
<html lang="pt-BR">
<head>
    @inertiaHead
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @inertia
    <div id="installBanner"
        style="display:none; position:fixed; bottom:0; left:0; right:0;
            background:#0091ff; color:white; padding:1rem;
            justify-content:space-between; align-items:center; z-index:1000;">
        <span>📱 Instale o app da Rede Akiba no seu celular!</span>
        <button id="installApp"
            style="background:white; color:#0091ff; border:none; padding:0.5rem 1rem; border-radius:8px;">
            Instalar
        </button>
    </div>
    <audio id="stream">
        <source src="/api/cast/stream" type="audio/mp3" />
        seu navegador não suporta HTML5
    </audio>
</body>

</html