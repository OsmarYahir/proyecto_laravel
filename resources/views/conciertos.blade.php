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

        .input-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
            font-size: 14px;
        }

        label .required {
            color: #dc3545;
        }

        input, select {
            width: 100%;
            padding: 12px;
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

        /* Estilos para errores */
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

        /* Estilos para inputs válidos (cuando tienen valor y no hay error) */
        .input-valid {
            border-color: #28a745;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
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
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            white-space: pre-line;
            line-height: 1.6;
        }

        .error-summary {
            background: #f8d7da;
            color: #721c24;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
        }

        .error-summary strong {
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .error-summary ul {
            margin-left: 20px;
            margin-top: 10px;
        }

        .error-summary li {
            margin-bottom: 5px;
        }

        .recaptcha-container {
            display: flex;
            justify-content: center;
            margin: 25px 0;
        }

        .warning {
            background: #fff3cd;
            color: #856404;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ffeaa7;
            border-radius: 4px;
            font-size: 14px;
        }

        /* Indicador visual de campo obligatorio */
        .field-icon {
            display: inline-block;
            margin-left: 5px;
            font-size: 12px;
        }
    </style>
    
    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <!-- Navbar ultra básica -->
    <div class="navbar">
        <a href="/">TIKET MANIA</a>
        <a href="/conciertos">Conciertos</a>
        <a href="/usuarios">Usuarios</a>
        <a href="/registro">Cuenta</a>
        <a href="/login">Login</a>
    </div>

    <!-- Breadcrumbs -->
    <x-breadcrumbs />

    <div class="container">
        <h1>Próximos Conciertos</h1>
        <br>

        <!-- Lista de Conciertos -->
        <div class="concierto">
            <h3>🎸 Rock Festival 2026</h3>
            <p>📅 15 de Marzo, 2026 - 20:00 hrs</p>
            <p>📍 Foro Sol, Ciudad de México</p>
            <p>💰 Desde $850 MXN</p>
        </div>

        <div class="concierto">
            <h3>🎧 Festival Electrónico</h3>
            <p>📅 22 de Abril, 2026 - 18:00 hrs</p>
            <p>📍 Arena Guadalajara, Jalisco</p>
            <p>💰 Desde $650 MXN</p>
        </div>

        <div class="concierto">
            <h3>🎼 Concierto Sinfónico</h3>
            <p>📅 5 de Mayo, 2026 - 19:00 hrs</p>
            <p>📍 Auditorio Nacional, CDMX</p>
            <p>💰 Desde $450 MXN</p>
        </div>

        <div class="concierto">
            <h3>🎤 Pop Latino Tour</h3>
            <p>📅 18 de Junio, 2026 - 21:00 hrs</p>
            <p>📍 Estadio Monterrey, Nuevo León</p>
            <p>💰 Desde $950 MXN</p>
        </div>

        <!-- Formulario de Reserva -->
        <div class="formulario">
            <h2>📝 Reserva tu boleto</h2>
            
            <div class="warning">
                ⚠️ <strong>Prototipo:</strong> Este formulario NO guarda en base de datos
            </div>

            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-summary">
                    <strong>⚠️ Por favor corrige los siguientes errores:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ secure_url(route('conciertos.reservar')) }}" method="POST">
                @csrf

                <!-- Nombre completo -->
                <div class="input-group">
                    <label>
                        Nombre completo <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="nombre" 
                        value="{{ old('nombre') }}" 
                        required 
                        placeholder="Juan Pérez García"
                        class="{{ $errors->has('nombre') ? 'input-error' : (old('nombre') ? 'input-valid' : '') }}"
                    >
                    @error('nombre')
                        <span class="error">❌ {{ $message }}</span>
                    @else
                        <span class="help-text">✓ Solo letras y espacios (sin números ni símbolos)</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="input-group">
                    <label>
                        Correo electrónico <span class="required">*</span>
                    </label>
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
                        <span class="help-text">✓ Formato: usuario@dominio.com</span>
                    @enderror
                </div>

                <!-- Teléfono -->
                <div class="input-group">
                    <label>
                        Teléfono <span class="required">*</span>
                    </label>
                    <input 
                        type="tel" 
                        name="telefono" 
                        value="{{ old('telefono') }}" 
                        required 
                        placeholder="5512345678"
                        maxlength="10"
                        class="{{ $errors->has('telefono') ? 'input-error' : (old('telefono') ? 'input-valid' : '') }}"
                    >
                    @error('telefono')
                        <span class="error">❌ {{ $message }}</span>
                    @else
                        <span class="help-text">✓ Exactamente 10 dígitos (solo números, sin guiones ni espacios)</span>
                    @enderror
                </div>

                <!-- Concierto -->
                <div class="input-group">
                    <label>
                        Selecciona concierto <span class="required">*</span>
                    </label>
                    <select 
                        name="concierto" 
                        required
                        class="{{ $errors->has('concierto') ? 'input-error' : (old('concierto') ? 'input-valid' : '') }}"
                    >
                        <option value="">-- Elige un concierto --</option>
                        <option value="Rock Festival 2026" {{ old('concierto') == 'Rock Festival 2026' ? 'selected' : '' }}>
                            🎸 Rock Festival 2026 - $850 MXN
                        </option>
                        <option value="Festival Electrónico" {{ old('concierto') == 'Festival Electrónico' ? 'selected' : '' }}>
                            🎧 Festival Electrónico - $650 MXN
                        </option>
                        <option value="Concierto Sinfónico" {{ old('concierto') == 'Concierto Sinfónico' ? 'selected' : '' }}>
                            🎼 Concierto Sinfónico - $450 MXN
                        </option>
                        <option value="Pop Latino Tour" {{ old('concierto') == 'Pop Latino Tour' ? 'selected' : '' }}>
                            🎤 Pop Latino Tour - $950 MXN
                        </option>
                    </select>
                    @error('concierto')
                        <span class="error">❌ {{ $message }}</span>
                    @else
                        <span class="help-text">✓ Elige el evento al que deseas asistir</span>
                    @enderror
                </div>

                <!-- Cantidad -->
                <div class="input-group">
                    <label>
                        Cantidad de boletos <span class="required">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="cantidad" 
                        value="{{ old('cantidad', 1) }}" 
                        required 
                        min="1" 
                        max="10"
                        class="{{ $errors->has('cantidad') ? 'input-error' : (old('cantidad') ? 'input-valid' : '') }}"
                    >
                    @error('cantidad')
                        <span class="error">❌ {{ $message }}</span>
                    @else
                        <span class="help-text">✓ Mínimo 1, máximo 10 boletos por reserva</span>
                    @enderror
                </div>

                <!-- reCAPTCHA -->
                <div class="recaptcha-container">
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                </div>

                <button type="submit" class="btn-submit">🎟️ Reservar Boletos</button>
            </form>
        </div>
    </div>
</body>
</html>