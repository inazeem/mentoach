<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Inertia;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
            }
            
            if ($request->header('X-Inertia')) {
                return Inertia::render('Error/Forbidden', [
                    'status' => 403,
                    'message' => 'Unauthorized. Admin access required.'
                ])->toResponse($request)->setStatusCode(403);
            }
            
            return redirect()->route('dashboard')->with('error', 'Unauthorized. Admin access required.');
        }

        return $next($request);
    }
} 