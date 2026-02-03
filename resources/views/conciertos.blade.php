<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Conciertos - TIKET MANIA</title>
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
            max-width: 1000px;
            margin: 0 auto;
        }

        h1 {
            margin-bottom: 20px;
        }

        .concierto {
            background: white;
            padding: 20px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
        }

        .concierto h3 {
            margin-bottom: 10px;
        }

        .concierto p {
            margin: 5px 0;
            color: #666;
        }

        .formulario {
            background: white;
            padding: 30px;
            border: 1px solid #ddd;
            margin-top: 30px;
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

        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input:focus, select:focus {
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

        .btn-submit {
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

        .btn-submit:hover {
            background: #555;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            white-space: pre-line;
            line-height: 1.6;
        }

        .error-summary {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }

        .error-summary strong {
            display: block;
            margin-bottom: 10px;
        }

        .error-summary ul {
            margin-left: 20px;
            margin-top: 5px;
        }

        .warning {
            background: #fff3cd;
            color: #856404;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ffeaa7;
            font-size: 14px;
        }

        .recaptcha-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
    </style>
    
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div class="navbar">
        <a href="/">TIKET MANIA</a>
        <a href="/conciertos">Conciertos</a>
        <a href="/usuarios">Usuarios</a>
        <a href="/registro">Cuenta</a>
        <a href="/login">Login</a>
    </div>

    <x-breadcrumbs />

    <div class="container">
        <h1>Próximos Conciertos</h1>

        <div class="concierto">
            <h3>Rock Festival 2026</h3>
            <p>Fecha: 15 de Marzo, 2026 - 20:00 hrs</p>
            <p>Lugar: Foro Sol, Ciudad de México</p>
            <p>Precio: Desde $850 MXN</p>
        </div>

        <div class="concierto">
            <h3>Festival Electrónico</h3>
            <p>Fecha: 22 de Abril, 2026 - 18:00 hrs</p>
            <p>Lugar: Arena Guadalajara, Jalisco</p>
            <p>Precio: Desde $650 MXN</p>
        </div>

        <div class="concierto">
            <h3>Concierto Sinfónico</h3>
            <p>Fecha: 5 de Mayo, 2026 - 19:00 hrs</p>
            <p>Lugar: Auditorio Nacional, CDMX</p>
            <p>Precio: Desde $450 MXN</p>
        </div>

        <div class="concierto">
            <h3>Pop Latino Tour</h3>
            <p>Fecha: 18 de Junio, 2026 - 21:00 hrs</p>
            <p>Lugar: Estadio Monterrey, Nuevo León</p>
            <p>Precio: Desde $950 MXN</p>
        </div>

        <div class="formulario">
            <h2>Reserva tu boleto</h2>
            
            <div class="warning">
                <strong>Prototipo:</strong> Este formulario NO guarda en base de datos
            </div>

            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-summary">
                    <strong>Por favor corrige los siguientes errores:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ secure_url(route('conciertos.reservar')) }}" method="POST" id="reservaForm">
                @csrf

                <div class="input-group">
                    <label>Nombre completo <span class="required">*</span></label>
                    <input 
                        type="text" 
                        name="nombre" 
                        id="nombre"
                        value="{{ old('nombre') }}" 
                        required 
                        placeholder="Juan Pérez García"
                        class="{{ $errors->has('nombre') ? 'input-error' : (old('nombre') ? 'input-valid' : '') }}"
                    >
                    <span class="error" id="nombre-error"></span>
                    <span class="help-text" id="nombre-help">Solo letras y espacios</span>
                </div>

                <div class="input-group">
                    <label>Correo electrónico <span class="required">*</span></label>
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
                    <span class="help-text" id="email-help">Formato: usuario@dominio.com</span>
                </div>

                <div class="input-group">
                    <label>Teléfono <span class="required">*</span></label>
                    <input 
                        type="tel" 
                        name="telefono" 
                        id="telefono"
                        value="{{ old('telefono') }}" 
                        required 
                        placeholder="5512345678"
                        maxlength="10"
                        class="{{ $errors->has('telefono') ? 'input-error' : (old('telefono') ? 'input-valid' : '') }}"
                    >
                    <span class="error" id="telefono-error"></span>
                    <span class="help-text" id="telefono-help">10 dígitos sin espacios ni guiones</span>
                </div>

                <div class="input-group">
                    <label>Selecciona concierto <span class="required">*</span></label>
                    <select 
                        name="concierto" 
                        id="concierto"
                        required
                        class="{{ $errors->has('concierto') ? 'input-error' : (old('concierto') ? 'input-valid' : '') }}"
                    >
                        <option value="">-- Elige un concierto --</option>
                        <option value="Rock Festival 2026" {{ old('concierto') == 'Rock Festival 2026' ? 'selected' : '' }}>
                            Rock Festival 2026 - $850 MXN
                        </option>
                        <option value="Festival Electrónico" {{ old('concierto') == 'Festival Electrónico' ? 'selected' : '' }}>
                            Festival Electrónico - $650 MXN
                        </option>
                        <option value="Concierto Sinfónico" {{ old('concierto') == 'Concierto Sinfónico' ? 'selected' : '' }}>
                            Concierto Sinfónico - $450 MXN
                        </option>
                        <option value="Pop Latino Tour" {{ old('concierto') == 'Pop Latino Tour' ? 'selected' : '' }}>
                            Pop Latino Tour - $950 MXN
                        </option>
                    </select>
                    <span class="error" id="concierto-error"></span>
                    <span class="help-text" id="concierto-help">Elige el evento al que deseas asistir</span>
                </div>

                <div class="input-group">
                    <label>Cantidad de boletos <span class="required">*</span></label>
                    <input 
                        type="number" 
                        name="cantidad" 
                        id="cantidad"
                        value="{{ old('cantidad', 1) }}" 
                        required 
                        min="1" 
                        max="10"
                        class="{{ $errors->has('cantidad') ? 'input-error' : (old('cantidad') ? 'input-valid' : '') }}"
                    >
                    <span class="error" id="cantidad-error"></span>
                    <span class="help-text" id="cantidad-help">Mínimo 1, máximo 10 boletos</span>
                </div>

                <div class="recaptcha-container">
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                </div>

                <button type="submit" class="btn-submit">Reservar Boletos</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // NOMBRE
            const nombreInput = document.getElementById('nombre');
            const nombreError = document.getElementById('nombre-error');
            const nombreHelp = document.getElementById('nombre-help');
            
            nombreInput.addEventListener('input', function() {
                const value = this.value.trim();
                const regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/;
                
                if (value === '') {
                    nombreInput.classList.remove('input-valid', 'input-error');
                    nombreError.textContent = '';
                    nombreHelp.style.display = 'block';
                } else if (value.length < 3) {
                    nombreInput.classList.add('input-error');
                    nombreInput.classList.remove('input-valid');
                    nombreError.textContent = 'Debe tener al menos 3 caracteres';
                    nombreHelp.style.display = 'none';
                } else if (!regex.test(value)) {
                    nombreInput.classList.add('input-error');
                    nombreInput.classList.remove('input-valid');
                    nombreError.textContent = 'Solo letras y espacios';
                    nombreHelp.style.display = 'none';
                } else {
                    nombreInput.classList.add('input-valid');
                    nombreInput.classList.remove('input-error');
                    nombreError.textContent = '';
                    nombreHelp.style.display = 'block';
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
                    emailError.textContent = 'Formato de correo inválido';
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
                
                this.value = this.value.replace(/[^0-9]/g, '');
                
                if (value === '') {
                    telefonoInput.classList.remove('input-valid', 'input-error');
                    telefonoError.textContent = '';
                    telefonoHelp.style.display = 'block';
                } else if (value.length !== 10) {
                    telefonoInput.classList.add('input-error');
                    telefonoInput.classList.remove('input-valid');
                    telefonoError.textContent = 'Debe tener exactamente 10 dígitos';
                    telefonoHelp.style.display = 'none';
                } else if (!regex.test(value)) {
                    telefonoInput.classList.add('input-error');
                    telefonoInput.classList.remove('input-valid');
                    telefonoError.textContent = 'Solo números';
                    telefonoHelp.style.display = 'none';
                } else {
                    telefonoInput.classList.add('input-valid');
                    telefonoInput.classList.remove('input-error');
                    telefonoError.textContent = '';
                    telefonoHelp.style.display = 'block';
                }
            });

            // CONCIERTO
            const conciertoInput = document.getElementById('concierto');
            const conciertoError = document.getElementById('concierto-error');
            const conciertoHelp = document.getElementById('concierto-help');
            
            conciertoInput.addEventListener('change', function() {
                const value = this.value;
                
                if (value === '') {
                    conciertoInput.classList.remove('input-valid', 'input-error');
                    conciertoError.textContent = '';
                    conciertoHelp.style.display = 'block';
                } else {
                    conciertoInput.classList.add('input-valid');
                    conciertoInput.classList.remove('input-error');
                    conciertoError.textContent = '';
                    conciertoHelp.style.display = 'block';
                }
            });

            // CANTIDAD
            const cantidadInput = document.getElementById('cantidad');
            const cantidadError = document.getElementById('cantidad-error');
            const cantidadHelp = document.getElementById('cantidad-help');
            
            cantidadInput.addEventListener('input', function() {
                const value = parseInt(this.value);
                
                if (isNaN(value) || value === '') {
                    cantidadInput.classList.remove('input-valid', 'input-error');
                    cantidadError.textContent = '';
                    cantidadHelp.style.display = 'block';
                } else if (value < 1) {
                    cantidadInput.classList.add('input-error');
                    cantidadInput.classList.remove('input-valid');
                    cantidadError.textContent = 'Mínimo 1 boleto';
                    cantidadHelp.style.display = 'none';
                } else if (value > 10) {
                    cantidadInput.classList.add('input-error');
                    cantidadInput.classList.remove('input-valid');
                    cantidadError.textContent = 'Máximo 10 boletos';
                    cantidadHelp.style.display = 'none';
                } else {
                    cantidadInput.classList.add('input-valid');
                    cantidadInput.classList.remove('input-error');
                    cantidadError.textContent = '';
                    cantidadHelp.style.display = 'block';
                }
            });

            // VALIDAR ANTES DE ENVIAR
            const form = document.getElementById('reservaForm');
            
            form.addEventListener('submit', function(e) {
                nombreInput.dispatchEvent(new Event('input'));
                emailInput.dispatchEvent(new Event('input'));
                telefonoInput.dispatchEvent(new Event('input'));
                conciertoInput.dispatchEvent(new Event('change'));
                cantidadInput.dispatchEvent(new Event('input'));
                
                const errores = document.querySelectorAll('.input-error');
                
                if (errores.length > 0) {
                    e.preventDefault();
                    alert('Por favor corrige los errores antes de continuar');
                }
                
                if (nombreInput.value.trim() === '' || 
                    emailInput.value.trim() === '' || 
                    telefonoInput.value.trim() === '' ||
                    conciertoInput.value === '' ||
                    cantidadInput.value === '') {
                    e.preventDefault();
                    alert('Por favor completa todos los campos obligatorios');
                }
            });
        });
    </script>
</body>
</html>