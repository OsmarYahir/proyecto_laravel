<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Gestión de Conciertos - TIKET MANIA</title>
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
            background: white;
            padding: 30px;
            border: 1px solid #ddd;
        }

        h1 {
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #333;
            color: white;
            text-decoration: none;
            margin-bottom: 20px;
        }

        .btn:hover {
            background: #555;
        }

        .btn-success {
            background: #28a745;
        }

        .btn-danger {
            background: #dc3545;
        }

        .btn-warning {
            background: #ffc107;
            color: #333;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background: #333;
            color: white;
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-activo {
            background: #d4edda;
            color: #155724;
        }

        .status-cancelado {
            background: #f8d7da;
            color: #721c24;
        }

        .status-agotado {
            background: #fff3cd;
            color: #856404;
        }

        .actions {
            white-space: nowrap;
        }

        .actions a, .actions button {
            padding: 6px 12px;
            margin-right: 5px;
            font-size: 13px;
            border: none;
            cursor: pointer;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            padding: 8px 12px;
            margin: 0 2px;
            background: #333;
            color: white;
            text-decoration: none;
        }

        .pagination .active {
            background: #666;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="/">TIKET MANIA</a>
        <a href="/conciertos">Conciertos Públicos</a>
        <a href="/conciertos-crud">Gestión Conciertos</a>
        <a href="/usuarios">Usuarios</a>
        <a href="/login">Login</a>
    </div>

    <div class="container">
        <h1>📋 Gestión de Conciertos</h1>

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ route('conciertos-crud.create') }}" class="btn btn-success">+ Crear Nuevo Concierto</a>

        @if($conciertos->count() > 0)
            <table>
                <thead>
                    <tr>
                      
                        <th>Nombre</th>
                        <th>Artista</th>
                        <th>Ubicación</th>
                        <th>Fecha</th>
                        <th>Precio</th>
                        <th>Disponibles</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($conciertos as $concierto)
                        <tr>
                            <td>{{ $concierto->id }}</td>
                            <td><strong>{{ $concierto->nombre }}</strong></td>
                            <td>{{ $concierto->artista }}</td>
                            <td>{{ $concierto->ubicacion }}</td>
                            <td>{{ $concierto->fecha_evento->format('d/m/Y H:i') }}</td>
                            <td>${{ number_format($concierto->precio, 2) }}</td>
                            <td>{{ $concierto->boletos_disponibles }} / {{ $concierto->capacidad_total }}</td>
                            <td>
                                <span class="status-badge status-{{ $concierto->status }}">
                                    {{ ucfirst($concierto->status) }}
                                </span>
                            </td>
                            <td class="actions">
                                <a href="{{ route('conciertos-crud.show', $concierto->id) }}" class="btn">Ver</a>
                                <a href="{{ route('conciertos-crud.edit', $concierto->id) }}" class="btn btn-warning">Editar</a>
                                
                                <form action="{{ route('conciertos-crud.destroy', $concierto->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Eliminar este concierto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Paginación -->
            <div class="pagination">
                {{ $conciertos->links() }}
            </div>
        @else
            <div class="no-data">
                <p>😕 No hay conciertos registrados todavía.</p>
                <p>Crea tu primer concierto usando el botón de arriba.</p>
            </div>
        @endif
    </div>
</body>
</html>