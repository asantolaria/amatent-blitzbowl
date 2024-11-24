<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CoachFeature;

class CoachFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            ['name' => 'Entrenamiento Mágico', 'description' => 'Antes de que un jugador de tu equipo que se encuentre en el campo realice una acción de Correr, Placaje o Pase, puedes elegir a otro jugador de tu equipo que se encuentre en el campo o el Banquillo. Hasta el final de la acción, estos jugadores intercambian las habilidades en sus cartas (por ejemplo, Manos Seguras o Mole Brutal).', 'result' => 2],
            ['name' => 'Kit Patrocinado', 'description' => 'Tras realizar un chequeo de Armadura, puedes elegir repetir la tirada.', 'result' => 3],
            ['name' => 'Aspecto Amenazador', 'description' => 'Antes de que un rival realice una acción de Placaje, tira 1D8: con un resultado de 6+, el rival debe realizar una ación de Esquiva en su lugar. Si no es posible, no puede realizar ninguna otra acción durante este turno', 'result' => 4],
            ['name' => 'Sobornar al Árbitro', 'description' => 'Empiezas el partido con 1 punto, en lugar de 0', 'result' => 5],
            ['name' => 'Estallido Final', 'description' => 'Durante tu último turno, si tu equipo tiene menos puntos que el rival, puedes barajar las cartas de Desafío Final que no fueran usadas en el mazo de Desafíos de este encuentro, robar una y colocarla frente a ti. Puede ser reclamada por tu equipo durante este turno. Si no es reclamada, se descarta.', 'result' => 6],
            ['name' => 'Incentivador', 'description' => 'Cuando tu equipo realice una acción gratuita, tira 1D8: con un resultado de 8, realiza una acción gratuita con otro jugador.', 'result' => 7],
            ['name' => 'Celebrador Ruidoso', 'description' => 'Cuando tu equipo anote un touchdown, ganas 5 puntos en lugar de 4', 'result' => 8],
            ['name' => 'Bien Preparado', 'description' => 'Puedes elegir en qué trampilla se coloca el balón en lugar de hacerse al azar. Si ambos entrenadores tienen este rasgo y desean usarlo a la vez, cada uno tira 1D8, repitiendo empates. Aquel que obtenga el resultado más alto elige en qué trampilla se coloca el balón.', 'result' => 9],
            ['name' => 'Buscador de Gloria', 'description' => 'Tu equipo gana 3 puntos al Barrer con Todo en lugar de 2.', 'result' => 10],
            ['name' => 'Dedos Ligeros', 'description' => 'Este rasgo se usa al principio del partido y dura hasta el final del mismo. Puedes tener 4 cartas de Desafío en la mano en lugar de 3 antes de tener que descartar ninguna.', 'result' => 11],
            ['name' => 'Reputación Terrorífica', 'description' => 'Para una victoria por Muerte Súbida, el equipo rival debe superar tu marcador po 11 puntos en lugar de 10.', 'result' => 12],
            ['name' => 'Sonrisa Cegadora', 'description' => 'Cuando un rival sea elegido para realizar una acción gratuita, puedes tirar 1D6. Con un resultado de 3+, la acción gratuita no puede ser realizada por ese jugador rival.', 'result' => 13],
            ['name' => 'Inicio Ventajoso', 'description' => 'Cuando despliegues a tu equipo al inicio del partido, un jugador de tu equipo puede colocarse en cualquier casilla adyacente a una de las casillas de tu Zona de Anotación', 'result' => 14],
            ['name' => 'Presencia Inspiradora', 'description' => 'Después de que un jugador de tu equipo realice una acción de Placaje, puedes elegir repetir la tirada.', 'result' => 15],
            ['name' => 'Trampa Indignante', 'description' => 'Cuando un rival reclame una carta de Desafío, puedes elegir tirar 1D8. Si el resultado de la tirada es un 8, tú reclamas la carta en lugar del entrenador rival.', 'result' => 16],
        ];

        foreach ($features as $feature) {
            CoachFeature::create($feature);
        }
    }
}
