<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Lodis;


class CheckAlerts
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $alertas = [];

        // TODO: alertas

        // eliminar mensajes repetidos
        $alertas = collect($alertas)->unique('mensaje')->values()->all();

        session()->flash('alertas', $alertas);

        return $next($request);
    }
}
