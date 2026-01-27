<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Helpers\RecaptchaHelper;

class ConciertosController extends Controller
{
    public function index()
    {
        return view('conciertos');
    }

    public function reservar(Request $request)
    {
        try {
            // Validar reCAPTCHA de Google
            $recaptchaResponse = $request->input('g-recaptcha-response');
            
            if (!RecaptchaHelper::verify($recaptchaResponse)) {
                return redirect()->route('error')
                    ->with('error', 'Por favor verifica que no eres un robot.');
            }

            // Validar formulario
            $validated = $request->validate([
                'nombre' => 'required|string|min:3|max:255',
                'email' => 'required|email|max:255',
                'telefono' => 'required|string|min:10|max:15',
                'concierto' => 'required|string',
                'cantidad' => 'required|integer|min:1|max:10',
            ], [
                'nombre.required' => 'El nombre es obligatorio',
                'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
                'email.required' => 'El correo es obligatorio',
                'email.email' => 'El formato del correo no es válido',
                'telefono.required' => 'El teléfono es obligatorio',
                'telefono.min' => 'El teléfono debe tener al menos 10 dígitos',
                'concierto.required' => 'Debes seleccionar un concierto',
                'cantidad.required' => 'La cantidad de boletos es obligatoria',
                'cantidad.min' => 'Debes reservar al menos 1 boleto',
                'cantidad.max' => 'Máximo 10 boletos por reserva',
            ]);

            // SIMULACIÓN: NO se guarda en BD
            Log::info('Reserva de concierto (PROTOTIPO - NO SE GUARDA)', [
                'nombre' => $validated['nombre'],
                'email' => $validated['email'],
                'telefono' => $validated['telefono'],
                'concierto' => $validated['concierto'],
                'cantidad' => $validated['cantidad'],
                'timestamp' => now()
            ]);

            // Mensaje de éxito personalizado
            $mensaje = "¡Reserva realizada con éxito! 🎉\n\n" .
                      "Detalles de tu reserva:\n" .
                      "• Nombre: {$validated['nombre']}\n" .
                      "• Email: {$validated['email']}\n" .
                      "• Concierto: {$validated['concierto']}\n" .
                      "• Boletos: {$validated['cantidad']}\n\n" .
                      "⚠️ NOTA: Esto es un prototipo, la reserva NO se guardó en la base de datos.";

            return redirect()
                ->route('conciertos')
                ->with('success', $mensaje);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = collect($e->errors())->flatten()->implode('. ');
            return redirect()->route('error')->with('error', 'Errores de validación: ' . $errors);
            
        } catch (\Exception $e) {
            Log::error('Error en reserva de concierto', [
                'message' => $e->getMessage()
            ]);
            
            return redirect()
                ->route('error')
                ->with('error', 'Error al procesar la reserva. Por favor intenta de nuevo.');
        }
    }
}