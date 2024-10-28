<?php

namespace App\Utils;

use App\Models\Gladiador;
use App\Models\Subasta;
use Carbon\Carbon;

class FinalizarSubastas
{
    public static function finalizarSubasta(Subasta $subastaActual)
    {
        // comprobar pujas
        $gladiadores = $subastaActual->gladiadores()->get();
        foreach ($gladiadores as $gladiador) {

            // carga la última lodis que ha pujado por el gladiador, si es que alguna ha pujado
            if (!is_null($gladiador->puja_lodis)) {
                FinalizarPujas::finalizarPuja($gladiador);
            }
        }


        // Eliminar gladiadores que no tengan lodis_id
        $gladiadoresSinLodis = Gladiador::whereNull('lodis_id')->get();
        foreach ($gladiadoresSinLodis as $gladiador) {
            // desvincular la relación con la subasta
            $gladiador->subastas()->detach();
            $gladiador->delete();
        }

        $subastaActual->fecha_fin = Carbon::now('Europe/Madrid');
        $subastaActual->completada = true;
        $subastaActual->save();

        EnviarPush::enviarMensaje('Subasta finalizada', 'La subasta ha finalizado. Comprueba las novedades de tu Lodis.');
    }
}
