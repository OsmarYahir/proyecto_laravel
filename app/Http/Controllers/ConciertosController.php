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
            // Validar reCAPTCHA - SI FALLA, VA A /ERROR
            $recaptchaResponse = $request->input('g-recaptcha-response');
            
            if (!RecaptchaHelper::verify($recaptchaResponse)) {
                Log::warning('reCAPTCHA falló en reserva', [
                    'ip' => $request->ip()
                ]);
                
                return redirect()
                    ->route('error')
                    ->with('error', '❌ Por favor completa el reCAPTCHA.');
            }

            // VALIDACIONES CON EXPRESIONES REGULARES - ERRORES SE MUESTRAN EN EL FORMULARIO
            $validated = $request->validate([
                'nombre' => [
                    'required',
                    'string',
                    'min:3',
                    'max:100',
                    'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/' // Solo letras (con acentos) y espacios
                ],
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/' // Email válido
                ],
                'telefono' => [
                    'required',
                    'string',
                    'regex:/^[0-9]{10}$/' // Exactamente 10 números
                ],
                'concierto' => [
                    'required',
                    'string',
                    'in:Rock Festival 2026,Festival Electrónico,Concierto Sinfónico,Pop Latino Tour'
                ],
                'cantidad' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:10'
                ]
            ], [
                // Mensajes personalizados por cada validación
                'nombre.required' => 'El nombre es obligatorio',
                'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
                'nombre.max' => 'El nombre no puede exceder 100 caracteres',
                'nombre.regex' => 'El nombre solo puede contener letras y espacios (sin números ni símbolos)',
                
                'email.required' => 'El correo electrónico es obligatorio',
                'email.email' => 'El formato del correo no es válido',
                'email.regex' => 'El correo debe tener un formato válido (ejemplo@dominio.com)',
                
                'telefono.required' => 'El teléfono es obligatorio',
                'telefono.regex' => 'El teléfono debe tener exactamente 10 dígitos numéricos (sin guiones ni espacios)',
                
                'concierto.required' => 'Debes seleccionar un concierto',
                'concierto.in' => 'El concierto seleccionado no es válido',
                
                'cantidad.required' => 'La cantidad de boletos es obligatoria',
                'cantidad.integer' => 'La cantidad debe ser un número entero',
                'cantidad.min' => 'Debes reservar al menos 1 boleto',
                'cantidad.max' => 'El máximo es 10 boletos por reserva'
            ]);

            // Calcular precio
            $precios = [
                'Rock Festival 2026' => 850,
                'Festival Electrónico' => 650,
                'Concierto Sinfónico' => 450,
                'Pop Latino Tour' => 950
            ];
            
            $precioBase = $precios[$validated['concierto']] ?? 0;
            $precioTotal = $precioBase * $validated['cantidad'];

            // Log (NO se guarda en BD)
            Log::info('Reserva de concierto (PROTOTIPO)', [
                'nombre' => $validated['nombre'],
                'email' => $validated['email'],
                'telefono' => $validated['telefono'],
                'concierto' => $validated['concierto'],
                'cantidad' => $validated['cantidad'],
                'total' => $precioTotal,
                'timestamp' => now()
            ]);

            // Mensaje de éxito detallado
            $mensaje = "🎉 ¡Reserva realizada con éxito!\n\n" .
                      "📋 DETALLES:\n" .
                      "━━━━━━━━━━━━━━━━━━━━\n" .
                      "👤 Nombre: {$validated['nombre']}\n" .
                      "📧 Email: {$validated['email']}\n" .
                      "📱 Teléfono: {$validated['telefono']}\n" .
                      "🎫 Concierto: {$validated['concierto']}\n" .
                      "🎟️ Boletos: {$validated['cantidad']}\n" .
                      "💰 Total: $" . number_format($precioTotal, 2) . " MXN\n\n" .
                      "⚠️ NOTA: Esto es un prototipo.\n" .
                      "La reserva NO se guardó en la base de datos.";

            return redirect()
                ->route('conciertos')
                ->with('success', $mensaje);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Los errores de validación SE MUESTRAN EN EL FORMULARIO
            return back()->withErrors($e->validator)->withInput();
            
        } catch (\Exception $e) {
            Log::error('Error en reserva de concierto', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->route('error')
                ->with('error', '❌ Error al procesar la reserva. Por favor intenta de nuevo.');
        }
    }
}