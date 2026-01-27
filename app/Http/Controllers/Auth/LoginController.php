<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Helpers\RecaptchaHelper;

class LoginController extends Controller
{
    public function create() {
        return view('auth.login');
    }

    public function store(Request $request) {
        try {
            // Validar reCAPTCHA de Google
            $recaptchaResponse = $request->input('g-recaptcha-response');
            
            // Si no hay respuesta de reCAPTCHA o la validación falla
            if (!RecaptchaHelper::verify($recaptchaResponse)) {
                Log::warning('reCAPTCHA falló en login', [
                    'ip' => $request->ip(),
                    'email' => $request->input('email')
                ]);
                
                // Redirigir a la vista de error
                return redirect()
                    ->route('error')
                    ->with('error', '❌ Verificación de seguridad fallida. Por favor completa el reCAPTCHA correctamente.');
            }

            // Validar credenciales
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ], [
                'email.required' => 'El correo electrónico es obligatorio',
                'email.email' => 'El formato del correo no es válido',
                'password.required' => 'La contraseña es obligatoria',
            ]);

            // Intentar login
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                
                Log::info('Usuario inició sesión', [
                    'email' => $credentials['email']
                ]);
                
                return redirect()->intended('/')->with('success', '¡Bienvenido de nuevo!');
            }

            // Si las credenciales no coinciden
            Log::warning('Intento de login fallido', [
                'email' => $credentials['email'],
                'ip' => $request->ip()
            ]);

            return redirect()
                ->route('error')
                ->with('error', '❌ Las credenciales no coinciden con nuestros registros.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = collect($e->errors())->flatten()->implode('. ');
            
            return redirect()
                ->route('error')
                ->with('error', '❌ ' . $errors);
            
        } catch (\Exception $e) {
            Log::error('Error en login', [
                'message' => $e->getMessage()
            ]);
            
            return redirect()
                ->route('error')
                ->with('error', '❌ Error al iniciar sesión. Por favor intenta de nuevo.');
        }
    }

    public function destroy(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Sesión cerrada correctamente');
    }
}