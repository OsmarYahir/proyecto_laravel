<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Registro - TIKET MANIA</title>
    
    <!-- CSS con función asset de Laravel -->
    <link rel="stylesheet" href="{{ asset('css/registro.css') }}">
    
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
        <form action="{{ secure_url(route('registro.store')) }}" method="POST" class="login-card" id="registroForm">
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

            <!-- NOMBRE -->
            <div class="input-group">
                <label>Nombre Completo <span class="required">*</span></label>
                <input 
                    type="text" 
                    name="name" 
                    id="name"
                    value="{{ old('name') }}" 
                    required 
                    placeholder="Juan Pérez García"
                    class="{{ $errors->has('name') ? 'input-error' : (old('name') ? 'input-valid' : '') }}"
                >
                <span class="error" id="name-error"></span>
                <span class="help-text" id="name-help">✓ Solo letras y espacios</span>
            </div>

            <!-- EMAIL -->
            <div class="input-group">
                <label>Correo Electrónico <span class="required">*</span></label>
                <input 
                    type="email" 
                    name="email" 
                    id="email"
                    value="{{ old('email') }}" 
                    required
                    placeholder="ejemplo@correo.com"
                    class="{{ $errors->has('email') ? 'input-error' : (old('email') ? 'input-valid' : '') }}"
                >
                <span class="error" id="email-error"></span>
                <span class="help-text" id="email-help">✓ Formato válido: usuario@dominio.com</span>
            </div>

            <!-- TELÉFONO -->
            <div class="input-group">
                <label>Teléfono (opcional)</label>
                <input 
                    type="tel" 
                    name="telefono" 
                    id="telefono"
                    value="{{ old('telefono') }}"
                    placeholder="5512345678"
                    maxlength="10"
                    class="{{ $errors->has('telefono') ? 'input-error' : (old('telefono') ? 'input-valid' : '') }}"
                >
                <span class="error" id="telefono-error"></span>
                <span class="help-text" id="telefono-help">✓ 10 dígitos (opcional)</span>
            </div>

            <!-- CONTRASEÑA -->
            <div class="input-group">
                <label>Contraseña <span class="required">*</span></label>
                <input 
                    type="password" 
                    name="password" 
                    id="password"
                    required
                    placeholder="Mínimo 8 caracteres"
                    class="{{ $errors->has('password') ? 'input-error' : '' }}"
                >
                <span class="error" id="password-error"></span>
                <span class="help-text" id="password-help">✓ Mínimo 8 caracteres: 1 mayúscula, 1 minúscula, 1 número</span>
            </div>

            <!-- CONFIRMAR CONTRASEÑA -->
            <div class="input-group">
                <label>Confirmar Contraseña <span class="required">*</span></label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation"
                    required
                    placeholder="Repite tu contraseña"
                    class="{{ $errors->has('password') ? 'input-error' : '' }}"
                >
                <span class="error" id="password_confirmation-error"></span>
                <span class="help-text" id="password_confirmation-help">✓ Debe coincidir con la contraseña</span>
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

    <!-- JavaScript con función asset de Laravel -->
    <script src="{{ asset('js/validaciones.js') }}"></script>
</body>
</html>