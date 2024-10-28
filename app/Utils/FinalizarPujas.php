<?php

namespace App\Utils;

use App\Models\Gladiador;
use App\Models\Subasta;
use App\Models\ContabilidadLodis;
use App\Models\Lodis;

use Carbon\Carbon;

class FinalizarPujas
{
    public static function finalizarPuja(Gladiador $gladiador)
    {
        $lodis = Lodis::find($gladiador->puja_lodis);

        // asigna el gladiador a la lodis
        $lodis->gladiadores()->save($gladiador);
        $gladiador->puja_fecha_fin = null;
        $gladiador->puja_finalizada = True;
        $gladiador->save();


        ContabilidadLodis::create([
            'lodis_id' => $lodis->id,
            'dinero' => -$gladiador->precio_subasta,
            'concepto' => 'Subasta de gladiador ' . $gladiador->nombre,
            'fecha' => Carbon::now(),
        ]);

        $lodis->save();

        // mandar un mensaje diciendo que la lodis ha ganado al gladiador
        $nombre_lodis = $lodis->nombre;
        $nombre_gladiador = $gladiador->nombre;
        EnviarPush::enviarMensaje('Subasta Finalizada', 'La lodis ' . $nombre_lodis . ' ha ganado la subasta del gladiador ' . $nombre_gladiador);
    }

    public static function comprobarPujasFinalizadas(Subasta $subasta)
    {
        $gladiadores = $subasta->gladiadores()->get();
        foreach ($gladiadores as $gladiador) {
            // Si alguna de las pujas ha llegado a su fecha fin, proceder a finalizar la puja.
            if (
                !is_null($gladiador->puja_fecha_fin)
                && Carbon::parse($gladiador->puja_fecha_fin, 'Europe/madrid')->isPast()
                && $gladiador->puja_finalizada == false
            ) {

                // carga la última lodis que ha pujado por el gladiador, si es que alguna ha pujado
                if (!is_null($gladiador->puja_lodis)) {
                    FinalizarPujas::finalizarPuja($gladiador);
                }
            }
        }
    }
}
