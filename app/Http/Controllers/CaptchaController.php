<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class CaptchaController extends Controller
{
    public function generate()
    {
        try {
            // Generar operación matemática simple
            $num1 = rand(1, 10);
            $num2 = rand(1, 10);
            $operations = ['+', '-', '*'];
            $operation = $operations[array_rand($operations)];
            
            // Calcular resultado según la operación
            switch($operation) {
                case '+':
                    $result = $num1 + $num2;
                    break;
                case '-':
                    $result = $num1 - $num2;
                    break;
                case '*':
                    $result = $num1 * $num2;
                    break;
                default:
                    $result = $num1 + $num2;
            }
            
            // Encriptar la respuesta correcta
            $encrypted = Crypt::encryptString((string)$result);
            
            // Crear pregunta legible
            $question = "$num1 $operation $num2 = ?";
            
            // Log para debug
            Log::info('CAPTCHA generado', [
                'question' => $question,
                'result' => $result
            ]);
            
            return response()->json([
                'question' => $question,
                'token' => $encrypted,
                'success' => true
            ], 200, [
                'Content-Type' => 'application/json',
                'Cache-Control' => 'no-cache, no-store, must-revalidate'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al generar CAPTCHA', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Error al generar CAPTCHA: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
    
    public function validate(Request $request)
    {
        try {
            $userAnswer = $request->input('answer');
            $token = $request->input('token');
            
            if (!$token || !$userAnswer) {
                return response()->json(['valid' => false, 'error' => 'Datos incompletos']);
            }
            
            // Desencriptar respuesta correcta
            $correctAnswer = Crypt::decryptString($token);
            
            $isValid = (string)$userAnswer === (string)$correctAnswer;
            
            Log::info('Validación de CAPTCHA', [
                'user_answer' => $userAnswer,
                'correct_answer' => $correctAnswer,
                'is_valid' => $isValid
            ]);
            
            return response()->json(['valid' => $isValid]);
            
        } catch (\Exception $e) {
            Log::error('Error al validar CAPTCHA', [
                'error' => $e->getMessage()
            ]);
            
            return response()->json(['valid' => false, 'error' => 'Error en validación']);
        }
    }
}