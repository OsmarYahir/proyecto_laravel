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

        /* Paginación mejorada */
        .pagination {
            margin-top: 30px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
            flex-wrap: wrap;
        }

        .pagination a {
            padding: 8px 12px;
            background: #333;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            transition: background 0.3s;
        }

        .pagination a:hover {
            background: #555;
        }

        .pagination .active {
            background: #007bff;
            padding: 8px 12px;
            border-radius: 3px;
            color: white;
            font-weight: bold;
        }

        .pagination .disabled {
            padding: 8px 12px;
            background: #ddd;
            color: #999;
            border-radius: 3px;
            cursor: not-allowed;
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
        <a href="{{ secure_url('/') }}">TIKET MANIA</a>
        <a href="{{ secure_url(route('conciertos-crud.index')) }}">Gestión Conciertos</a>
       
        <a href="{{ secure_url(route('registro')) }}">Cuenta</a>
        <a href="{{ secure_url(route('login')) }}">Login</a>
    </div>

    <x-breadcrumbs />

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

        <a href="{{ secure_url(route('conciertos-crud.create')) }}" class="btn btn-success">+ Crear Nuevo Concierto</a>

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
                              
                                <a href="{{ secure_url(route('conciertos-crud.edit', $concierto->id)) }}" class="btn btn-warning">Editar</a>
                                
                                <form action="{{ secure_url(route('conciertos-crud.destroy', $concierto->id)) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Eliminar este concierto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Paginación Personalizada con Primera y Última -->
            @if ($conciertos->lastPage() > 1)
                <div class="pagination">
                    {{-- Botón Primera Página --}}
                    @if ($conciertos->onFirstPage())
                        <span class="disabled">« Primera</span>
                    @else
                        <a href="{{ secure_url($conciertos->url(1)) }}">« Primera</a>
                    @endif

                    {{-- Botón Anterior --}}
                    @if ($conciertos->onFirstPage())
                        <span class="disabled">‹ Anterior</span>
                    @else
                        <a href="{{ secure_url($conciertos->previousPageUrl()) }}">‹ Anterior</a>
                    @endif

                    {{-- Números de Página --}}
                    @php
                        $start = max($conciertos->currentPage() - 2, 1);
                        $end = min($conciertos->currentPage() + 2, $conciertos->lastPage());
                    @endphp

                    @if ($start > 1)
                        <a href="{{ secure_url($conciertos->url(1)) }}">1</a>
                        @if ($start > 2)
                            <span class="disabled">...</span>
                        @endif
                    @endif

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $conciertos->currentPage())
                            <span class="active">{{ $page }}</span>
                        @else
                            <a href="{{ secure_url($conciertos->url($page)) }}">{{ $page }}</a>
                        @endif
                    @endfor

                    @if ($end < $conciertos->lastPage())
                        @if ($end < $conciertos->lastPage() - 1)
                            <span class="disabled">...</span>
                        @endif
                        <a href="{{ secure_url($conciertos->url($conciertos->lastPage())) }}">{{ $conciertos->lastPage() }}</a>
                    @endif

                    {{-- Botón Siguiente --}}
                    @if ($conciertos->hasMorePages())
                        <a href="{{ secure_url($conciertos->nextPageUrl()) }}">Siguiente ›</a>
                    @else
                        <span class="disabled">Siguiente ›</span>
                    @endif

                    {{-- Botón Última Página --}}
                    @if ($conciertos->hasMorePages())
                        <a href="{{ secure_url($conciertos->url($conciertos->lastPage())) }}">Última »</a>
                    @else
                        <span class="disabled">Última »</span>
                    @endif
                </div>

                {{-- Info de registros --}}
                <div style="text-align: center; margin-top: 15px; color: #666; font-size: 14px;">
                    Mostrando {{ $conciertos->firstItem() ?? 0 }} a {{ $conciertos->lastItem() ?? 0 }} de {{ $conciertos->total() }} conciertos
                </div>
            @endif
        @else
            <div class="no-data">
                <p>😕 No hay conciertos registrados todavía.</p>
                <p>Crea tu primer concierto usando el botón de arriba.</p>
            </div>
        @endif
    </div>
</body>
</html>