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
            transition: border-color 0.3s;
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
            border-color: #28a745 !important;
            background-color: #f0fff4;
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

    <script>
        // Validaciones en tiempo real
        document.addEventListener('DOMContentLoaded', function() {
            
            // NOMBRE
            const nameInput = document.getElementById('name');
            const nameError = document.getElementById('name-error');
            const nameHelp = document.getElementById('name-help');
            
            nameInput.addEventListener('input', function() {
                const value = this.value.trim();
                const regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/;
                
                if (value === '') {
                    nameInput.classList.remove('input-valid', 'input-error');
                    nameError.textContent = '';
                    nameHelp.style.display = 'block';
                } else if (value.length < 3) {
                    nameInput.classList.add('input-error');
                    nameInput.classList.remove('input-valid');
                    nameError.textContent = '❌ Debe tener al menos 3 caracteres';
                    nameHelp.style.display = 'none';
                } else if (!regex.test(value)) {
                    nameInput.classList.add('input-error');
                    nameInput.classList.remove('input-valid');
                    nameError.textContent = '❌ Solo letras y espacios';
                    nameHelp.style.display = 'none';
                } else {
                    nameInput.classList.add('input-valid');
                    nameInput.classList.remove('input-error');
                    nameError.textContent = '';
                    nameHelp.style.display = 'block';
                }
            });

            // EMAIL
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('email-error');
            const emailHelp = document.getElementById('email-help');
            
            emailInput.addEventListener('input', function() {
                const value = this.value.trim();
                const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                
                if (value === '') {
                    emailInput.classList.remove('input-valid', 'input-error');
                    emailError.textContent = '';
                    emailHelp.style.display = 'block';
                } else if (!regex.test(value)) {
                    emailInput.classList.add('input-error');
                    emailInput.classList.remove('input-valid');
                    emailError.textContent = '❌ Formato de correo inválido';
                    emailHelp.style.display = 'none';
                } else {
                    emailInput.classList.add('input-valid');
                    emailInput.classList.remove('input-error');
                    emailError.textContent = '';
                    emailHelp.style.display = 'block';
                }
            });

            // TELÉFONO
            const telefonoInput = document.getElementById('telefono');
            const telefonoError = document.getElementById('telefono-error');
            const telefonoHelp = document.getElementById('telefono-help');
            
            telefonoInput.addEventListener('input', function() {
                const value = this.value.trim();
                const regex = /^[0-9]{10}$/;
                
                // Solo números
                this.value = this.value.replace(/[^0-9]/g, '');
                
                if (value === '') {
                    telefonoInput.classList.remove('input-valid', 'input-error');
                    telefonoError.textContent = '';
                    telefonoHelp.style.display = 'block';
                } else if (value.length !== 10) {
                    telefonoInput.classList.add('input-error');
                    telefonoInput.classList.remove('input-valid');
                    telefonoError.textContent = '❌ Debe tener exactamente 10 dígitos';
                    telefonoHelp.style.display = 'none';
                } else if (!regex.test(value)) {
                    telefonoInput.classList.add('input-error');
                    telefonoInput.classList.remove('input-valid');
                    telefonoError.textContent = '❌ Solo números';
                    telefonoHelp.style.display = 'none';
                } else {
                    telefonoInput.classList.add('input-valid');
                    telefonoInput.classList.remove('input-error');
                    telefonoError.textContent = '';
                    telefonoHelp.style.display = 'block';
                }
            });

            // CONTRASEÑA
            const passwordInput = document.getElementById('password');
            const passwordError = document.getElementById('password-error');
            const passwordHelp = document.getElementById('password-help');
            
            passwordInput.addEventListener('input', function() {
                const value = this.value;
                const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/;
                
                if (value === '') {
                    passwordInput.classList.remove('input-valid', 'input-error');
                    passwordError.textContent = '';
                    passwordHelp.style.display = 'block';
                } else if (value.length < 8) {
                    passwordInput.classList.add('input-error');
                    passwordInput.classList.remove('input-valid');
                    passwordError.textContent = '❌ Mínimo 8 caracteres';
                    passwordHelp.style.display = 'none';
                } else if (!regex.test(value)) {
                    passwordInput.classList.add('input-error');
                    passwordInput.classList.remove('input-valid');
                    passwordError.textContent = '❌ Falta: mayúscula, minúscula o número';
                    passwordHelp.style.display = 'none';
                } else {
                    passwordInput.classList.add('input-valid');
                    passwordInput.classList.remove('input-error');
                    passwordError.textContent = '';
                    passwordHelp.style.display = 'block';
                }
                
                // Validar confirmación si ya tiene valor
                if (passwordConfirmationInput.value !== '') {
                    passwordConfirmationInput.dispatchEvent(new Event('input'));
                }
            });

            // CONFIRMAR CONTRASEÑA
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const passwordConfirmationError = document.getElementById('password_confirmation-error');
            const passwordConfirmationHelp = document.getElementById('password_confirmation-help');
            
            passwordConfirmationInput.addEventListener('input', function() {
                const value = this.value;
                const passwordValue = passwordInput.value;
                
                if (value === '') {
                    passwordConfirmationInput.classList.remove('input-valid', 'input-error');
                    passwordConfirmationError.textContent = '';
                    passwordConfirmationHelp.style.display = 'block';
                } else if (value !== passwordValue) {
                    passwordConfirmationInput.classList.add('input-error');
                    passwordConfirmationInput.classList.remove('input-valid');
                    passwordConfirmationError.textContent = '❌ Las contraseñas no coinciden';
                    passwordConfirmationHelp.style.display = 'none';
                } else {
                    passwordConfirmationInput.classList.add('input-valid');
                    passwordConfirmationInput.classList.remove('input-error');
                    passwordConfirmationError.textContent = '';
                    passwordConfirmationHelp.style.display = 'block';
                }
            });

            // VALIDAR ANTES DE ENVIAR
            const form = document.getElementById('registroForm');
            
            form.addEventListener('submit', function(e) {
                let hayErrores = false;
                
                // Disparar validaciones
                nameInput.dispatchEvent(new Event('input'));
                emailInput.dispatchEvent(new Event('input'));
                if (telefonoInput.value !== '') {
                    telefonoInput.dispatchEvent(new Event('input'));
                }
                passwordInput.dispatchEvent(new Event('input'));
                passwordConfirmationInput.dispatchEvent(new Event('input'));
                
                // Verificar errores
                const errores = document.querySelectorAll('.input-error');
                
                if (errores.length > 0) {
                    e.preventDefault();
                    alert('Por favor corrige los errores antes de continuar');
                    hayErrores = true;
                }
                
                // Verificar campos requeridos vacíos
                if (nameInput.value.trim() === '' || 
                    emailInput.value.trim() === '' || 
                    passwordInput.value === '' || 
                    passwordConfirmationInput.value === '') {
                    e.preventDefault();
                    alert('Por favor completa todos los campos obligatorios');
                    hayErrores = true;
                }
            });
        });
    </script>
</body>
</html>