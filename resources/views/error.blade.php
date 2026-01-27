<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Error - TIKET MANIA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .navbar {
            background: #333;
            padding: 15px;
            color: white;
            margin-bottom: 20px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 40px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .error-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }

        h1 {
            margin-bottom: 15px;
            color: #333;
            font-size: 28px;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            text-align: left;
            line-height: 1.6;
            font-size: 16px;
        }

        .error-description {
            color: #666;
            margin: 20px 0;
            line-height: 1.6;
        }

        .btn-container {
            margin-top: 30px;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #333;
            color: white;
            text-decoration: none;
            margin: 5px;
            border-radius: 4px;
            font-weight: bold;
        }

        .btn-secondary {
            background: #666;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .tips {
            background: #fff3cd;
            color: #856404;
            padding: 15px;
            margin: 20px 0;
            border: 1px solid #ffeaa7;
            border-radius: 4px;
            text-align: left;
        }

        .tips strong {
            display: block;
            margin-bottom: 10px;
        }

        .tips ul {
            margin-left: 20px;
            line-height: 1.8;
        }

        /* Estilos específicos para error 404 */
        .error-404 .error-icon {
            font-size: 100px;
        }

        .error-404 h1 {
            color: #e74c3c;
        }

        /* Animación sutil */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .container {
            animation: fadeIn 0.3s ease-in;
        }
    </style>
</head>
<body>
    <!-- Navbar ultra básica -->
    <div class="navbar">
        <a href="/">TIKET MANIA</a>
        <a href="/conciertos">Conciertos</a>
        <a href="/registro">Cuenta</a>
        <a href="/login">Login</a>
    </div>

    @php
        $errorMessage = session('error') ?? 'Ha ocurrido un error inesperado.';
        $is404 = str_contains($errorMessage, '404');
        $is403 = str_contains($errorMessage, '403');
        $is500 = str_contains($errorMessage, '500');
        $isRecaptcha = str_contains($errorMessage, 'reCAPTCHA') || str_contains($errorMessage, 'seguridad');
    @endphp

    <div class="container {{ $is404 ? 'error-404' : '' }}">
        <!-- Iconos según el tipo de error -->
        @if($is404)
            <div class="error-icon">🔍</div>
            <h1>Página no encontrada</h1>
        @elseif($is403)
            <div class="error-icon">🚫</div>
            <h1>Acceso denegado</h1>
        @elseif($is500)
            <div class="error-icon">💥</div>
            <h1>Error del servidor</h1>
        @elseif($isRecaptcha)
            <div class="error-icon">🤖</div>
            <h1>Verificación de seguridad</h1>
        @else
            <div class="error-icon">⚠️</div>
            <h1>Algo salió mal</h1>
        @endif
        
        @if($is404)
            <p class="error-description">
                La página que intentas acceder no existe o fue movida.
            </p>
        @else
            <p class="error-description">
                Lo sentimos, ha ocurrido un error al procesar tu solicitud.
            </p>
        @endif

        <!-- Mensaje de error -->
        <div class="error-message">
            {{ $errorMessage }}
        </div>

        <!-- Consejos específicos según el tipo de error -->
        @if($is404)
            <div class="tips">
                <strong>💡 Sugerencias:</strong>
                <ul>
                    <li>Verifica que la URL esté escrita correctamente</li>
                    <li>Usa el menú de navegación para encontrar lo que buscas</li>
                    <li>Vuelve a la página de inicio y comienza de nuevo</li>
                </ul>
            </div>
        @elseif($isRecaptcha)
            <div class="tips">
                <strong>💡 Consejos para resolver este problema:</strong>
                <ul>
                    <li>Asegúrate de hacer click en la casilla "No soy un robot"</li>
                    <li>Espera a que aparezca el ✓ verde antes de enviar</li>
                    <li>Si no aparece el reCAPTCHA, recarga la página</li>
                    <li>Verifica que tu navegador tiene JavaScript habilitado</li>
                    <li>Intenta en modo incógnito si el problema persiste</li>
                </ul>
            </div>
        @elseif($is500)
            <div class="tips">
                <strong>💡 Qué hacer:</strong>
                <ul>
                    <li>Espera unos minutos e intenta de nuevo</li>
                    <li>Verifica tu conexión a internet</li>
                    <li>Si el problema persiste, contáctanos</li>
                </ul>
            </div>
        @endif

        <div class="btn-container">
            @if(!$is404)
                <a href="javascript:history.back()" class="btn btn-secondary">⬅️ Volver atrás</a>
            @endif
            <a href="/" class="btn">🏠 Ir al inicio</a>
        </div>
    </div>
</body>
</html>