<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    public function create() {
        return view('auth.login');
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

        // Validar credenciales
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El formato del correo no es válido',
            'password.required' => 'La contraseña es obligatoria',
        ]);

        // Intentar autenticar
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect()->intended('/')->with('success', '¡Bienvenido de nuevo!');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->withInput();
    }

    public function destroy(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Sesión cerrada correctamente');
    }
}