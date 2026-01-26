<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CaptchaController;

// Todas las rutas en el grupo web (con sesión y CSRF)
Route::middleware(['web'])->group(function () {
    
    Route::get('/', function () {
        return view('inicio');
    })->name('home');
    
    // Rutas de autenticación
    Route::get('/registro', [RegisterController::class, 'create'])->name('registro');
    Route::post('/registro', [RegisterController::class, 'store'])->name('registro.store');
    
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    
    // Ruta del CAPTCHAphp artisan route:list | grep captcha
    Route::get('/captcha/generate', [CaptchaController::class, 'generate'])->name('captcha.generate');
    
    Route::get('/error', function () {
        return view('error');
    })->name('error');
});