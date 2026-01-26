<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class RegisterController extends Controller
{
    public function create() {
        return view('auth.registro');
    }

    public function store(Request $request) {
        // Validar CAPTCHA primero
        try {
            $userAnswer = $request->input('captcha_answer');
            $token = $request->input('captcha_token');
            
            if (!$token || !$userAnswer) {
                return back()->withErrors(['captcha_answer' => 'Por favor completa la verificación de seguridad'])->withInput();
            }
            
            // Desencriptar respuesta correcta
            $correctAnswer = Crypt::decryptString($token);
            
            if ((string)$userAnswer !== (string)$correctAnswer) {
                return back()->withErrors(['captcha_answer' => 'La respuesta es incorrecta. Intenta de nuevo'])->withInput();
            }
            
        } catch (\Exception $e) {
            return back()->withErrors(['captcha_answer' => 'Error en la verificación. Por favor recarga la página'])->withInput();
        }

        // Validar los datos del formulario
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

        try {
            // Crear el usuario
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'telefono' => $validated['telefono'] ?? null,
            ]);

            return redirect()->route('login')->with('success', '¡Cuenta creada con éxito! Ya puedes iniciar sesión.');
        } catch (\Exception $e) {
            return redirect()->route('error')->with('error', 'Error al crear la cuenta: ' . $e->getMessage());
        }
    }
}