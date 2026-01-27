import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/navbar.css',
                'resources/js/navbar.js', 
                'resources/css/inicio.css',
                'resources/js/inicio.js',
                'resources/css/error.css',
            ],
            refresh: true,
        }),
        // Si no vas a usar Tailwind, puedes comentar o borrar la siguiente línea:
        // tailwindcss(), 
    ],
});