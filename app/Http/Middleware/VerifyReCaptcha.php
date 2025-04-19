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
            return response()->json(['message' => 'ReCaptcha token is required'], 400);
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-token'),
            'remoteip' => $request->ip()
        ]);

        if (!$response->successful() || !$response->json('success')) {
            return response()->json(['message' => 'Invalid ReCaptcha token'], 400);
        }

        // Check score if needed (0.0 - 1.0, 1.0 being very likely a good interaction)
        if ($response->json('score') < 0.5) {
            return response()->json(['message' => 'Suspicious activity detected'], 400);
        }

        return $next($request);
    }
} 