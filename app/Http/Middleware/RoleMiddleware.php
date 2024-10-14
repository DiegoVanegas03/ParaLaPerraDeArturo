<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check() || !in_array(Auth::user()->rol, $roles)) {
            // Redirigir o mostrar un error si el rol no coincide
            return redirect('/')->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        return $next($request);
    }
}
