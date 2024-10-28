<?php

namespace App\Http\Middleware;

use App\Models\Liga;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarPertenenciaLiga
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // comprobar si el usuario actual es administrador
        if (auth()->user()->admin) {
            return $next($request);
        }



        $ligaId = $request->route('liga')->id;

        $liga = Liga::find($ligaId);
        $lodisLiga = $liga->lodis()->get();

        $lodisUsuario = auth()->user()->lodis()->get();

        // si una lodis de un usuario está en la LodisLiga, entonces el usuario pertenece a la liga
        $found = false;

        foreach ($lodisUsuario as $lodiUsuario) {
            foreach ($lodisLiga as $lodiLiga) {
                if ($lodiUsuario->id == $lodiLiga->id) {
                    $found = true;
                }
                if ($found) {
                    break;
                }
            }
            if ($found) {
                break;
            }
        }

        if (!$found) {
            return redirect()->back()->with('error', 'No tienes permiso para acceder a esta liga.');
        }

        return $next($request);
    }
}
