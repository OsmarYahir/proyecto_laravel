<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Registro - TIKET MANIA</title>
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
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            font-size: 14px;
        }

        label .required {
            color: #dc3545;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #333;
        }

        .help-text {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
            display: block;
        }

        .error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
            display: block;
            font-weight: 500;
        }

        .input-error {
            border-color: #dc3545 !important;
            background-color: #fff5f5;
        }

        .input-valid {
            border-color: #28a745;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: #333;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
        }

        .btn-login:hover {
            background: #555;
        }

        .link-text {
            margin-top: 15px;
            text-align: center;
        }

        .error-summary {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
        }

        .error-summary strong {
            display: block;
            margin-bottom: 10px;
        }

        .error-summary ul {
            margin-left: 20px;
            margin-top: 5px;
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

     <x-breadcrumbs />


    <div class="login-container">
        <form action="{{ secure_url(route('registro.store')) }}" method="POST" class="login-card">
            @csrf
            <h2>Crea tu cuenta</h2>

            @if ($errors->any())
                <div class="error-summary">
                    <strong>⚠️ Corrige los siguientes errores:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="input-group">
                <label>Nombre Completo <span class="required">*</span></label>
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}" 
                    required 
                    placeholder="Juan Pérez García"
                    class="{{ $errors->has('name') ? 'input-error' : (old('name') ? 'input-valid' : '') }}"
                >
                @error('name')
                    <span class="error">❌ {{ $message }}</span>
                @else
                    <span class="help-text">✓ Solo letras y espacios</span>
                @enderror
            </div>

            <div class="input-group">
                <label>Correo Electrónico <span class="required">*</span></label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required
                    placeholder="ejemplo@correo.com"
                    class="{{ $errors->has('email') ? 'input-error' : (old('email') ? 'input-valid' : '') }}"
                >
                @error('email')
                    <span class="error">❌ {{ $message }}</span>
                @else
                    <span class="help-text">✓ Formato válido: usuario@dominio.com</span>
                @enderror
            </div>

            <div class="input-group">
                <label>Teléfono (opcional)</label>
                <input 
                    type="tel" 
                    name="telefono" 
                    value="{{ old('telefono') }}"
                    placeholder="5512345678"
                    maxlength="10"
                    class="{{ $errors->has('telefono') ? 'input-error' : (old('telefono') ? 'input-valid' : '') }}"
                >
                @error('telefono')
                    <span class="error">❌ {{ $message }}</span>
                @else
                    <span class="help-text">✓ 10 dígitos (opcional)</span>
                @enderror
            </div>

            <div class="input-group">
                <label>Contraseña <span class="required">*</span></label>
                <input 
                    type="password" 
                    name="password" 
                    required
                    placeholder="Mínimo 8 caracteres"
                    class="{{ $errors->has('password') ? 'input-error' : '' }}"
                >
                @error('password')
                    <span class="error">❌ {{ $message }}</span>
                @else
                    <span class="help-text">✓ Mínimo 8 caracteres: 1 mayúscula, 1 minúscula, 1 número</span>
                @enderror
            </div>

            <div class="input-group">
                <label>Confirmar Contraseña <span class="required">*</span></label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    required
                    placeholder="Repite tu contraseña"
                    class="{{ $errors->has('password') ? 'input-error' : '' }}"
                >
                @if(!$errors->has('password'))
                    <span class="help-text">✓ Debe coincidir con la contraseña</span>
                @endif
            </div>

            <!-- reCAPTCHA -->
            <div class="recaptcha-container">
                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
            </div>

            <button type="submit" class="btn-login">Registrarse</button>
            
            <p class="link-text">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a>
            </p>
        </form>
    </div>
</body>
</html>