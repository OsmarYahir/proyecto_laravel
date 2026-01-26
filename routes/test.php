<?php
// Crea este archivo: routes/test.php (temporal para debugging)
// O agrega esto al final de routes/web.php

Route::get('/test-captcha', function() {
    try {
        // Test 1: Verificar que Crypt funciona
        $testValue = "123";
        $encrypted = \Illuminate\Support\Facades\Crypt::encryptString($testValue);
        $decrypted = \Illuminate\Support\Facades\Crypt::decryptString($encrypted);
        
        // Test 2: Generar CAPTCHA
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        $result = $num1 + $num2;
        $token = \Illuminate\Support\Facades\Crypt::encryptString((string)$result);
        
        return response()->json([
            'test_encryption' => [
                'original' => $testValue,
                'decrypted' => $decrypted,
                'success' => $testValue === $decrypted
            ],
            'captcha_generation' => [
                'question' => "$num1 + $num2 = ?",
                'answer' => $result,
                'token_length' => strlen($token),
                'success' => true
            ],
            'app_key_exists' => !empty(config('app.key')),
            'app_key_length' => strlen(config('app.key')),
            'overall_status' => 'OK'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});