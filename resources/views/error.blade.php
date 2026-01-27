<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Error - TIKET MANIA</title>
    <style>
        body { font-family: sans-serif; background: #eee; margin: 0; padding: 0; color: #333; }
        .navbar { background: #000; padding: 10px; color: #fff; }
        .navbar a { color: #fff; text-decoration: none; margin-right: 15px; font-size: 14px; }
        .container { max-width: 500px; margin: 50px auto; background: #fff; padding: 20px; border: 1px solid #ccc; }
        .error-message { background: #ffebeb; color: #b71c1c; padding: 15px; border: 1px solid #ffcdd2; margin: 15px 0; }
        .tips { background: #fff9c4; padding: 15px; border: 1px solid #fff59d; font-size: 14px; }
        .btn { display: inline-block; padding: 10px 20px; background: #333; color: #fff; text-decoration: none; margin-top: 10px; }
        ul { padding-left: 20px; }
    </style>
</head>
<body>
    <div class="navbar">
        <strong>TIKET MANIA</strong> |
        <a href="/">Inicio</a>
        <a href="/conciertos">Conciertos</a>
        <a href="/login">Login</a>
    </div>

    @php
        $errorMessage = session('error') ?? 'Error inesperado.';
        $isRecaptcha = str_contains($errorMessage, 'reCAPTCHA') || str_contains($errorMessage, 'seguridad');
        $is404 = str_contains($errorMessage, '404');
    @endphp

    <div class="container">
        <h1>⚠️ {{ $is404 ? 'No encontrado' : 'Hubo un problema' }}</h1>
        
        <p>Lo sentimos, ha ocurrido un error en tu solicitud:</p>

        <div class="error-message">
            <strong>Detalle:</strong> {{ $errorMessage }}
        </div>

        @if($isRecaptcha)
            <div class="tips">
                <strong>Sugerencias:</strong>
                <ul>
                    <li>Marca la casilla "No soy un robot".</li>
                    <li>Si no ves el cuadro, recarga la página.</li>
                    <li>Verifica que el sitio diga "https" en la barra de direcciones.</li>
                </ul>
            </div>
        @endif

        <div style="margin-top: 20px;">
            <a href="javascript:history.back()" class="btn" style="background:#666;">Volver</a>
            <a href="/" class="btn">Ir al Inicio</a>
        </div>
    </div>
</body>
</html>