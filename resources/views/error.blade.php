<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - TIKET MANIA</title>
    @vite(['resources/css/navbar.css', 'resources/css/error.css'])
</head>
<body>
    <nav class="navbar">
        <div class="nav-logo">
            <a href="/"> TIKET <span> MANIA</span></a>
        </div>
        <div class="nav-search">
            <input type="text" placeholder="Busca eventos..." id="search-input">
            <button type="button"> 🔍</button>
        </div>
        <ul class="nav-links">
            <li><a href="/eventos">Conciertos</a></li>
            <li><a href="/registro">Cuenta</a></li>
            <li><a href="/login">Login</a></li>
        </ul>
    </nav>

    <x-breadcrumbs />

    <div class="error-container">
        <div class="error-card">
           
            <h1>Algo salió mal</h1>
            <p>Lo sentimos, ha ocurrido un error inesperado</p>

            @if (session('error'))
                <div class="error-message">
                    {{ session('error') }}
                </div>
            @endif

            <div class="btn-group">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Volver atrás</a>
                <a href="/" class="btn btn-primary">Ir al inicio</a>
            </div>
        </div>
    </div>
</body>
</html>