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
            // Validar reCAPTCHA de Google - SI FALLA, VA A /ERROR
            $recaptchaResponse = $request->input('g-recaptcha-response');
            
            if (!RecaptchaHelper::verify($recaptchaResponse)) {
                Log::warning('reCAPTCHA falló en reserva de concierto', [
                    'ip' => $request->ip(),
                    'email' => $request->input('email')
                ]);
                
                // REDIRIGIR A /ERROR (como querías)
                return redirect()
                    ->route('error')
                    ->with('error', '❌ Verificación de seguridad fallida. Por favor completa el reCAPTCHA correctamente.');
            }

            // VALIDACIONES COMPLETAS - SI FALLAN, SE MUESTRAN EN EL FORMULARIO
            $validated = $request->validate([
                // Información personal
                'nombre' => [
                    'required',
                    'string',
                    'min:3',
                    'max:100',
                    'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/' // Solo letras y espacios
                ],
                'email' => [
                    'required',
                    'email',
                    'max:255'
                ],
                'telefono' => [
                    'required',
                    'string',
                    'min:10',
                    'max:15',
                    'regex:/^[0-9]+$/' // Solo números
                ],
                'edad' => [
                    'required',
                    'integer',
                    'min:18',
                    'max:100'
                ],
                'documento' => [
                    'required',
                    'string',
                    'min:5',
                    'max:20'
                ],
                
                // Detalles de la reserva
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
                ],
                'tipo_boleto' => [
                    'required',
                    'string',
                    'in:VIP,Preferente,General'
                ],
                'metodo_pago' => [
                    'required',
                    'string',
                    'in:Tarjeta de crédito,Tarjeta de débito,Transferencia,Efectivo'
                ],
                'direccion' => [
                    'required',
                    'string',
                    'min:10',
                    'max:200'
                ],
                
                // Opcionales
                'comentarios' => [
                    'nullable',
                    'string',
                    'max:500'
                ],
                'acepta_terminos' => [
                    'required',
                    'accepted'
                ]
            ], [
                // Mensajes personalizados
                'nombre.required' => 'El nombre es obligatorio',
                'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
                'nombre.max' => 'El nombre no puede exceder 100 caracteres',
                'nombre.regex' => 'El nombre solo puede contener letras y espacios',
                
                'email.required' => 'El correo electrónico es obligatorio',
                'email.email' => 'El formato del correo no es válido',
                
                'telefono.required' => 'El teléfono es obligatorio',
                'telefono.min' => 'El teléfono debe tener al menos 10 dígitos',
                'telefono.max' => 'El teléfono no puede exceder 15 dígitos',
                'telefono.regex' => 'El teléfono solo puede contener números',
                
                'edad.required' => 'La edad es obligatoria',
                'edad.min' => 'Debes ser mayor de 18 años para reservar',
                'edad.max' => 'La edad ingresada no es válida',
                
                'documento.required' => 'El documento de identidad es obligatorio',
                'documento.min' => 'El documento debe tener al menos 5 caracteres',
                
                'concierto.required' => 'Debes seleccionar un concierto',
                'concierto.in' => 'El concierto seleccionado no es válido',
                
                'cantidad.required' => 'La cantidad de boletos es obligatoria',
                'cantidad.min' => 'Debes reservar al menos 1 boleto',
                'cantidad.max' => 'Máximo 10 boletos por reserva',
                
                'tipo_boleto.required' => 'Debes seleccionar un tipo de boleto',
                'tipo_boleto.in' => 'El tipo de boleto seleccionado no es válido',
                
                'metodo_pago.required' => 'Debes seleccionar un método de pago',
                'metodo_pago.in' => 'El método de pago seleccionado no es válido',
                
                'direccion.required' => 'La dirección es obligatoria',
                'direccion.min' => 'La dirección debe tener al menos 10 caracteres',
                'direccion.max' => 'La dirección no puede exceder 200 caracteres',
                
                'comentarios.max' => 'Los comentarios no pueden exceder 500 caracteres',
                
                'acepta_terminos.required' => 'Debes aceptar los términos y condiciones',
                'acepta_terminos.accepted' => 'Debes aceptar los términos y condiciones para continuar'
            ]);

            // Calcular precio total
            $precios = [
                'Rock Festival 2026' => 850,
                'Festival Electrónico' => 650,
                'Concierto Sinfónico' => 450,
                'Pop Latino Tour' => 950
            ];
            
            $multiplicadores = [
                'VIP' => 1.5,
                'Preferente' => 1.2,
                'General' => 1.0
            ];
            
            $precioBase = $precios[$validated['concierto']] ?? 0;
            $multiplicador = $multiplicadores[$validated['tipo_boleto']] ?? 1.0;
            $precioTotal = $precioBase * $multiplicador * $validated['cantidad'];

            // SIMULACIÓN: NO se guarda en BD
            Log::info('Reserva de concierto (PROTOTIPO - NO SE GUARDA)', [
                'nombre' => $validated['nombre'],
                'email' => $validated['email'],
                'telefono' => $validated['telefono'],
                'edad' => $validated['edad'],
                'documento' => $validated['documento'],
                'concierto' => $validated['concierto'],
                'cantidad' => $validated['cantidad'],
                'tipo_boleto' => $validated['tipo_boleto'],
                'metodo_pago' => $validated['metodo_pago'],
                'direccion' => $validated['direccion'],
                'comentarios' => $validated['comentarios'] ?? 'Sin comentarios',
                'precio_total' => $precioTotal,
                'timestamp' => now()
            ]);

            // Mensaje de éxito detallado
            $mensaje = "🎉 ¡Reserva realizada con éxito!\n\n" .
                      "📋 DETALLES DE TU RESERVA:\n" .
                      "━━━━━━━━━━━━━━━━━━━━━━━━━━\n" .
                      "👤 Nombre: {$validated['nombre']}\n" .
                      "📧 Email: {$validated['email']}\n" .
                      "📱 Teléfono: {$validated['telefono']}\n" .
                      "🎫 Concierto: {$validated['concierto']}\n" .
                      "🎟️ Boletos: {$validated['cantidad']} x {$validated['tipo_boleto']}\n" .
                      "💰 Total: $" . number_format($precioTotal, 2) . " MXN\n" .
                      "💳 Método de pago: {$validated['metodo_pago']}\n" .
                      "📍 Dirección: {$validated['direccion']}\n\n" .
                      "⚠️ IMPORTANTE: Esto es un prototipo.\n" .
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
            
            // Errores generales VAN A /ERROR
            return redirect()
                ->route('error')
                ->with('error', '❌ Error al procesar la reserva. Por favor intenta de nuevo.');
        }
    }
}