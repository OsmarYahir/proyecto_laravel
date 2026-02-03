<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Galería de Imágenes - TIKET MANIA</title>
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
        }

        h1 {
            margin-bottom: 30px;
        }

        /* Carrusel */
        .carousel-container {
            background: white;
            padding: 40px;
            border: 1px solid #ddd;
            margin-bottom: 40px;
            position: relative;
        }

        .carousel {
            position: relative;
            width: 100%;
            height: 500px;
            overflow: hidden;
            background: #000;
        }

        .carousel-slides {
            display: flex;
            transition: transform 0.5s ease;
            height: 100%;
        }

        .carousel-slide {
            min-width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .carousel-slide img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .carousel-slide .titulo {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 10px;
            text-align: center;
        }

        .carousel-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.5);
            color: white;
            border: none;
            padding: 15px 20px;
            cursor: pointer;
            font-size: 20px;
            z-index: 10;
        }

        .carousel-button:hover {
            background: rgba(0,0,0,0.8);
        }

        .carousel-button.prev {
            left: 10px;
        }

        .carousel-button.next {
            right: 10px;
        }

        .carousel-indicators {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 10;
        }

        .indicator {
            width: 12px;
            height: 12px;
            background: rgba(255,255,255,0.5);
            border: none;
            border-radius: 50%;
            cursor: pointer;
        }

        .indicator.active {
            background: white;
        }

        .empty-carousel {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 500px;
            background: #f0f0f0;
            color: #666;
            font-size: 18px;
        }

        /* Formulario de subida */
        .upload-form {
            background: white;
            padding: 30px;
            border: 1px solid #ddd;
            margin-bottom: 40px;
        }

        h2 {
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            font-size: 14px;
        }

        label .required {
            color: #dc3545;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #333;
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
            font-weight: 500;
        }

        .input-error {
            border-color: #dc3545 !important;
            background-color: #fff5f5;
        }

        .input-valid {
            border-color: #28a745 !important;
            background-color: #f0fff4;
        }

        .btn-upload {
            width: 100%;
            padding: 12px;
            background: #333;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
            font-size: 16px;
            font-weight: bold;
        }

        .btn-upload:hover {
            background: #555;
        }

        /* Preview de imagen */
        .image-preview {
            margin-top: 15px;
            text-align: center;
        }

        .image-preview img {
            max-width: 300px;
            max-height: 200px;
            border: 2px solid #ddd;
        }

        /* Galería */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .gallery-item {
            background: white;
            border: 1px solid #ddd;
            padding: 10px;
        }

        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .gallery-item-info {
            padding: 10px 0;
        }

        .gallery-item-title {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .gallery-item-date {
            font-size: 12px;
            color: #666;
            margin-bottom: 10px;
        }

        .btn-delete {
            width: 100%;
            padding: 8px;
            background: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        /* Mensajes */
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
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
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="/">TIKET MANIA</a>
        <a href="/conciertos">Conciertos</a>
        <a href="/imagenes">Galería</a>
        <a href="/registro">Cuenta</a>
        <a href="/login">Login</a>
    </div>

    <div class="container">
        <h1>Galería de Imágenes</h1>

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="error-summary">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error-summary">
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Carrusel -->
        <div class="carousel-container">
            <h2>Carrusel de Imágenes</h2>
            
            @if($imagenes->count() > 0)
                <div class="carousel">
                    <button class="carousel-button prev" onclick="moveSlide(-1)">&#10094;</button>
                    <button class="carousel-button next" onclick="moveSlide(1)">&#10095;</button>
                    
                    <div class="carousel-slides" id="carouselSlides">
                        @foreach($imagenes as $imagen)
                            <div class="carousel-slide">
                                <img src="{{ asset('storage/' . $imagen->ruta) }}" alt="{{ $imagen->titulo }}">
                                @if($imagen->titulo)
                                    <div class="titulo">{{ $imagen->titulo }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="carousel-indicators">
                        @foreach($imagenes as $index => $imagen)
                            <button class="indicator {{ $index == 0 ? 'active' : '' }}" 
                                    onclick="goToSlide({{ $index }})"></button>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="empty-carousel">
                    No hay imágenes en la galería. Sube tu primera imagen.
                </div>
            @endif
        </div>

        <!-- Formulario de subida -->
        <div class="upload-form">
            <h2>Subir Nueva Imagen</h2>

            <form action="{{ route('imagenes.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf

                <div class="input-group">
                    <label>Título (opcional)</label>
                    <input 
                        type="text" 
                        name="titulo" 
                        id="titulo"
                        value="{{ old('titulo') }}"
                        placeholder="Título de la imagen"
                        maxlength="255"
                    >
                    <span class="help-text">Opcional: Máximo 255 caracteres</span>
                </div>

                <div class="input-group">
                    <label>Imagen <span class="required">*</span></label>
                    <input 
                        type="file" 
                        name="imagen" 
                        id="imagen"
                        accept="image/jpeg,image/jpg,image/png,image/gif"
                        required
                        class="{{ $errors->has('imagen') ? 'input-error' : '' }}"
                    >
                    <span class="error" id="imagen-error"></span>
                    <span class="help-text" id="imagen-help">Formatos: JPG, JPEG, PNG, GIF. Máximo 5MB</span>
                </div>

                <div class="image-preview" id="imagePreview" style="display: none;">
                    <img id="previewImg" src="" alt="Preview">
                </div>

                <button type="submit" class="btn-upload">Subir Imagen</button>
            </form>
        </div>

        <!-- Galería en Grid -->
        @if($imagenes->count() > 0)
            <h2>Todas las Imágenes ({{ $imagenes->count() }})</h2>
            <div class="gallery-grid">
                @foreach($imagenes as $imagen)
                    <div class="gallery-item">
                        <img src="{{ asset('storage/' . $imagen->ruta) }}" alt="{{ $imagen->titulo }}">
                        <div class="gallery-item-info">
                            <div class="gallery-item-title">{{ $imagen->titulo }}</div>
                            <div class="gallery-item-date">{{ $imagen->created_at->format('d/m/Y H:i') }}</div>
                            <form action="{{ route('imagenes.destroy', $imagen->id) }}" method="POST" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar esta imagen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Eliminar</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        // Carrusel
        let currentSlide = 0;
        const totalSlides = {{ $imagenes->count() }};

        function moveSlide(direction) {
            currentSlide += direction;
            
            if (currentSlide < 0) {
                currentSlide = totalSlides - 1;
            } else if (currentSlide >= totalSlides) {
                currentSlide = 0;
            }
            
            updateCarousel();
        }

        function goToSlide(index) {
            currentSlide = index;
            updateCarousel();
        }

        function updateCarousel() {
            const slides = document.getElementById('carouselSlides');
            if (slides) {
                slides.style.transform = `translateX(-${currentSlide * 100}%)`;
            }
            
            // Actualizar indicadores
            const indicators = document.querySelectorAll('.indicator');
            indicators.forEach((indicator, index) => {
                if (index === currentSlide) {
                    indicator.classList.add('active');
                } else {
                    indicator.classList.remove('active');
                }
            });
        }

        // Auto-play carrusel (opcional)
        @if($imagenes->count() > 1)
        setInterval(() => {
            moveSlide(1);
        }, 5000); // Cambia cada 5 segundos
        @endif

        // Preview de imagen
        const imagenInput = document.getElementById('imagen');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const imagenError = document.getElementById('imagen-error');
        const imagenHelp = document.getElementById('imagen-help');

        imagenInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                // Validar tamaño
                const maxSize = 5 * 1024 * 1024; // 5MB
                if (file.size > maxSize) {
                    imagenInput.classList.add('input-error');
                    imagenInput.classList.remove('input-valid');
                    imagenError.textContent = 'La imagen no puede ser mayor a 5MB';
                    imagenHelp.style.display = 'none';
                    imagePreview.style.display = 'none';
                    return;
                }
                
                // Validar tipo
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    imagenInput.classList.add('input-error');
                    imagenInput.classList.remove('input-valid');
                    imagenError.textContent = 'Solo se permiten imágenes JPG, JPEG, PNG o GIF';
                    imagenHelp.style.display = 'none';
                    imagePreview.style.display = 'none';
                    return;
                }
                
                // Mostrar preview
                imagenInput.classList.remove('input-error');
                imagenInput.classList.add('input-valid');
                imagenError.textContent = '';
                imagenHelp.style.display = 'block';
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        // Validación del formulario
        const uploadForm = document.getElementById('uploadForm');
        
        uploadForm.addEventListener('submit', function(e) {
            const file = imagenInput.files[0];
            
            if (!file) {
                e.preventDefault();
                alert('Por favor selecciona una imagen');
                return;
            }
            
            if (imagenInput.classList.contains('input-error')) {
                e.preventDefault();
                alert('Por favor corrige los errores antes de continuar');
            }
        });
    </script>
</body>
</html>