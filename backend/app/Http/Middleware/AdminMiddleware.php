<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Se espera una cabecera HTTP:
        // X-ROLE: admin
        $rol = $request->header('X-ROLE');

        if ($rol !== 'admin') {
            return response()->json([
                'error' => 'Acceso denegado. Solo administradores.'
            ], 403);
        }

        return $next($request);
    }
}
