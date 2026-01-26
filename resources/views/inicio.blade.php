<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/navbar.css', 'resources/js/navbar.js', 'resources/css/inicio.css', 'resources/js/inicio.js'])
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

    <section class="carrusel">
        <section class="carousel-container">
            <div class="carousel-slide">
                <div class="event-banner">
                    <img src="banner1.jpg" alt="Concierto 1">
                    <div class="banner-info">
                        <h2>Tour 2026 - Artista Increíble</h2>
                        <button class="btn-buy">Comprar ahora</button>
                    </div>
                </div>
                <div class="event-banner">
                    <img src="banner2.jpg" alt="Evento 2">
                </div>
            </div>

            <button id="prevBtn">❮</button>
            <button id="nextBtn">❯</button>
        </section>
    </section>
    <div>

    </div>

</body>

</html>