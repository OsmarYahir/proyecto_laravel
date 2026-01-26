<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro - TIKET MANIA</title>
    @vite(['resources/css/login.css', 'resources/js/login.js'])
    @vite(['resources/css/navbar.css', 'resources/js/navbar.js'])
</head>
<body>
    <nav class="navbar">
        <div class="nav-logo">
            <a href="/"> TIKET <span> MANIA</span></a>
        </div>
        <div class="nav-search">
            <input type="text" placeholder="Busca eventos..." id="search-input">
            <button type="button"> 🔍</button>
        </div>
        <ul class="nav-links">
            <li><a href="/eventos">Conciertos</a></li>
            <li><a href="/registro">Cuenta</a></li>
            <li><a href="/login">Login</a></li>
        </ul>
    </nav>

    <div class="login-container">
        <form action="{{ route('registro.store') }}" method="POST" class="login-card" id="registro-form">
            @csrf
            <h2>Crea tu cuenta</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="input-group">
                <label>Nombre Completo *</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Tu nombre completo" minlength="3">
                @error('name')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <label>Correo Electrónico *</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="correo@ejemplo.com">
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <label>Teléfono</label>
                <input type="tel" name="telefono" value="{{ old('telefono') }}" placeholder="Opcional">
                @error('telefono')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <label>Contraseña *</label>
                <input type="password" name="password" required placeholder="Mínimo 8 caracteres" minlength="8">
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-group">
                <label>Confirmar Contraseña *</label>
                <input type="password" name="password_confirmation" required placeholder="Repite tu contraseña" minlength="8">
            </div>

            <div class="captcha-section">
                <label>Verificación de seguridad *</label>
                <div class="captcha-box">
                    <span id="captcha-question" style="font-weight: bold; font-size: 1.2em;">Cargando...</span>
                    <button type="button" id="refresh-captcha" title="Generar nueva pregunta">🔄</button>
                </div>
                <input type="hidden" name="captcha_token" id="captcha-token">
                <input type="number" name="captcha_answer" id="captcha-answer" placeholder="Escribe el resultado" required>
                @error('captcha_answer')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-login">Registrarse</button>
            
            <p class="link-text">¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a></p>
        </form>
    </div>

    <script>
        function generateCaptcha() {
            fetch('/captcha/generate', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al generar CAPTCHA');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    document.getElementById('captcha-question').textContent = data.question;
                    document.getElementById('captcha-token').value = data.token;
                    document.getElementById('captcha-answer').value = '';
                } else {
                    throw new Error(data.error || 'Error desconocido');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('captcha-question').textContent = 'Error al cargar. Haz clic en 🔄';
            });
        }

        document.getElementById('refresh-captcha').addEventListener('click', generateCaptcha);
        
        // Generar CAPTCHA al cargar la página
        window.addEventListener('DOMContentLoaded', generateCaptcha);
    </script>
</body>
</html>