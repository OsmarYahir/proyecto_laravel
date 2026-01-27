<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Mania - Reserva de Conciertos</title>
    <style>
        :root {
            --primary: #6366f1; /* Indigo moderno */
            --primary-hover: #4f46e5;
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --accent: #f43f5e; /* Rosa/Rojo para detalles */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
        }

        /* Navbar Moderna */
        .navbar {
            background: #ffffff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar .brand {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
            letter-spacing: -1px;
        }

        .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            margin-left: 1.5rem;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        /* Grid de Conciertos */
        .conciertos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .concierto-card {
            background: var(--bg-card);
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .concierto-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }

        .concierto-card h3 {
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .concierto-card p {
            font-size: 0.9rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Formulario Estilizado */
        .formulario-card {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }

        .formulario-card h2 {
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 0.5rem;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 1.5rem 0 1rem 0;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .input-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
        }

        input, select, textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background-color: #fff;
            font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .two-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .btn-submit {
            width: 100%;
            background-color: var(--primary);
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 1rem;
        }

        .btn-submit:hover {
            background-color: var(--primary-hover);
        }

        .help-text {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .two-columns {
                grid-template-columns: 1fr;
            }
            .navbar {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="#" class="brand">TIKET MANIA</a>
        <div class="nav-links">
            <a href="#">Conciertos</a>
            <a href="#">Cuenta</a>
            <a href="#">Login</a>
        </div>
    </nav>

     <x-breadcrumbs />

    <div class="container">
        <h1>Próximos Conciertos</h1>
        
        <div class="conciertos-grid">
            <div class="concierto-card">
                <h3>Rock Festival</h3>
                <p>15 Mar, 2026</p>
                <p>CDMX</p>
                <p>$850 MXN</p>
            </div>
            <div class="concierto-card">
                <h3>Electro Night</h3>
                <p>22 Abr, 2026</p>
                <p>Guadalajara</p>
                <p>$650 MXN</p>
            </div>
            <div class="concierto-card">
                <h3>Pop Tour</h3>
                <p>18 Jun, 2026</p>
                <p>Monterrey</p>
                <p>$950 MXN</p>
            </div>
        </div>

        <div class="formulario-card">
            <h2>Reserva tu lugar</h2>
            
            <form action="#">
                <p class="section-title">Datos del Asistente</p>
                
                <div class="input-group">
                    <label>Nombre Completo</label>
                    <input type="text" placeholder="Tu nombre aquí..." required>
                </div>

                <div class="two-columns">
                    <div class="input-group">
                        <label>Correo Electrónico</label>
                        <input type="email" placeholder="email@ejemplo.com" required>
                    </div>
                    <div class="input-group">
                        <label>Teléfono</label>
                        <input type="tel" placeholder="10 dígitos">
                    </div>
                </div>

                <p class="section-title">Detalles del Ticket</p>

                <div class="input-group">
                    <label>Selecciona tu Concierto</label>
                    <select required>
                        <option value="">-- Elige un evento --</option>
                        <option>Rock Festival 2026</option>
                        <option>Electro Night</option>
                        <option>Pop Tour</option>
                    </select>
                </div>

                <div class="two-columns">
                    <div class="input-group">
                        <label>Cantidad</label>
                        <input type="number" value="1" min="1" max="10">
                    </div>
                    <div class="input-group">
                        <label>Zona</label>
                        <select>
                            <option>General</option>
                            <option>Preferente</option>
                            <option>VIP</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Confirmar Reserva </button>
            </form>
        </div>
    </div>

</body>
</html>