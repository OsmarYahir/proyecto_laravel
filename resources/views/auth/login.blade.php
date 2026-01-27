<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- FORZAR HTTPS EN TODOS LOS REQUESTS -->
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Login - TIKET MANIA</title>
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

        .login-container {
            max-width: 500px;
            margin: 0 auto;
        }

        .login-card {
            background: white;
            padding: 30px;
            border: 1px solid #ddd;
        }

        h2 {
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: #333;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 20px;
        }

        .link-text {
            margin-top: 15px;
            text-align: center;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #f5c6cb;
        }

        .recaptcha-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
    </style>
    
    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div class="navbar">
        <a href="/">TIKET MANIA</a>
        <a href="/conciertos">Conciertos</a>
        <a href="/registro">Cuenta</a>
        <a href="/login">Login</a>
    </div>

    <div class="login-container">
        <!-- IMPORTANTE: secure_url() fuerza HTTPS en el action -->
        <form action="{{ secure_url(route('login.store')) }}" method="POST" class="login-card">
            @csrf
            <h2>Iniciar Sesión</h2>

            @if (session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <div class="input-group">
                <label>Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="input-group">
                <label>Contraseña</label>
                <input type="password" name="password" required>
            </div>

            <!-- reCAPTCHA centrado -->
            <div class="recaptcha-container">
                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
            </div>

            <button type="submit" class="btn-login">Ingresar</button>

            <p class="link-text">
                ¿No tienes cuenta? <a href="{{ route('registro') }}">Regístrate aquí</a>
            </p>
        </form>
    </div>
</body>
</html>