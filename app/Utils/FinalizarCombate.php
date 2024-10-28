<?php

namespace App\Utils;

use App\Models\Gladiador;
use App\Models\Lodis;
use App\Models\Combate;
use App\Models\ContabilidadLodis;
use App\Models\ExperienciaGladiador;
use Illuminate\Http\Request;

class FinalizarCombate
{

    public static function guardarCombate(Request $request, Combate $combate)
    {
        $fillableFields = $combate->getFillable();

        foreach ($request->input() as $key => $value) {
            if (in_array($key, $fillableFields)) {
                if (is_numeric($value))
                    $combate->$key = intval($value);
                if ($value == "on")
                    $combate->$key = 1;
            }
        }
        $combate->save();
        return $combate;
    }

    public static function lodisVencedora($lodis_1_id, $lodis_2_id, $puntosLodis1, $puntosLodis2, Combate $registro_combate)
    {
        $lodis1 = Lodis::find($lodis_1_id);
        $lodis2 = Lodis::find($lodis_2_id);

        $lodisGanadora = 0;

        if ($puntosLodis1 > $puntosLodis2) {
            $lodisGanadora = 1;

            $registro_combate->lodis_vencedora = $lodis1->id;
            $registro_combate->empate = 0;
            $registro_combate->save();
        } else if ($puntosLodis1 < $puntosLodis2) {
            $lodisGanadora = 2;

            $registro_combate->lodis_vencedora = $lodis2->id;
            $registro_combate->empate = 0;
            $registro_combate->save();
        } else {
            $lodisGanadora = 0;

            $registro_combate->empate = 1;
            $registro_combate->save();
        }

        return $lodisGanadora;
    }

    public static function experienciaGladiador($glid, $lodisGanadora, Combate $registro_combate, $esta_muerto)
    {
        $gladiador = Gladiador::find($glid);

        $puntosGanados = 0;
        if ($lodisGanadora == 1) {
            $puntosGanados = 2;
        } else {
            $puntosGanados = 1;
        }

        $experienciaGladiador = new ExperienciaGladiador();
        if ($esta_muerto) {
            $experienciaGladiador->muerto = 1;
            $puntosGanados = 0;
        } else {
            $experienciaGladiador->muerto = 0;
        }
        $experienciaGladiador->combate()->associate($registro_combate);
        $experienciaGladiador->gladiador()->associate($gladiador);

        $experienciaGladiador->experiencia = $puntosGanados;

        // Calcular nivel
        $nivelanterior = $gladiador->nivel;
        $nivelactual = floor($gladiador->experiencia / 5);

        // $experienciaGladiador->nivel = $nivelactual;

        // $gladiador->nivel = $nivelactual;
        if ($nivelanterior < $nivelactual) {

            $dif = $nivelactual - $nivelanterior;

            // Tirada de dados. Se asume que solo se sube un nivel.
            $resultadoDado = rand(1, 10);
            $experienciaGladiador->resultado_subida_nivel = $resultadoDado;
        }

        $experienciaGladiador->save();

        return $experienciaGladiador;
    }

    public static function heridasGladiador($glid, $lesiones, ExperienciaGladiador $experienciaGladiador)
    {
        $numeroAleatorio = rand(1, 100);

        $experienciaGladiador->resultado_tirada_heridas = $numeroAleatorio;

        // Buscar la lesión correspondiente al número aleatorio generado
        $lesionAleatoria = null;
        foreach ($lesiones as $lesion) {
            if ($numeroAleatorio >= $lesion->resultado_minimo && $numeroAleatorio <= $lesion->resultado_maximo) {
                $lesionAleatoria = $lesion;
                break;
            }
        }

        if ($lesionAleatoria) {
            $experienciaGladiador->lesion()->associate($lesionAleatoria);
            $experienciaGladiador->save();
        } else {
            // ERROR: no se ha encontrado lesión aleatoria. El número obtenido ha sido $numeroAleatorio
        }
    }

    public static function calcularFamaGladiador($tipoArena)
    {
        // TODO: pendiente de definir como se calcula la fama de un gladiador";
    }

    public static function calcularFamaLodis($lodis, $tipoArena, $numeroGladiadores, Combate $registro_combate)
    {
        $puntosPorGladiador = $numeroGladiadores * $tipoArena->dinero_por_gladiador;

        $puntosPorNivelFama = $lodis->nivel_fama * $tipoArena->dinero_por_fama;
        if ($puntosPorNivelFama > $tipoArena->limite_por_fama) {
            $puntosPorNivelFama = $tipoArena->limite_por_fama;
        }

        $total = $tipoArena->dinero_contrato + $puntosPorGladiador + $puntosPorNivelFama;

        $registro_combate->puntos_fama = $total;


        // Crear contabilidad y obtener el id
        $contabilidad = new ContabilidadLodis();
        $contabilidad->dinero = $total;
        $contabilidad->concepto = 'Cobro por combate. Registro combate: ' . $registro_combate->id;
        $contabilidad->lodis_id = $lodis->id;
        $contabilidad->combate_id = $registro_combate->id;
        $contabilidad->save();
    }

    public static function generarRegistroCombate($combate)
    {
        // TODO: pensar como generar un registro de combate
    }
}
