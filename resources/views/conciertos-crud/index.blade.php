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

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            text-align: center;
        }

        h1 { margin-bottom: 15px; }

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

        .btn-secondary { background: #666; }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }

        /* ══ SECCIÓN CONCIERTOS ══ */
        .conciertos-section {
            max-width: 1200px;
            margin: 20px auto 0;
            background: white;
            padding: 30px;
            border: 1px solid #ddd;
        }

        .conciertos-section h2 {
            margin-bottom: 20px;
        }

        /* Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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

        tr:nth-child(even) { background: #f9f9f9; }

        /* Badges */
        .status-badge {
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-activo    { background: #d4edda; color: #155724; }
        .status-cancelado { background: #f8d7da; color: #721c24; }
        .status-agotado   { background: #fff3cd; color: #856404; }

        /* Skeleton */
        .skeleton-line {
            height: 13px;
            border-radius: 3px;
            background: linear-gradient(90deg, #eee 25%, #f5f5f5 50%, #eee 75%);
            background-size: 200% 100%;
            animation: shimmer 1.2s infinite;
        }

        @keyframes shimmer {
            0%   { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Estado vacío / error */
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        /* ══ PAGINACIÓN — igual que el CRUD ══ */
        .pagination {
            margin-top: 30px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
            flex-wrap: wrap;
        }

        .pagination button {
            padding: 8px 12px;
            background: #333;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
            font-family: Arial, sans-serif;
            transition: background 0.2s;
        }

        .pagination button:hover:not(:disabled) {
            background: #555;
        }

        .pagination button.active {
            background: #007bff;
            font-weight: bold;
            cursor: default;
        }

        .pagination button:disabled {
            background: #ddd;
            color: #999;
            cursor: not-allowed;
        }

        .pagination .dots {
            padding: 8px 6px;
            color: #999;
            font-size: 14px;
        }

        .pagination-info {
            text-align: center;
            margin-top: 15px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <!-- Navbar (sin cambios) -->
    <div class="navbar">
        <a href="/">TIKET MANIA</a>
        <a href="/imagenes">Imagenes</a>
        <a href="{{ route('conciertos-crud.index') }}">Conciertos crud</a>
        @auth
            <a href="/registro">Mi Cuenta</a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit">Cerrar Sesión</button>
            </form>
        @else
            <a href="/registro">Cuenta</a>
            <a href="/login">Login</a>
        @endauth
    </div>

    <x-breadcrumbs />

    <!-- Bienvenida (sin cambios) -->
    <div class="container">
        @if(session('success'))
            <div class="success-message">✓ {{ session('success') }}</div>
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

    <!-- ══ CONCIERTOS CON FETCH ══ -->
    <div class="conciertos-section">
        <h2>🎶 Próximos Conciertos</h2>

        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Artista</th>
                    <th>Ubicación</th>
                    <th>Fecha</th>
                    <th>Precio</th>
                    <th>Boletos</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="conciertosTbody">
                <!-- fetch lo llena -->
            </tbody>
        </table>

        <!-- Paginación igual que el CRUD -->
        <div class="pagination" id="pagination"></div>
        <div class="pagination-info" id="paginacionInfo"></div>
    </div>

    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;

        // ── Skeletons ───────────────────────────────────────────────
        function mostrarSkeletons() {
            document.getElementById('conciertosTbody').innerHTML = Array(5).fill(`
                <tr>
                    <td><div class="skeleton-line" style="width:70%"></div></td>
                    <td><div class="skeleton-line" style="width:60%"></div></td>
                    <td><div class="skeleton-line" style="width:65%"></div></td>
                    <td><div class="skeleton-line" style="width:55%"></div></td>
                    <td><div class="skeleton-line" style="width:40%"></div></td>
                    <td><div class="skeleton-line" style="width:35%"></div></td>
                    <td><div class="skeleton-line" style="width:45%"></div></td>
                </tr>
            `).join('');
            document.getElementById('pagination').innerHTML = '';
            document.getElementById('paginacionInfo').textContent = '';
        }

        // ── Render filas ────────────────────────────────────────────
        function renderFilas(conciertos) {
            const tbody = document.getElementById('conciertosTbody');

            if (!conciertos.length) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7">
                            <div class="no-data">
                                <p>😕 No hay conciertos registrados todavía.</p>
                            </div>
                        </td>
                    </tr>`;
                return;
            }

            tbody.innerHTML = conciertos.map(c => `
                <tr>
                    <td><strong>${c.nombre}</strong></td>
                    <td>${c.artista}</td>
                    <td>${c.ubicacion}</td>
                    <td>${formatFecha(c.fecha_evento)}</td>
                    <td>$${Number(c.precio).toLocaleString('es-MX', {minimumFractionDigits: 2})}</td>
                    <td>${c.boletos_disponibles} / ${c.capacidad_total}</td>
                    <td>
                        <span class="status-badge status-${c.status}">
                            ${c.status.charAt(0).toUpperCase() + c.status.slice(1)}
                        </span>
                    </td>
                </tr>
            `).join('');
        }

        // ── Render paginación (igual al CRUD) ───────────────────────
        function renderPaginacion(actual, ultima, total, desde, hasta) {
            const pag  = document.getElementById('pagination');
            const info = document.getElementById('paginacionInfo');

            // Info debajo
            info.textContent = `Mostrando ${desde} a ${hasta} de ${total} conciertos`;

            if (ultima <= 1) { pag.innerHTML = ''; return; }

            // Rango de páginas a mostrar (±2 de la actual)
            const start = Math.max(actual - 2, 1);
            const end   = Math.min(actual + 2, ultima);

            let html = '';

            // « Primera
            html += `<button ${actual === 1 ? 'disabled' : ''}
                        onclick="cargarConciertos(1)">« Primera</button>`;

            // ‹ Anterior
            html += `<button ${actual === 1 ? 'disabled' : ''}
                        onclick="cargarConciertos(${actual - 1})">‹ Anterior</button>`;

            // Primer número + puntos si hace falta
            if (start > 1) {
                html += `<button onclick="cargarConciertos(1)">1</button>`;
                if (start > 2) html += `<span class="dots">...</span>`;
            }

            // Números del rango
            for (let i = start; i <= end; i++) {
                html += `<button class="${i === actual ? 'active' : ''}"
                            onclick="cargarConciertos(${i})">${i}</button>`;
            }

            // Puntos + último número si hace falta
            if (end < ultima) {
                if (end < ultima - 1) html += `<span class="dots">...</span>`;
                html += `<button onclick="cargarConciertos(${ultima})">${ultima}</button>`;
            }

            // Siguiente ›
            html += `<button ${actual === ultima ? 'disabled' : ''}
                        onclick="cargarConciertos(${actual + 1})">Siguiente ›</button>`;

            // Última »
            html += `<button ${actual === ultima ? 'disabled' : ''}
                        onclick="cargarConciertos(${ultima})">Última »</button>`;

            pag.innerHTML = html;
        }

        // ── FETCH PRINCIPAL ─────────────────────────────────────────
        async function cargarConciertos(pagina = 1) {
            mostrarSkeletons();

            try {
                const res = await fetch(`/api/conciertos?page=${pagina}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                    }
                });

                if (!res.ok) throw new Error(`HTTP ${res.status}`);

                // Laravel paginate() devuelve:
                // { data, current_page, last_page, total, from, to, per_page }
                const json = await res.json();

                renderFilas(json.data);
                renderPaginacion(
                    json.current_page,
                    json.last_page,
                    json.total,
                    json.from,
                    json.to
                );

            } catch (err) {
                console.error(err);
                document.getElementById('conciertosTbody').innerHTML = `
                    <tr>
                        <td colspan="7">
                            <div class="no-data">
                                ⚠️ Error al cargar los datos.
                                <a href="#" onclick="cargarConciertos(${pagina}); return false;"
                                   style="color:#333;">Reintentar</a>
                            </div>
                        </td>
                    </tr>`;
            }
        }

        // ── Helper fecha ────────────────────────────────────────────
        function formatFecha(str) {
            return new Date(str).toLocaleDateString('es-MX', {
                day: '2-digit', month: '2-digit', year: 'numeric',
                hour: '2-digit', minute: '2-digit'
            });
        }

        // ── Arrancar ────────────────────────────────────────────────
        cargarConciertos(1);
    </script>

</body>
</html>