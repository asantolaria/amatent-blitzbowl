<?php

namespace App\Utils;

use App\Models\Combate;
use App\Models\Gladiador;


class PreparacionCombate
{
    public static function prepararCombate(Combate $combate_in)
    {
        $combate = Combate::with('gladiadores.lodis')->find($combate_in->id);

        $lodis1 = null;
        $lodis2 = null;
        foreach ($combate->gladiadores as $gladiador) {
            $lodis[] = $gladiador->lodis;
        }
        $arraySinDuplicados = [];
        foreach ($lodis as $element) {
            if (!in_array($element, $arraySinDuplicados)) {
                $arraySinDuplicados[] = $element;
            }
        }
        $lodis1 = $arraySinDuplicados[0];
        $lodis2 = $arraySinDuplicados[1];


        $gladiadores_lodis_1 = [];
        $gladiadores_lodis_2 = [];
        foreach ($combate->gladiadores as $gladiador) {
            if ($gladiador->lodis->id == $lodis1->id) {
                $gladiadores_lodis_1[] = $gladiador;
            } else if ($gladiador->lodis->id == $lodis2->id) {
                $gladiadores_lodis_2[] = $gladiador;
            } else {
                dd("ERROR, el gladiador no pertenece a ninguna de las 2 lodis conocidas");
            }
        }

        $combate_custom['id'] = $combate->id;
        $combate_custom['tipo'] = $combate->tipo;
        $combate_custom['fecha'] = $combate->created_at;
        $combate_custom['completado'] = $combate->completado;
        $combate_custom['lodis_vencedora'] = $combate->lodis_vencedora;
        $combate_custom['empate'] = $combate->empate;
        $combate_custom['lodis_1'] = $lodis1;
        $combate_custom['lodis_2'] = $lodis2;
        $combate_custom['gladiadores_lodis_1'] = $gladiadores_lodis_1;
        $combate_custom['gladiadores_lodis_2'] = $gladiadores_lodis_2;

        return $combate_custom;
    }
}
