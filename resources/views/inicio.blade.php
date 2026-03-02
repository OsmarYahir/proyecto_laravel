<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Mania - Inicio</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .navbar button {
            background: #555;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .navbar button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            text-align: center;
        }

        h1 {
            margin-bottom: 15px;
        }

        p {
            color: #666;
            margin-bottom: 20px;
        }

        .user-info {
            background: #f9f9f9;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #ddd;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #333;
            color: white;
            text-decoration: none;
            margin: 5px;
        }

        .btn-secondary {
            background: #666;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="/">TIKET MANIA</a>
        <a href="/imagenes">Imagenes</a>
        <a href="{{ route('conciertos-crud.index') }}">Conciertos crud</a>

        @auth
            <a href="/registro">Mi Cuenta</a>
            <button id="btnLogout">Cerrar Sesión</button>
        @else
            <a href="/registro">Cuenta</a>
            <a href="/login">Login</a>
        @endauth
    </div>

    <x-breadcrumbs />

    <div class="container">
        @if(session('success'))
            <div class="success-message">
                ✓ {{ session('success') }}
            </div>
        @endif

        <h1>Bienvenido a Tiket Mania</h1>
        <p>Tu entrada a los mejores eventos, conciertos y experiencias inolvidables.</p>

        @auth
            <div class="user-info">
                <p><strong>👤 Bienvenido, {{ Auth::user()->name }}!</strong></p>
                <p>{{ Auth::user()->email }}</p>
            </div>
            <a href="/conciertos" class="btn">🎟️ Ver Conciertos</a>
        @else
            <a href="/conciertos" class="btn">Explorar Eventos</a>
            <a href="/registro" class="btn btn-secondary">Crear Cuenta</a>
        @endauth
    </div>

    @auth
    <script>
        document.getElementById('btnLogout').addEventListener('click', async function () {
            const btn = this;
            btn.disabled = true;
            btn.textContent = 'Cerrando...';

            try {
                const response = await fetch('{{ route("logout") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                });

                // Laravel logout redirige — seguimos la redirección manualmente
                if (response.ok || response.redirected) {
                    window.location.href = response.url || '/';
                } else {
                    throw new Error('Error al cerrar sesión');
                }

            } catch (err) {
                console.error(err);
                btn.disabled = false;
                btn.textContent = 'Cerrar Sesión';
                alert('No se pudo cerrar la sesión. Intenta de nuevo.');
            }
        });
    </script>
    @endauth

</body>
</html>