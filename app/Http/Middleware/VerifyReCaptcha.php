<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class VerifyReCaptcha
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->has('g-recaptcha-token')) {
            return response()->json(['error' => 'ReCAPTCHA token is required'], 422);
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-token'),
            'remoteip' => $request->ip()
        ]);

        if (!$response->successful() || !$response->json('success')) {
            return response()->json(['error' => 'Invalid ReCAPTCHA token'], 422);
        }

        // Optional: Check score for v3
        $score = $response->json('score');
        if ($score !== null && $score < 0.5) { // Adjust threshold as needed
            return response()->json(['error' => 'ReCAPTCHA score too low'], 422);
        }

        return $next($request);
    }
} 