<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Helpers\RecaptchaHelper;

class RegisterController extends Controller
{
    public function create() {
        return view('auth.registro');
    }

    public function store(Request $request) {
        // 1. Validar reCAPTCHA PRIMERO
        $recaptchaResponse = $request->input('g-recaptcha-response');
        
        if (!RecaptchaHelper::verify($recaptchaResponse)) {
            Log::warning('reCAPTCHA falló en registro', [
                'ip' => $request->ip(),
                'email' => $request->input('email')
            ]);
            
            // Volver al formulario con el error
            return back()
                ->withErrors(['recaptcha' => 'Por favor verifica que no eres un robot.'])
                ->withInput();
        }

        // 2. Validar datos del formulario
        // Laravel automáticamente vuelve al formulario si hay errores
        $validated = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'telefono' => 'nullable|string|max:15',
        ], [
            'name.required' => 'El nombre es obligatorio',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El formato del correo no es válido',
            'email.unique' => 'Este correo ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        // 3. Intentar crear el usuario
        try {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'telefono' => $validated['telefono'] ?? null,
            ]);

            Log::info('Usuario registrado exitosamente', [
                'email' => $validated['email']
            ]);

            return redirect()
                ->route('login')
                ->with('success', '¡Cuenta creada con éxito! Ya puedes iniciar sesión.');
                
        } catch (\Exception $e) {
            Log::error('Error creando usuario', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Si hay un error de BD, redirigir a la página de error
            return redirect()
                ->route('error')
                ->with('error', 'Error al crear la cuenta. Por favor intenta de nuevo.');
        }
    }
}