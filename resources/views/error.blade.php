<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - TIKET MANIA</title>
    @vite(['resources/css/navbar.css'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .error-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .error-card {
            background: white;
            border-radius: 20px;
            padding: 50px 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .error-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }

        .error-card h1 {
            color: #333;
            font-size: 32px;
            margin-bottom: 15px;
        }

        .error-card p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .error-message {
            background: #fee;
            border: 1px solid #fcc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 30px;
            color: #c33;
            font-size: 14px;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #333;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
        }
    </style>
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

    <div class="error-container">
        <div class="error-card">
            <div class="error-icon">⚠️</div>
            <h1>¡Oops! Algo salió mal</h1>
            <p>Lo sentimos, ha ocurrido un error inesperado. Por favor, intenta nuevamente.</p>

            @if (session('error'))
                <div class="error-message">
                    {{ session('error') }}
                </div>
            @endif

            <div class="btn-group">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Volver atrás</a>
                <a href="/" class="btn btn-primary">Ir al inicio</a>
            </div>
        </div>
    </div>
</body>
</html>