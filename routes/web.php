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