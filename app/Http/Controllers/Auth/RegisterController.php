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
            // Validar reCAPTCHA - SI FALLA, VA A /ERROR
            $recaptchaResponse = $request->input('g-recaptcha-response');
            
            if (!RecaptchaHelper::verify($recaptchaResponse)) {
                Log::warning('reCAPTCHA falló en registro', [
                    'ip' => $request->ip()
                ]);
                
                return redirect()
                    ->route('error')
                    ->with('error', '❌ Por favor completa el reCAPTCHA.');
            }

            // Validaciones con REGEX - ERRORES SE MUESTRAN EN EL FORMULARIO
            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                    'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/' // Solo letras y espacios
                ],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'unique:users',
                    'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/' // Email válido
                ],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/' // Mínimo 1 mayúscula, 1 minúscula, 1 número
                ],
                'telefono' => [
                    'nullable',
                    'string',
                    'regex:/^[0-9]{10}$/' // Exactamente 10 números (si se proporciona)
                ],
            ], [
                'name.required' => 'El nombre es obligatorio',
                'name.min' => 'El nombre debe tener al menos 3 caracteres',
                'name.regex' => 'El nombre solo puede contener letras y espacios',
                
                'email.required' => 'El correo electrónico es obligatorio',
                'email.email' => 'El formato del correo no es válido',
                'email.unique' => 'Este correo ya está registrado',
                'email.regex' => 'El correo debe tener un formato válido',
                
                'password.required' => 'La contraseña es obligatoria',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres',
                'password.confirmed' => 'Las contraseñas no coinciden',
                'password.regex' => 'La contraseña debe contener al menos: 1 mayúscula, 1 minúscula y 1 número',
                
                'telefono.regex' => 'El teléfono debe tener exactamente 10 dígitos numéricos',
            ]);

            // Crear usuario
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'telefono' => $validated['telefono'] ?? null,
            ]);

            Log::info('Usuario registrado', [
                'email' => $validated['email']
            ]);

            return redirect()
                ->route('login')
                ->with('success', '¡Cuenta creada con éxito! Ya puedes iniciar sesión.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Errores de validación SE MUESTRAN EN EL FORMULARIO
            return back()->withErrors($e->validator)->withInput();
            
        } catch (\Exception $e) {
            Log::error('Error creando usuario', [
                'error' => $e->getMessage()
            ]);
            
            return redirect()
                ->route('error')
                ->with('error', '❌ Error al crear la cuenta. Intenta de nuevo.');
        }
    }
}