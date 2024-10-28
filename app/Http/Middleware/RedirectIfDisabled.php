<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class RedirectIfDisabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->enabled === 0) {
            // borrar sesión
            Auth::logout();
            // redirigir a login con mensaje de error
            return redirect()->route('login')->with('error', 'Su cuenta está deshabilitada. Por favor, contacte al administrador.');
        }

        return $next($request);
    }
}
