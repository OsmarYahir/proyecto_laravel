<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConciertosController;

// Página de inicio
Route::get('/', function () {
    return view('inicio');
})->name('home');

// Conciertos
Route::get('/conciertos', [ConciertosController::class, 'index'])->name('conciertos');
Route::post('/conciertos/reservar', [ConciertosController::class, 'reservar'])->name('conciertos.reservar');

// Autenticación (CON BD)
Route::get('/registro', [RegisterController::class, 'create'])->name('registro');
Route::post('/registro', [RegisterController::class, 'store'])->name('registro.store');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// Página de error
Route::get('/error', function () {
    return view('error');
})->name('error');

// Ruta catch-all para 404 (DEBE IR AL FINAL)
Route::fallback(function () {
    return redirect()
        ->route('error')
        ->with('error', 'Error 404: La página que buscas no existe o fue movida.');
});

use App\Http\Controllers\ImagenesController;

Route::get('/imagenes', [ImagenesController::class, 'index'])->name('imagenes.index');
Route::post('/imagenes', [ImagenesController::class, 'store'])->name('imagenes.store');
Route::delete('/imagenes/{id}', [ImagenesController::class, 'destroy'])->name('imagenes.destroy');