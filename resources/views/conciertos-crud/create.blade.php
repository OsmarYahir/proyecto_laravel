<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Crear Concierto - TIKET MANIA</title>
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
        <a href="/">TIKET MANIA</a>
        <a href="/conciertos-crud">Gestión Conciertos</a>
    </div>

    <div class="container">
        <h1>➕ Crear Nuevo Concierto</h1>

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

        <form action="{{ secure_url(route('conciertos-crud.store')) }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nombre del Concierto <span class="required">*</span></label>
                <input 
                    type="text" 
                    name="nombre" 
                    value="{{ old('nombre') }}" 
                    required
                    placeholder="Rock Festival 2026"
                    class="{{ $errors->has('nombre') ? 'input-error' : '' }}"
                >
                @error('nombre')
                    <span class="error">{{ $message }}</span>
                @else
                    <span class="help-text">Nombre descriptivo del evento</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Artista/Banda <span class="required">*</span></label>
                <input 
                    type="text" 
                    name="artista" 
                    value="{{ old('artista') }}" 
                    required
                    placeholder="Metallica"
                    class="{{ $errors->has('artista') ? 'input-error' : '' }}"
                >
                @error('artista')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Descripción</label>
                <textarea 
                    name="descripcion" 
                    placeholder="Descripción del evento, invitados especiales, etc."
                    class="{{ $errors->has('descripcion') ? 'input-error' : '' }}"
                >{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <span class="error">{{ $message }}</span>
                @else
                    <span class="help-text">Opcional - Máximo 1000 caracteres</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Ubicación <span class="required">*</span></label>
                <input 
                    type="text" 
                    name="ubicacion" 
                    value="{{ old('ubicacion') }}" 
                    required
                    placeholder="Foro Sol, Ciudad de México"
                    class="{{ $errors->has('ubicacion') ? 'input-error' : '' }}"
                >
                @error('ubicacion')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="two-columns">
                <div class="form-group">
                    <label>Fecha y Hora del Evento <span class="required">*</span></label>
                    <input 
                        type="datetime-local" 
                        name="fecha_evento" 
                        value="{{ old('fecha_evento') }}" 
                        required
                        class="{{ $errors->has('fecha_evento') ? 'input-error' : '' }}"
                    >
                    @error('fecha_evento')
                        <span class="error">{{ $message }}</span>
                    @else
                        <span class="help-text">Debe ser una fecha futura</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Precio (MXN) <span class="required">*</span></label>
                    <input 
                        type="number" 
                        name="precio" 
                        value="{{ old('precio') }}" 
                        required
                        min="0"
                        step="0.01"
                        placeholder="850.00"
                        class="{{ $errors->has('precio') ? 'input-error' : '' }}"
                    >
                    @error('precio')
                        <span class="error">{{ $message }}</span>
                    @else
                        <span class="help-text">Precio base del boleto</span>
                    @enderror
                </div>
            </div>

            <div class="two-columns">
                <div class="form-group">
                    <label>Capacidad Total <span class="required">*</span></label>
                    <input 
                        type="number" 
                        name="capacidad_total" 
                        value="{{ old('capacidad_total') }}" 
                        required
                        min="1"
                        placeholder="5000"
                        class="{{ $errors->has('capacidad_total') ? 'input-error' : '' }}"
                    >
                    @error('capacidad_total')
                        <span class="error">{{ $message }}</span>
                    @else
                        <span class="help-text">Aforo máximo del evento</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Status <span class="required">*</span></label>
                    <select 
                        name="status" 
                        required
                        class="{{ $errors->has('status') ? 'input-error' : '' }}"
                    >
                        <option value="activo" {{ old('status') == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="cancelado" {{ old('status') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        <option value="agotado" {{ old('status') == 'agotado' ? 'selected' : '' }}>Agotado</option>
                    </select>
                    @error('status')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label>URL de Imagen</label>
                <input 
                    type="url" 
                    name="imagen_url" 
                    value="{{ old('imagen_url') }}" 
                    placeholder="https://ejemplo.com/imagen.jpg"
                    class="{{ $errors->has('imagen_url') ? 'input-error' : '' }}"
                >
                @error('imagen_url')
                    <span class="error">{{ $message }}</span>
                @else
                    <span class="help-text">Opcional - URL de imagen del evento</span>
                @enderror
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="btn">💾 Guardar Concierto</button>
                <a href="{{ route('conciertos-crud.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>