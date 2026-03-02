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
        <div class="success-message">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="error-message">{{ session('error') }}</div>
    @endif

    <a href="{{ secure_url(route('conciertos-crud.create')) }}" class="btn btn-success">+ Crear Nuevo Concierto</a>

    {{-- ✅ Sin @if — el JS decide si hay datos o no --}}
    <div id="tabla-container">
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
            <tbody id="tabla-body">
                <tr><td colspan="8" class="no-data">Cargando...</td></tr>
            </tbody>
        </table>

        <div class="pagination" id="pagination"></div>
        <div style="text-align:center;margin-top:15px;color:#666;font-size:14px;" id="pagination-info"></div>
    </div>  {{-- ✅ Cierra tabla-container --}}

</div>  {{-- ✅ Cierra .container --}}

<script>
     const JSON_URL = "{{ secure_url(route('conciertos-crud.json')) }}";

    async function loadPage(page = 1) {
        try {
            const res  = await fetch(`${JSON_URL}?page=${page}`);
            const data = await res.json();
            renderTable(data);
            renderPagination(data);
        } catch (e) {
            document.getElementById('tabla-body').innerHTML =
                '<tr><td colspan="8" class="no-data">Error al cargar datos.</td></tr>';
        }
    }

    function statusBadge(status) {
        const labels = { activo: 'Activo', cancelado: 'Cancelado', agotado: 'Agotado' };
        return `<span class="status-badge status-${status}">${labels[status] ?? status}</span>`;
    }

    function renderTable({ data, from }) {
        const tbody = document.getElementById('tabla-body');
        if (!data.length) {
            tbody.innerHTML = '<tr><td colspan="8" class="no-data">😕 No hay conciertos registrados.</td></tr>';
            return;
        }
        tbody.innerHTML = data.map(c => {
            const fecha = new Date(c.fecha_evento).toLocaleString('es-MX', {
                day:'2-digit', month:'2-digit', year:'numeric',
                hour:'2-digit', minute:'2-digit'
            });
            const precio = parseFloat(c.precio).toLocaleString('es-MX', {
                minimumFractionDigits: 2
            });
            return `
            <tr>
                <td><strong>${c.nombre}</strong></td>
                <td>${c.artista}</td>
                <td>${c.ubicacion}</td>
                <td>${fecha}</td>
                <td>$${precio}</td>
                <td>${c.boletos_disponibles} / ${c.capacidad_total}</td>
                <td>${statusBadge(c.status)}</td>
                <td class="actions">
                    <a href="/conciertos-crud/${c.id}" class="btn">Ver</a>
                    <a href="/conciertos-crud/${c.id}/edit" class="btn btn-warning">Editar</a>
                    <form action="/conciertos-crud/${c.id}" method="POST" style="display:inline"
                          onsubmit="return confirm('¿Eliminar este concierto?');">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>`;
        }).join('');
    }

    function renderPagination({ current_page, last_page, from, to, total }) {
        document.getElementById('pagination-info').textContent =
            total ? `Mostrando ${from} a ${to} de ${total} conciertos` : '';

        const pg = document.getElementById('pagination');
        let html = '';

        const btn = (page, label, disabled = false) =>
            disabled
                ? `<span class="disabled">${label}</span>`
                : `<a href="#" onclick="loadPage(${page});return false;">${label}</a>`;

        const active = (page, label) =>
            `<span class="active">${label}</span>`;

        html += btn(1,            '« Primera',   current_page === 1);
        html += btn(current_page - 1, '‹ Anterior', current_page === 1);

        const start = Math.max(current_page - 2, 1);
        const end   = Math.min(current_page + 2, last_page);

        if (start > 1) {
            html += btn(1, '1');
            if (start > 2) html += `<span class="disabled">...</span>`;
        }
        for (let p = start; p <= end; p++) {
            html += p === current_page ? active(p, p) : btn(p, p);
        }
        if (end < last_page) {
            if (end < last_page - 1) html += `<span class="disabled">...</span>`;
            html += btn(last_page, last_page);
        }

        html += btn(current_page + 1, 'Siguiente ›', current_page === last_page);
        html += btn(last_page,        'Última »',     current_page === last_page);

        pg.innerHTML = html;
    }

    // Carga inicial
    loadPage(1);
</script>

</body>
</html>