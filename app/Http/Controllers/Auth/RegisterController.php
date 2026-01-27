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
        try {
            // Validar reCAPTCHA de Google
            $recaptchaResponse = $request->input('g-recaptcha-response');
            
            // Si no hay respuesta de reCAPTCHA o la validación falla
            if (!RecaptchaHelper::verify($recaptchaResponse)) {
                Log::warning('reCAPTCHA falló en registro', [
                    'ip' => $request->ip(),
                    'email' => $request->input('email')
                ]);
                
                // Redirigir a la vista de error
                return redirect()
                    ->route('error')
                    ->with('error', '❌ Verificación de seguridad fallida. Por favor completa el reCAPTCHA correctamente.');
            }

            // Validar datos del formulario
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

            // Crear usuario en la base de datos
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
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = collect($e->errors())->flatten()->implode('. ');
            
            return redirect()
                ->route('error')
                ->with('error', '❌ Errores de validación: ' . $errors);
            
        } catch (\Exception $e) {
            Log::error('Error creando usuario', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->route('error')
                ->with('error', '❌ Error al crear la cuenta. Por favor intenta de nuevo.');
        }
    }
}