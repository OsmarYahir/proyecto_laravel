<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Editar Concierto - TIKET MANIA</title>
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
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border: 1px solid #ddd;
        }

        h1 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        label .required {
            color: #dc3545;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .help-text {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
            display: block;
        }

        .error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .input-error {
            border-color: #dc3545;
            background: #fff5f5;
        }

        .input-valid {
            border-color: #28a745;
            background: #f0fff4;
        }

        .error-summary {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }

        .error-summary ul {
            margin-left: 20px;
            margin-top: 10px;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #333;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            margin-right: 10px;
            font-size: 16px;
        }

        .btn:hover {
            background: #555;
        }

        .btn-secondary {
            background: #666;
        }

        .two-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .two-columns {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="{{ secure_url('/') }}">TIKET MANIA</a>
        <a href="{{ secure_url(route('conciertos-crud.index')) }}">Gestión Conciertos</a>
    </div>

    <x-breadcrumbs />

    <div class="container">
        <h1>✏️ Editar Concierto</h1>

        @if ($errors->any())
            <div class="error-summary">
                <strong>⚠️ Corrige los siguientes errores:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ secure_url(route('conciertos-crud.update', $concierto->id)) }}" method="POST" id="editForm">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nombre del Concierto <span class="required">*</span></label>
                <input 
                    type="text" 
                    name="nombre" 
                    id="nombre"
                    value="{{ old('nombre', $concierto->nombre) }}" 
                    required
                    class="{{ $errors->has('nombre') ? 'input-error' : '' }}"
                >
                <span class="error" id="nombre-error"></span>
                <span class="help-text" id="nombre-help">✓ Mínimo 3 caracteres</span>
            </div>

            <div class="form-group">
                <label>Artista/Banda <span class="required">*</span></label>
                <input 
                    type="text" 
                    name="artista" 
                    id="artista"
                    value="{{ old('artista', $concierto->artista) }}" 
                    required
                    class="{{ $errors->has('artista') ? 'input-error' : '' }}"
                >
                <span class="error" id="artista-error"></span>
                <span class="help-text" id="artista-help">✓ Mínimo 3 caracteres</span>
            </div>

            <div class="form-group">
                <label>Descripción</label>
                <textarea 
                    name="descripcion" 
                    id="descripcion"
                    class="{{ $errors->has('descripcion') ? 'input-error' : '' }}"
                >{{ old('descripcion', $concierto->descripcion) }}</textarea>
                <span class="error" id="descripcion-error"></span>
                <span class="help-text" id="descripcion-help">✓ Opcional - Máximo 1000 caracteres</span>
            </div>

            <div class="form-group">
                <label>Ubicación <span class="required">*</span></label>
                <input 
                    type="text" 
                    name="ubicacion" 
                    id="ubicacion"
                    value="{{ old('ubicacion', $concierto->ubicacion) }}" 
                    required
                    class="{{ $errors->has('ubicacion') ? 'input-error' : '' }}"
                >
                <span class="error" id="ubicacion-error"></span>
                <span class="help-text" id="ubicacion-help">✓ Mínimo 5 caracteres</span>
            </div>

            <div class="two-columns">
                <div class="form-group">
                    <label>Fecha y Hora del Evento <span class="required">*</span></label>
                    <input 
                        type="datetime-local" 
                        name="fecha_evento" 
                        id="fecha_evento"
                        value="{{ old('fecha_evento', $concierto->fecha_evento->format('Y-m-d\TH:i')) }}" 
                        required
                        class="{{ $errors->has('fecha_evento') ? 'input-error' : '' }}"
                    >
                    <span class="error" id="fecha_evento-error"></span>
                    <span class="help-text" id="fecha_evento-help">✓ Fecha del evento</span>
                </div>

                <div class="form-group">
                    <label>Precio (MXN) <span class="required">*</span></label>
                    <input 
                        type="number" 
                        name="precio" 
                        id="precio"
                        value="{{ old('precio', $concierto->precio) }}" 
                        required
                        min="0"
                        step="0.01"
                        class="{{ $errors->has('precio') ? 'input-error' : '' }}"
                    >
                    <span class="error" id="precio-error"></span>
                    <span class="help-text" id="precio-help">✓ Precio del boleto</span>
                </div>
            </div>

            <div class="two-columns">
                <div class="form-group">
                    <label>Capacidad Total <span class="required">*</span></label>
                    <input 
                        type="number" 
                        name="capacidad_total" 
                        id="capacidad_total"
                        value="{{ old('capacidad_total', $concierto->capacidad_total) }}" 
                        required
                        min="1"
                        class="{{ $errors->has('capacidad_total') ? 'input-error' : '' }}"
                    >
                    <span class="error" id="capacidad_total-error"></span>
                    <span class="help-text" id="capacidad_total-help">✓ Aforo máximo</span>
                </div>

                <div class="form-group">
                    <label>Boletos Disponibles <span class="required">*</span></label>
                    <input 
                        type="number" 
                        name="boletos_disponibles" 
                        id="boletos_disponibles"
                        value="{{ old('boletos_disponibles', $concierto->boletos_disponibles) }}" 
                        required
                        min="0"
                        class="{{ $errors->has('boletos_disponibles') ? 'input-error' : '' }}"
                    >
                    <span class="error" id="boletos_disponibles-error"></span>
                    <span class="help-text" id="boletos_disponibles-help">✓ Actualiza según ventas</span>
                </div>
            </div>

            <div class="form-group">
                <label>Status <span class="required">*</span></label>
                <select 
                    name="status" 
                    id="status"
                    required
                    class="{{ $errors->has('status') ? 'input-error' : '' }}"
                >
                    <option value="activo" {{ old('status', $concierto->status) == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="cancelado" {{ old('status', $concierto->status) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    <option value="agotado" {{ old('status', $concierto->status) == 'agotado' ? 'selected' : '' }}>Agotado</option>
                </select>
                <span class="error" id="status-error"></span>
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="btn">💾 Actualizar Concierto</button>
                <a href="{{ secure_url(route('conciertos-crud.index')) }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // NOMBRE
            const nombreInput = document.getElementById('nombre');
            const nombreError = document.getElementById('nombre-error');
            const nombreHelp = document.getElementById('nombre-help');
            
            nombreInput.addEventListener('input', function() {
                const value = this.value.trim();
                
                if (value === '') {
                    nombreInput.classList.remove('input-valid', 'input-error');
                    nombreError.textContent = '';
                    nombreHelp.style.display = 'block';
                } else if (value.length < 3) {
                    nombreInput.classList.add('input-error');
                    nombreInput.classList.remove('input-valid');
                    nombreError.textContent = '❌ Debe tener al menos 3 caracteres';
                    nombreHelp.style.display = 'none';
                } else if (value.length > 200) {
                    nombreInput.classList.add('input-error');
                    nombreInput.classList.remove('input-valid');
                    nombreError.textContent = '❌ Máximo 200 caracteres';
                    nombreHelp.style.display = 'none';
                } else {
                    nombreInput.classList.add('input-valid');
                    nombreInput.classList.remove('input-error');
                    nombreError.textContent = '';
                    nombreHelp.style.display = 'block';
                }
            });

            // ARTISTA
            const artistaInput = document.getElementById('artista');
            const artistaError = document.getElementById('artista-error');
            const artistaHelp = document.getElementById('artista-help');
            
            artistaInput.addEventListener('input', function() {
                const value = this.value.trim();
                
                if (value === '') {
                    artistaInput.classList.remove('input-valid', 'input-error');
                    artistaError.textContent = '';
                    artistaHelp.style.display = 'block';
                } else if (value.length < 3) {
                    artistaInput.classList.add('input-error');
                    artistaInput.classList.remove('input-valid');
                    artistaError.textContent = '❌ Debe tener al menos 3 caracteres';
                    artistaHelp.style.display = 'none';
                } else if (value.length > 200) {
                    artistaInput.classList.add('input-error');
                    artistaInput.classList.remove('input-valid');
                    artistaError.textContent = '❌ Máximo 200 caracteres';
                    artistaHelp.style.display = 'none';
                } else {
                    artistaInput.classList.add('input-valid');
                    artistaInput.classList.remove('input-error');
                    artistaError.textContent = '';
                    artistaHelp.style.display = 'block';
                }
            });

            // DESCRIPCIÓN
            const descripcionInput = document.getElementById('descripcion');
            const descripcionError = document.getElementById('descripcion-error');
            const descripcionHelp = document.getElementById('descripcion-help');
            
            descripcionInput.addEventListener('input', function() {
                const value = this.value.trim();
                
                if (value.length > 1000) {
                    descripcionInput.classList.add('input-error');
                    descripcionInput.classList.remove('input-valid');
                    descripcionError.textContent = '❌ Máximo 1000 caracteres';
                    descripcionHelp.style.display = 'none';
                } else {
                    descripcionInput.classList.remove('input-error');
                    if (value.length > 0) {
                        descripcionInput.classList.add('input-valid');
                    }
                    descripcionError.textContent = '';
                    descripcionHelp.style.display = 'block';
                }
            });

            // UBICACIÓN
            const ubicacionInput = document.getElementById('ubicacion');
            const ubicacionError = document.getElementById('ubicacion-error');
            const ubicacionHelp = document.getElementById('ubicacion-help');
            
            ubicacionInput.addEventListener('input', function() {
                const value = this.value.trim();
                
                if (value === '') {
                    ubicacionInput.classList.remove('input-valid', 'input-error');
                    ubicacionError.textContent = '';
                    ubicacionHelp.style.display = 'block';
                } else if (value.length < 5) {
                    ubicacionInput.classList.add('input-error');
                    ubicacionInput.classList.remove('input-valid');
                    ubicacionError.textContent = '❌ Debe tener al menos 5 caracteres';
                    ubicacionHelp.style.display = 'none';
                } else if (value.length > 255) {
                    ubicacionInput.classList.add('input-error');
                    ubicacionInput.classList.remove('input-valid');
                    ubicacionError.textContent = '❌ Máximo 255 caracteres';
                    ubicacionHelp.style.display = 'none';
                } else {
                    ubicacionInput.classList.add('input-valid');
                    ubicacionInput.classList.remove('input-error');
                    ubicacionError.textContent = '';
                    ubicacionHelp.style.display = 'block';
                }
            });

            // PRECIO
            const precioInput = document.getElementById('precio');
            const precioError = document.getElementById('precio-error');
            const precioHelp = document.getElementById('precio-help');
            
            precioInput.addEventListener('input', function() {
                const value = parseFloat(this.value);
                
                if (this.value === '') {
                    precioInput.classList.remove('input-valid', 'input-error');
                    precioError.textContent = '';
                    precioHelp.style.display = 'block';
                } else if (isNaN(value) || value < 0) {
                    precioInput.classList.add('input-error');
                    precioInput.classList.remove('input-valid');
                    precioError.textContent = '❌ Debe ser un número positivo';
                    precioHelp.style.display = 'none';
                } else if (value > 999999.99) {
                    precioInput.classList.add('input-error');
                    precioInput.classList.remove('input-valid');
                    precioError.textContent = '❌ Precio demasiado alto';
                    precioHelp.style.display = 'none';
                } else {
                    precioInput.classList.add('input-valid');
                    precioInput.classList.remove('input-error');
                    precioError.textContent = '';
                    precioHelp.style.display = 'block';
                }
            });

            // CAPACIDAD TOTAL
            const capacidadInput = document.getElementById('capacidad_total');
            const capacidadError = document.getElementById('capacidad_total-error');
            const capacidadHelp = document.getElementById('capacidad_total-help');
            
            capacidadInput.addEventListener('input', function() {
                const value = parseInt(this.value);
                
                if (this.value === '') {
                    capacidadInput.classList.remove('input-valid', 'input-error');
                    capacidadError.textContent = '';
                    capacidadHelp.style.display = 'block';
                } else if (isNaN(value) || value < 1) {
                    capacidadInput.classList.add('input-error');
                    capacidadInput.classList.remove('input-valid');
                    capacidadError.textContent = '❌ Debe ser al menos 1 persona';
                    capacidadHelp.style.display = 'none';
                } else if (value > 100000) {
                    capacidadInput.classList.add('input-error');
                    capacidadInput.classList.remove('input-valid');
                    capacidadError.textContent = '❌ Máximo 100,000 personas';
                    capacidadHelp.style.display = 'none';
                } else {
                    capacidadInput.classList.add('input-valid');
                    capacidadInput.classList.remove('input-error');
                    capacidadError.textContent = '';
                    capacidadHelp.style.display = 'block';
                }
            });

            // BOLETOS DISPONIBLES
            const boletosInput = document.getElementById('boletos_disponibles');
            const boletosError = document.getElementById('boletos_disponibles-error');
            const boletosHelp = document.getElementById('boletos_disponibles-help');
            
            boletosInput.addEventListener('input', function() {
                const value = parseInt(this.value);
                const capacidad = parseInt(capacidadInput.value);
                
                if (this.value === '') {
                    boletosInput.classList.remove('input-valid', 'input-error');
                    boletosError.textContent = '';
                    boletosHelp.style.display = 'block';
                } else if (isNaN(value) || value < 0) {
                    boletosInput.classList.add('input-error');
                    boletosInput.classList.remove('input-valid');
                    boletosError.textContent = '❌ No puede ser negativo';
                    boletosHelp.style.display = 'none';
                } else if (!isNaN(capacidad) && value > capacidad) {
                    boletosInput.classList.add('input-error');
                    boletosInput.classList.remove('input-valid');
                    boletosError.textContent = '❌ No puede superar la capacidad total';
                    boletosHelp.style.display = 'none';
                } else {
                    boletosInput.classList.add('input-valid');
                    boletosInput.classList.remove('input-error');
                    boletosError.textContent = '';
                    boletosHelp.style.display = 'block';
                }
            });

            // VALIDAR ANTES DE ENVIAR
            const form = document.getElementById('editForm');
            
            form.addEventListener('submit', function(e) {
                // Disparar todas las validaciones
                nombreInput.dispatchEvent(new Event('input'));
                artistaInput.dispatchEvent(new Event('input'));
                ubicacionInput.dispatchEvent(new Event('input'));
                precioInput.dispatchEvent(new Event('input'));
                capacidadInput.dispatchEvent(new Event('input'));
                boletosInput.dispatchEvent(new Event('input'));
                
                // Verificar errores
                const errores = document.querySelectorAll('.input-error');
                
                if (errores.length > 0) {
                    e.preventDefault();
                    alert('Por favor corrige los errores antes de continuar');
                    return false;
                }
                
                // Verificar campos requeridos vacíos
                if (nombreInput.value.trim() === '' || 
                    artistaInput.value.trim() === '' || 
                    ubicacionInput.value.trim() === '' ||
                    precioInput.value === '' ||
                    capacidadInput.value === '' ||
                    boletosInput.value === '') {
                    e.preventDefault();
                    alert('Por favor completa todos los campos obligatorios');
                    return false;
                }
            });
        });
    </script>
</body>
</html>