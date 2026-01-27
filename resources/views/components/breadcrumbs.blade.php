<div>
     @vite(['resources/css/navbar.css', 'resources/js/navbar.js', 'resources/css/inicio.css', 'resources/js/inicio.js'])
<nav class="breadcrumb-container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
        
        @foreach($breadcrumbs as $breadcrumb)
            @if (!$loop->last)
                <li class="breadcrumb-item">
                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a>
                </li>
            @else
                <li class="breadcrumb-item active">{{ $breadcrumb['name'] }}</li>
            @endif
        @endforeach
    </ol>
</nav>
<!-- No surplus words or unnecessary actions. - Marcus Aurelius -->
</div>