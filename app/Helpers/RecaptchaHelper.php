<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaHelper
{
    public static function verify($response)
    {
        if (empty($response)) {
            return false;
        }

        try {
            $secretKey = config('services.recaptcha.secret_key');
            
            $verifyResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $response,
                'remoteip' => request()->ip()
            ]);

            $responseData = $verifyResponse->json();
            
            Log::info('reCAPTCHA verification', [
                'success' => $responseData['success'] ?? false,
                'errors' => $responseData['error-codes'] ?? []
            ]);

            return $responseData['success'] ?? false;
            
        } catch (\Exception $e) {
            Log::error('reCAPTCHA verification error', [
                'message' => $e->getMessage()
            ]);
            
            return false;
        }
    }
}