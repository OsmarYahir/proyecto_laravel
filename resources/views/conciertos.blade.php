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
            max-width: 1200px;
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
        }

        label .required {
            color: #dc3545;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #333;
        }

        .help-text {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .input-error {
            border-color: #dc3545;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
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
            white-space: pre-line;
            line-height: 1.6;
        }

        .error-summary {
            background: #f8d7da;
            color: #721c24;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }

        .error-summary ul {
            margin-left: 20px;
            margin-top: 10px;
        }

        .recaptcha-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .warning {
            background: #fff3cd;
            color: #856404;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ffeaa7;
        }

        .two-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .two-columns {
                grid-template-columns: 1fr;
            }
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

        <!-- Formulario de Reserva EXTENSO -->
        <div class="formulario">
            <h2>Reserva tu boleto</h2>
            
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
                
                <h3 style="margin-bottom: 20px; color: #333;">Información Personal</h3>

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
                        minlength="3"
                        maxlength="100"
                        placeholder="Ejemplo: Juan Pérez García"
                        class="{{ $errors->has('nombre') ? 'input-error' : '' }}"
                    >
                    @error('nombre')
                        <span class="error">{{ $message }}</span>
                    @enderror
                    <span class="help-text">Mínimo 3 caracteres, máximo 100</span>
                </div>

                <!-- Email y Teléfono en dos columnas -->
                <div class="two-columns">
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
                            class="{{ $errors->has('email') ? 'input-error' : '' }}"
                        >
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <span class="help-text">Recibirás tu confirmación aquí</span>
                    </div>

                    <div class="input-group">
                        <label>
                            Teléfono <span class="required">*</span>
                        </label>
                        <input 
                            type="tel" 
                            name="telefono" 
                            value="{{ old('telefono') }}" 
                            required 
                            minlength="10" 
                            maxlength="15"
                            placeholder="5512345678"
                            pattern="[0-9]+"
                            class="{{ $errors->has('telefono') ? 'input-error' : '' }}"
                        >
                        @error('telefono')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <span class="help-text">Solo números, 10-15 dígitos</span>
                    </div>
                </div>

                <!-- Edad y Documento -->
                <div class="two-columns">
                    <div class="input-group">
                        <label>
                            Edad <span class="required">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="edad" 
                            value="{{ old('edad') }}" 
                            required 
                            min="18" 
                            max="100"
                            placeholder="18"
                            class="{{ $errors->has('edad') ? 'input-error' : '' }}"
                        >
                        @error('edad')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <span class="help-text">Debes ser mayor de 18 años</span>
                    </div>

                    <div class="input-group">
                        <label>
                            Documento de identidad <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="documento" 
                            value="{{ old('documento') }}" 
                            required
                            minlength="5"
                            maxlength="20"
                            placeholder="INE, Pasaporte, etc."
                            class="{{ $errors->has('documento') ? 'input-error' : '' }}"
                        >
                        @error('documento')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <span class="help-text">Para identificación en el evento</span>
                    </div>
                </div>

                <h3 style="margin: 30px 0 20px 0; color: #333;">Detalles de la Reserva</h3>

                <!-- Concierto -->
                <div class="input-group">
                    <label>
                        Selecciona concierto <span class="required">*</span>
                    </label>
                    <select 
                        name="concierto" 
                        required
                        class="{{ $errors->has('concierto') ? 'input-error' : '' }}"
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
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Cantidad y Tipo de boleto -->
                <div class="two-columns">
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
                            placeholder="1"
                            class="{{ $errors->has('cantidad') ? 'input-error' : '' }}"
                        >
                        @error('cantidad')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <span class="help-text">Máximo 10 boletos por reserva</span>
                    </div>

                    <div class="input-group">
                        <label>
                            Tipo de boleto <span class="required">*</span>
                        </label>
                        <select 
                            name="tipo_boleto" 
                            required
                            class="{{ $errors->has('tipo_boleto') ? 'input-error' : '' }}"
                        >
                            <option value="">-- Selecciona tipo --</option>
                            <option value="VIP" {{ old('tipo_boleto') == 'VIP' ? 'selected' : '' }}>VIP (+50%)</option>
                            <option value="Preferente" {{ old('tipo_boleto') == 'Preferente' ? 'selected' : '' }}>Preferente (+20%)</option>
                            <option value="General" {{ old('tipo_boleto') == 'General' ? 'selected' : '' }}>General (precio base)</option>
                        </select>
                        @error('tipo_boleto')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Método de pago -->
                <div class="input-group">
                    <label>
                        Método de pago <span class="required">*</span>
                    </label>
                    <select 
                        name="metodo_pago" 
                        required
                        class="{{ $errors->has('metodo_pago') ? 'input-error' : '' }}"
                    >
                        <option value="">-- Selecciona método --</option>
                        <option value="Tarjeta de crédito" {{ old('metodo_pago') == 'Tarjeta de crédito' ? 'selected' : '' }}>
                            💳 Tarjeta de crédito
                        </option>
                        <option value="Tarjeta de débito" {{ old('metodo_pago') == 'Tarjeta de débito' ? 'selected' : '' }}>
                            💳 Tarjeta de débito
                        </option>
                        <option value="Transferencia" {{ old('metodo_pago') == 'Transferencia' ? 'selected' : '' }}>
                            🏦 Transferencia bancaria
                        </option>
                        <option value="Efectivo" {{ old('metodo_pago') == 'Efectivo' ? 'selected' : '' }}>
                            💵 Efectivo
                        </option>
                    </select>
                    @error('metodo_pago')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Dirección -->
                <div class="input-group">
                    <label>
                        Dirección completa <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="direccion" 
                        value="{{ old('direccion') }}" 
                        required
                        minlength="10"
                        maxlength="200"
                        placeholder="Calle, número, colonia, ciudad"
                        class="{{ $errors->has('direccion') ? 'input-error' : '' }}"
                    >
                    @error('direccion')
                        <span class="error">{{ $message }}</span>
                    @enderror
                    <span class="help-text">Para envío de boletos físicos (opcional)</span>
                </div>

                <!-- Comentarios adicionales -->
                <div class="input-group">
                    <label>
                        Comentarios adicionales (opcional)
                    </label>
                    <textarea 
                        name="comentarios" 
                        rows="4"
                        maxlength="500"
                        placeholder="Algún requerimiento especial, alergias, necesidades de accesibilidad, etc."
                        class="{{ $errors->has('comentarios') ? 'input-error' : '' }}"
                    >{{ old('comentarios') }}</textarea>
                    @error('comentarios')
                        <span class="error">{{ $message }}</span>
                    @enderror
                    <span class="help-text">Máximo 500 caracteres</span>
                </div>

                <!-- Aceptar términos -->
                <div class="input-group">
                    <label style="display: flex; align-items: center; cursor: pointer;">
                        <input 
                            type="checkbox" 
                            name="acepta_terminos" 
                            value="1"
                            required
                            style="width: auto; margin-right: 10px;"
                            {{ old('acepta_terminos') ? 'checked' : '' }}
                        >
                        <span>
                            Acepto los términos y condiciones <span class="required">*</span>
                        </span>
                    </label>
                    @error('acepta_terminos')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- reCAPTCHA centrado -->
                <div class="recaptcha-container">
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                </div>
                @error('recaptcha')
                    <div style="text-align: center;">
                        <span class="error">{{ $message }}</span>
                    </div>
                @enderror

                <button type="submit" class="btn-submit">🎟️ Reservar Boletos</button>
            </form>
        </div>
    </div>
</body>
</html>