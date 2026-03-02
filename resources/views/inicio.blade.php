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
            max-width: 900px;
            margin: 20px auto 0;
            background: white;
            padding: 30px 40px;
        }

        .conciertos-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #333;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .conciertos-header h2 { font-size: 18px; color: #333; }

        #totalInfo { font-size: 13px; color: #888; }

        /* Tabla */
        .tabla-conciertos {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .tabla-conciertos th {
            background: #333;
            color: white;
            padding: 10px 14px;
            text-align: left;
        }

        .tabla-conciertos td {
            padding: 10px 14px;
            border-bottom: 1px solid #eee;
            color: #444;
        }

        .tabla-conciertos tr:hover td { background: #f9f9f9; }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-activo    { background: #d4edda; color: #155724; }
        .badge-cancelado { background: #f8d7da; color: #721c24; }
        .badge-agotado   { background: #fff3cd; color: #856404; }

        /* Skeleton */
        .skeleton-line {
            height: 13px;
            border-radius: 4px;
            background: linear-gradient(90deg, #eee 25%, #f5f5f5 50%, #eee 75%);
            background-size: 200% 100%;
            animation: shimmer 1.2s infinite;
        }
        @keyframes shimmer {
            0%   { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Estado vacío */
        .estado-msg {
            text-align: center;
            padding: 32px;
            color: #888;
            font-size: 14px;
        }

        /* Paginación */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            flex-wrap: wrap;
        }

        .page-btn {
            min-width: 36px;
            height: 34px;
            padding: 0 10px;
            border: 1px solid #ddd;
            background: white;
            color: #333;
            font-size: 13px;
            font-family: Arial, sans-serif;
            cursor: pointer;
            border-radius: 3px;
            transition: background .15s, color .15s;
        }

        .page-btn:hover:not(:disabled) {
            background: #333;
            color: white;
            border-color: #333;
        }

        .page-btn.active {
            background: #333;
            color: white;
            border-color: #333;
            font-weight: 700;
            cursor: default;
        }

        .page-btn:disabled { opacity: 0.4; cursor: not-allowed; }

        .page-info { font-size: 13px; color: #888; padding: 0 6px; }
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

    <!-- ══ CONCIERTOS CARGADOS CON FETCH ══ -->
    <div class="conciertos-section">
        <div class="conciertos-header">
            <h2>🎶 Próximos Conciertos</h2>
            <span id="totalInfo"></span>
        </div>

        <table class="tabla-conciertos">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Artista</th>
                    <th>Fecha</th>
                    <th>Ubicación</th>
                    <th>Precio</th>
                    <th>Boletos</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody id="conciertosTbody"></tbody>
        </table>

        <div class="pagination" id="pagination"></div>
    </div>

    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;

        // ── Skeletons ──────────────────────────────────────────────
        function mostrarSkeletons() {
            document.getElementById('conciertosTbody').innerHTML = Array(5).fill(`
                <tr>
                    <td><div class="skeleton-line" style="width:70%"></div></td>
                    <td><div class="skeleton-line" style="width:60%"></div></td>
                    <td><div class="skeleton-line" style="width:75%"></div></td>
                    <td><div class="skeleton-line" style="width:65%"></div></td>
                    <td><div class="skeleton-line" style="width:40%"></div></td>
                    <td><div class="skeleton-line" style="width:35%"></div></td>
                    <td><div class="skeleton-line" style="width:50%"></div></td>
                </tr>
            `).join('');
            document.getElementById('pagination').innerHTML = '';
            document.getElementById('totalInfo').textContent = '';
        }

        // ── Render filas ──────────────────────────────────────────
        function renderFilas(conciertos) {
            const tbody = document.getElementById('conciertosTbody');

            if (!conciertos.length) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7">
                            <div class="estado-msg">🎭 No hay conciertos disponibles.</div>
                        </td>
                    </tr>`;
                return;
            }

            tbody.innerHTML = conciertos.map(c => `
                <tr>
                    <td><strong>${c.nombre}</strong></td>
                    <td>${c.artista}</td>
                    <td>${formatFecha(c.fecha_evento)}</td>
                    <td>${c.ubicacion}</td>
                    <td>$${Number(c.precio).toLocaleString('es-MX')}</td>
                    <td>${c.boletos_disponibles}</td>
                    <td><span class="badge badge-${c.status}">${c.status}</span></td>
                </tr>
            `).join('');
        }

        // ── Render paginación ──────────────────────────────────────
        function renderPaginacion(paginaActual, ultimaPagina) {
            const pag = document.getElementById('pagination');

            if (ultimaPagina <= 1) { pag.innerHTML = ''; return; }

            let html = `
                <button class="page-btn"
                    onclick="cargarConciertos(${paginaActual - 1})"
                    ${paginaActual === 1 ? 'disabled' : ''}>
                    ← Anterior
                </button>`;

            for (let i = 1; i <= ultimaPagina; i++) {
                html += `
                    <button class="page-btn ${i === paginaActual ? 'active' : ''}"
                        onclick="cargarConciertos(${i})">
                        ${i}
                    </button>`;
            }

            html += `
                <button class="page-btn"
                    onclick="cargarConciertos(${paginaActual + 1})"
                    ${paginaActual === ultimaPagina ? 'disabled' : ''}>
                    Siguiente →
                </button>
                <span class="page-info">Página ${paginaActual} de ${ultimaPagina}</span>`;

            pag.innerHTML = html;
        }

        // ── FETCH PRINCIPAL ────────────────────────────────────────
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

                const json = await res.json();

                // Laravel paginate() devuelve: { data, total, last_page, current_page, ... }
                const conciertos   = json.data      ?? json;
                const total        = json.total      ?? conciertos.length;
                const ultimaPagina = json.last_page  ?? 1;

                document.getElementById('totalInfo').textContent =
                    `${total} concierto${total !== 1 ? 's' : ''} en total`;

                renderFilas(conciertos);
                renderPaginacion(pagina, ultimaPagina);

            } catch (err) {
                console.error(err);
                document.getElementById('conciertosTbody').innerHTML = `
                    <tr>
                        <td colspan="7">
                            <div class="estado-msg">
                                ⚠️ Error al cargar los datos.
                                <a href="#" onclick="cargarConciertos(${pagina}); return false;"
                                   style="color:#333; margin-left:6px;">Reintentar</a>
                            </div>
                        </td>
                    </tr>`;
            }
        }

        // ── Helper fecha ──────────────────────────────────────────
        function formatFecha(str) {
            return new Date(str).toLocaleDateString('es-MX', {
                day: '2-digit', month: 'short', year: 'numeric'
            });
        }

        // ── Arrancar al cargar la página ──────────────────────────
        cargarConciertos(1);
    </script>

</body>
</html>