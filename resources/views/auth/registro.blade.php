<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro - TIKET MANIA</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .navbar {
            background: #333;
            padding: 15px;
            color: white;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
            font-weight: bold;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .breadcrumbs {
            background: white;
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .login-container {
            max-width: 500px;
            margin: 0 auto;
        }

        .login-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .input-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
        }

        .error-text {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            transition: transform 0.2s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .link-text {
            margin-top: 15px;
            text-align: center;
            color: #666;
        }

        .link-text a {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
        }

        .link-text a:hover {
            text-decoration: underline;
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
    <!-- Navbar -->
    <div class="navbar">
        <a href="/">TIKET MANIA</a>
        <a href="/conciertos">Conciertos</a>
        <a href="/registro">Cuenta</a>
        <a href="/login">Login</a>
    </div>

    <x-breadcrumbs />

    <div class="login-container">
        <form action="{{ route('registro.store') }}" method="POST" class="login-card">
            @csrf
            <h2>Crea tu cuenta</h2>

            <!-- Mostrar TODOS los errores juntos -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>⚠️ Por favor corrige los siguientes errores:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="input-group">
                <label>Nombre Completo *</label>
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}" 
                    required 
                    minlength="3"
                    placeholder="Ej: Juan Pérez"
                    class="{{ $errors->has('name') ? 'error' : '' }}"
                >
                @error('name')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <label>Correo Electrónico *</label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required
                    placeholder="tu@email.com"
                    class="{{ $errors->has('email') ? 'error' : '' }}"
                >
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <label>Teléfono (opcional)</label>
                <input 
                    type="tel" 
                    name="telefono" 
                    value="{{ old('telefono') }}"
                    placeholder="5512345678"
                    maxlength="15"
                >
                @error('telefono')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <label>Contraseña *</label>
                <input 
                    type="password" 
                    name="password" 
                    required 
                    minlength="8"
                    placeholder="Mínimo 8 caracteres"
                    class="{{ $errors->has('password') ? 'error' : '' }}"
                >
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <label>Confirmar Contraseña *</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    required 
                    minlength="8"
                    placeholder="Repite tu contraseña"
                    class="{{ $errors->has('password') ? 'error' : '' }}"
                >
            </div>

            <!-- reCAPTCHA -->
            <div class="recaptcha-container">
                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
            </div>
            @error('recaptcha')
                <div style="text-align: center;">
                    <span class="error-text">{{ $message }}</span>
                </div>
            @enderror

            <button type="submit" class="btn-login">Registrarse</button>
            
            <p class="link-text">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a>
            </p>
        </form>
    </div>
</body>
</html>