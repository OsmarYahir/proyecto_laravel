<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conciertos - TIKET MANIA</title>

    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
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
            max-width: 900px;
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
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background: #333;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 20px;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            white-space: pre-line;
        }

        .recaptcha-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .warning {
            background: #fff3cd;
            color: #856404;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ffeaa7;
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
        <a href="/registro">Cuenta</a>
        <a href="/login">Login</a>
    </div>

    <div class="container">
        <h1>Próximos Conciertos</h1>
        <br>

        <!-- Lista de Conciertos -->
        <div class="concierto">
            <h3>Rock Festival 2026</h3>
            <p>15 de Marzo, 2026 - 20:00 hrs</p>
            <p>Foro Sol, Ciudad de México</p>
            <p>Desde $850 MXN</p>
        </div>

        <div class="concierto">
            <h3>Festival Electrónico</h3>
            <p>22 de Abril, 2026 - 18:00 hrs</p>
            <p>Arena Guadalajara, Jalisco</p>
            <p>Desde $650 MXN</p>
        </div>

        <div class="concierto">
            <h3>Concierto Sinfónico</h3>
            <p>5 de Mayo, 2026 - 19:00 hrs</p>
            <p>Auditorio Nacional, CDMX</p>
            <p>Desde $450 MXN</p>
        </div>

        <div class="concierto">
            <h3>Pop Latino Tour</h3>
            <p>18 de Junio, 2026 - 21:00 hrs</p>
            <p>Estadio Monterrey, Nuevo León</p>
            <p>Desde $950 MXN</p>
        </div>

        <!-- Formulario de Reserva -->
        <div class="formulario">
            <h2>Reserva tu boleto</h2>
            
            <div class="warning">
                 <strong></strong> Este formulario NO guarda en base de datos
            </div>

            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ secure_url(route('conciertos.reservar')) }}" method="POST">
                @csrf
                
                <div class="input-group">
                    <label>Nombre completo</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" required minlength="3">
                </div>

                <div class="input-group">
                    <label>Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="input-group">
                    <label>Teléfono</label>
                    <input type="tel" name="telefono" value="{{ old('telefono') }}" required minlength="10" maxlength="15">
                </div>

                <div class="input-group">
                    <label>Selecciona concierto</label>
                    <select name="concierto" required>
                        <option value="">-- Elige un concierto --</option>
                        <option value="Rock Festival 2026">Rock Festival 2026</option>
                        <option value="Festival Electrónico">Festival Electrónico</option>
                        <option value="Concierto Sinfónico">Concierto Sinfónico</option>
                        <option value="Pop Latino Tour">Pop Latino Tour</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>Cantidad de boletos</label>
                    <input type="number" name="cantidad" value="{{ old('cantidad', 1) }}" required min="1" max="10">
                </div>

                <!-- reCAPTCHA centrado -->
                <div class="recaptcha-container">
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                </div>

                <button type="submit" class="btn-submit">🎟️ Reservar Boletos</button>
            </form>
        </div>
    </div>
</body>
</html>