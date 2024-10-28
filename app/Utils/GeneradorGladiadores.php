<?php

namespace App\Utils;

use App\Models\Gladiador;
use App\Models\CategoriaGladiador;

class GeneradorGladiadores
{
    public static function generarGladiadorAleatorio($categoria, $save = true)
    {
        // $puntos_categoria = GeneradorGladiadores::obtenerPuntosPorCategoria($categoria);
        $categoriaObjeto = CategoriaGladiador::where('categoria', $categoria)->first();

        // El id 1 de la tabla de usuarios está reservado para el admin
        $admin_id = 1;
        $gladiadores = array();
        $gladiador = new Gladiador([
            'nombre' => GeneradorGladiadores::generarNombreGladiador(),
            'propietario_id' => $admin_id,
            'nivel' => 1,
            'categoria' => $categoriaObjeto->categoria,
            'puntos' => $categoriaObjeto->puntos,
            'precio_venta' => $categoriaObjeto->precio_venta,
            'precio_subasta' => $categoriaObjeto->precio_subasta,
            // 'velocidad' => 1,
            // 'fuerza' => 1, 
            // 'destreza' => 1, 
            // 'iniciativa' => 1, 
            // 'dureza' => 1, 
            // 'resistencia' => 1, 
            // 'inteligencia' => 1, 
            // 'sabiduria' => 1, 
            // 'carisma' => 1, 
            // 'puntos_sin_asignar' => 1,
        ]);
        $gladiador->velocidad = 1;
        $gladiador->fuerza = 1;
        $gladiador->destreza = 1;
        $gladiador->iniciativa = 1;
        $gladiador->dureza = 1;
        $gladiador->resistencia = 1;
        $gladiador->inteligencia = 1;

        $gladiador->sabiduria = 1;
        $gladiador->carisma = 1;
        $gladiador->puntos_sin_asignar = 0;
        $gladiador->muertes_provocadas = 0;
        $gladiador->heridas_provocadas = 0;
        // TEST
        // $gladiador->puntos_sin_asignar = 10;
        // $gladiador->puntos_sin_asignar_tipo = '*';
        // $gladiador->puntos_aprendizaje_sin_asignar = 10;

        // Añadir atributos aleatorios
        $puntos_restantes = $categoriaObjeto->puntos;

        // Se tiran tantos dados de 10 como puntos por categoría
        $atributos = ['velocidad', 'fuerza', 'destreza', 'iniciativa', 'dureza', 'resistencia', 'inteligencia', 'sabiduria', 'carisma', 'puntos_sin_asignar'];
        /*
            1 -> +1 a la Velocidad
            2 -> +1 a la Fuerza
            3 -> +1 a la Destreza
            4 -> +1 a la Iniciativa
            5 -> +1 a la Dureza
            6 -> +1 a la Resistencia
            7 -> +1 a la Inteligencia
            8 -> +1 a la Sabiduría
            9 -> +1 a la Carisma
            10 -> A elegir por el comprador
        */
        for ($i = 0; $i < $categoriaObjeto->puntos; $i++) {
            $valor = rand(1, 10);
            switch ($valor) {
                case 1:
                    $gladiador->velocidad += 1;
                    break;
                case 2:
                    $gladiador->fuerza += 1;
                    break;
                case 3:
                    $gladiador->destreza += 1;
                    break;
                case 4:
                    $gladiador->iniciativa += 1;
                    break;
                case 5:
                    $gladiador->dureza += 1;
                    break;
                case 6:
                    $gladiador->resistencia += 1;
                    break;
                case 7:
                    $gladiador->inteligencia += 1;
                    break;
                case 8:
                    $gladiador->sabiduria += 1;
                    break;
                case 9:
                    $gladiador->carisma += 1;
                    break;
                case 10:
                    $gladiador->puntos_sin_asignar += 1;
                    break;
            }
        }


        if ($save) {
            $gladiador->save();
        }

        // Asignar un arma aleatoria al gladiador
        // $armaAleatoria = Armamento::inRandomOrder()->first();
        // $ubicaciones = ['brazo_derecho', 'brazo_izquierdo', 'repuesto'];
        // $ubicacionAleatoria = $ubicaciones[rand(0,2)];
        // $gladiador = GeneradorGladiadores::asignar_armamento_gladiador($gladiador->id, $armaAleatoria->id, $ubicacionAleatoria);

        // Asignar una armadura aleatoria al gladiador
        // $armaduraAleatoria = Armadura::inRandomOrder()->first();
        // $ubicacionesArmadura = ['cabeza', 'torso', 'brazo_derecho', 'brazo_izquierdo', 'pierna_izquierda', 'pierna_derecha'];
        // $ubicacionArmaduraAleatoria = $ubicacionesArmadura[rand(0,5)];
        // $gladiador = GeneradorGladiadores::asignar_armadura_gladiador($gladiador->id, $armaduraAleatoria->id, $ubicacionArmaduraAleatoria);

        // // Asignar una habilidad
        // $habilidadAleatoria = Habilidad::inRandomOrder()->first();
        // $gladiador = GeneradorGladiadores::asignar_habilidad_gladiador($gladiador->id, $habilidadAleatoria->id);

        // // Asignar un hechizo
        // $hechizoAleatorio = Hechizo::inRandomOrder()->first();
        // $gladiador = GeneradorGladiadores::asignar_hechizo_gladiador($gladiador->id, $hechizoAleatorio->id);

        // // Asignar una lesion
        // $lesionAleatoria = Lesion::inRandomOrder()->first();
        // $gladiador = GeneradorGladiadores::asignar_lesion_gladiador($gladiador->id, $lesionAleatoria->id);

        // // Asignar un objeto de inventario
        // $objetoAleatorio = Habilidad::inRandomOrder()->first();
        // $gladiador = GeneradorGladiadores::asignar_objeto_inventario_gladiador($gladiador->id, $objetoAleatorio->id);

        return $gladiador;
    }

    public static function generarNombreGladiador()
    {
        $nombres = [
            'James', 'Oliver', 'Liam', 'Benjamin', 'Lucas', 'Mason', 'Ethan', 'Alexander', 'Henry', 'Sebastian',
            'Elijah', 'Matthew', 'Samuel', 'David', 'Joseph', 'Daniel', 'William', 'Thomas', 'Charles', 'Edward',
            'Louis', 'Gabriel', 'Raphael', 'Antoine', 'Luc', 'Theo', 'Pierre', 'Julien', 'Hugo', 'Nathan',
            'Nicolas', 'Alexandre', 'Lucas', 'Mathieu', 'Simon', 'Jean', 'Paul', 'Ivan', 'Dmitri', 'Alexei',
            'Nikolai', 'Mikhail', 'Sergei', 'Vladimir', 'Yuri', 'Roman', 'Andrei', 'Boris', 'Oleg', 'Hans',
            'Karl', 'Friedrich', 'Heinrich', 'Otto', 'Franz', 'Erich', 'Johann', 'Gustav', 'Lukas', 'Hiroshi',
            'Yuki', 'Haruto', 'Riku', 'Kaito', 'Ren', 'Sota', 'Yuma', 'Ryota', 'Kenta', 'Takumi',
            'Dimitris', 'Nikos', 'Georgios', 'Konstantinos', 'Vasilis', 'Christos', 'Panagiotis', 'Ioannis', 'Stavros', 'Andreas',
            'Noah', 'Jack', 'Logan', 'Caleb', 'Nathaniel', 'Isaac', 'Julian', 'Christian', 'Hunter', 'Adam',
            'Zachary', 'Evan', 'Connor', 'Aaron', 'Adrian', 'Cameron', 'Aidan', 'Tyler', 'Brandon', 'Jason',
            'Kevin', 'Ryan', 'Brian', 'Eric', 'Patrick', 'Cole', 'Jordan', 'Sean', 'Cody', 'Brayden',
            'Wyatt', 'Elias', 'Finn', 'Gavin', 'Asher', 'Leo', 'Dominic', 'Miles', 'Micah', 'Colton',
            'Declan', 'Ezra', 'Nolan', 'Ryder', 'Jace', 'Parker', 'Kayden', 'Blake', 'Ayden', 'Riley',
            'Diego', 'Bentley', 'Justin', 'Lucas', 'Matthew', 'Isaiah', 'Andrew', 'Joshua', 'Christopher', 'Nicholas',
            'Thomas', 'Jonathan', 'Joseph', 'Anthony', 'Charles', 'Daniel', 'Alexander', 'Matthew', 'William', 'Michael',
            'James', 'Robert', 'David', 'John', 'Richard', 'Christopher', 'Mark', 'Steven', 'Paul', 'Andrew'
        ];

        $apellidos = [
            'Valiente', 'Audaz', 'Feroz', 'Noble', 'Astuto', 'Brillante', 'Tenaz', 'Implacable', 'Invicto', 'Furioso',
            'Valeroso', 'Solemne', 'Eterno', 'Glorioso', 'Majestuoso', 'Imperial', 'Letal', 'Terrible', 'Impetuoso', 'Salvaje',
            'Fiero', 'Gigante', 'Inquebrantable', 'Intrépido', 'Magnífico', 'Estratega', 'Leal', 'Victorioso', 'Resistente', 'Intrépido',
            'Poderoso', 'Intenso', 'Cauteloso', 'Imparable', 'Terrorífico', 'Despiadado', 'Intrépido', 'Épico', 'Formidable', 'Temerario',
            'Indomable', 'Eficaz', 'Tenebroso', 'Astuto', 'Rápido', 'Voraz', 'Aguerrido', 'Sombra', 'Sangriento', 'Infernal',
            'Voraz', 'Ardiente', 'Inexorable', 'Inmortal', 'Lúgubre', 'Funesto', 'Invencible', 'Desgarrador', 'Tremendo', 'Mítico',
            'Silencioso', 'Espectacular', 'Legendario', 'Inconmensurable', 'Devastador', 'Oscuro', 'Vengativo', 'Impetuoso', 'Fatal', 'Ardiente',
            'Impresionante', 'Colosal', 'Veloz', 'Resplandeciente', 'Trágico', 'Impresionante', 'Asombroso', 'Resplandeciente', 'Fulminante', 'Espectacular',
            'Increíble', 'Maravilloso', 'Grandioso', 'Majestuoso', 'Increíble', 'Resistente', 'Furibundo', 'Furioso', 'Espectacular', 'Legendario',
            'Veloz', 'Feroz', 'Cauto', 'Brillante', 'Radiante', 'Fulgurante', 'Dinamico', 'Sorprendente', 'Atrevido', 'Implacable',
            'Determinado', 'Indestructible', 'Arrogante', 'Indomito', 'Intrépido', 'Astuto', 'Ingenioso', 'Cauto', 'Resoluto', 'Inflexible',
            'Imperioso', 'Resiliente', 'Intrepido', 'Indomable', 'Increible', 'Sorprendente', 'Formidable', 'Gigantesco', 'Colosal', 'Gigante',
            'Fabuloso', 'Fantástico', 'Sorprendente', 'Extraordinario', 'Alucinante', 'Estupendo', 'Maravilloso', 'Fenomenal', 'Asombroso', 'Espectacular',
            'Impresionante', 'Magnifico', 'Descomunal', 'Grandioso', 'Esplendido', 'Estupendo', 'Descomunal', 'Esplendido', 'Espectacular', 'Impresionante',
            'Colosal', 'Grandioso', 'Majestuoso', 'Imponente', 'Soberbio', 'Excepcional', 'Admirable', 'Deslumbrante', 'Encantador', 'Glorioso',
            'Espectacular', 'Magnifico', 'Esplendido', 'Fenomenal', 'Extraordinario', 'Admirable', 'Fascinante', 'Maravilloso', 'Sorprendente', 'Impresionante'
        ];


        $nombre = $nombres[array_rand($nombres)];
        $apellido = $apellidos[array_rand($apellidos)];

        return $nombre . ' el ' . $apellido;
    }

    public static function asignar_armamento_gladiador($gladiadorId, $armamentoId, $ubicacion)
    {
        $gladiador = Gladiador::find($gladiadorId);

        if ($gladiador) {
            // Verifica si el gladiador ya tiene asignado este armamento
            $armamentoExistente = $gladiador->armamentos()->where('armamento_id', $armamentoId)->first();

            if (!$armamentoExistente) {
                // Si no tiene asignado el armamento, puedes hacerlo
                $gladiador->armamentos()->attach($armamentoId, ['ubicacion' => $ubicacion]);
                // echo "Armamento asignado correctamente al gladiador.";
            } else {
                echo "El gladiador ya tiene asignado este armamento.";
            }
        } else {
            echo "Gladiador no encontrado.";
        }
        return $gladiador;
    }

    public static function asignar_armadura_gladiador($gladiadorId, $armaduraId, $ubicacion)
    {
        $gladiador = Gladiador::find($gladiadorId);

        if ($gladiador) {
            // Verifica si el gladiador ya tiene asignado esta armadura
            $armaduraExistente = $gladiador->armaduras()->where('armadura_id', $armaduraId)->first();

            if (!$armaduraExistente) {
                // Si no tiene asignada la armadura, puedes hacerlo
                $gladiador->armaduras()->attach($armaduraId, ['ubicacion' => $ubicacion]);
                // echo "Armadura asignada correctamente al gladiador.";
            } else {
                echo "El gladiador ya tiene asignada esta armadura.";
            }
        } else {
            echo "Gladiador no encontrado.";
        }
        return $gladiador;
    }

    public static function asignar_habilidad_gladiador($gladiadorId, $habilidadId)
    {
        $gladiador = Gladiador::find($gladiadorId);

        if ($gladiador) {
            // Verifica si el gladiador ya tiene asignada esta habilidad
            $habilidadExistente = $gladiador->habilidades()->where('habilidad_id', $habilidadId)->first();

            if (!$habilidadExistente) {
                // Si no tiene asignada la habilidad, puedes hacerlo
                $gladiador->habilidades()->attach($habilidadId);
                // echo "Habilidad asignada correctamente al gladiador.";
            } else {
                echo "El gladiador ya tiene asignada esta habilidad.";
            }
        } else {
            echo "Gladiador no encontrado.";
        }

        return $gladiador;
    }

    public static function asignar_hechizo_gladiador($gladiadorId, $hechizoId)
    {
        $gladiador = Gladiador::find($gladiadorId);

        if ($gladiador) {
            // Verifica si el gladiador ya tiene asignado este hechizo
            $hechizoExistente = $gladiador->hechizos()->where('hechizo_id', $hechizoId)->first();

            if (!$hechizoExistente) {
                // Si no tiene asignado el hechizo, puedes hacerlo
                $gladiador->hechizos()->attach($hechizoId);
                // echo "Hechizo asignado correctamente al gladiador.";
            } else {
                echo "El gladiador ya tiene asignado este hechizo.";
            }
        } else {
            echo "Gladiador no encontrado.";
        }

        return $gladiador;
    }

    public static function asignar_lesion_gladiador($gladiadorId, $lesionId)
    {
        $gladiador = Gladiador::find($gladiadorId);

        if ($gladiador) {
            // Verifica si el gladiador ya tiene asignada esta lesión
            $lesionExistente = $gladiador->lesiones()->where('lesion_id', $lesionId)->first();

            if (!$lesionExistente) {
                // Si no tiene asignada la lesión, puedes hacerlo
                $gladiador->lesiones()->attach($lesionId);
                // echo "Lesión asignada correctamente al gladiador.";
            } else {
                echo "El gladiador ya tiene asignada esta lesión.";
            }
        } else {
            echo "Gladiador no encontrado.";
        }

        return $gladiador;
    }

    public static function asignar_objeto_inventario_gladiador($gladiadorId, $objetoInventarioId)
    {
        $gladiador = Gladiador::find($gladiadorId);

        if ($gladiador) {
            // Verifica si el gladiador ya tiene asignado este objeto de inventario
            $objetoInventarioExistente = $gladiador->inventario()->where('objeto_inventario_id', $objetoInventarioId)->first();

            if (!$objetoInventarioExistente) {
                // Si no tiene asignado el objeto de inventario, puedes hacerlo
                $gladiador->inventario()->attach($objetoInventarioId);
                // echo "Objeto de inventario asignado correctamente al gladiador.";
            } else {
                echo "El gladiador ya tiene asignado este objeto de inventario.";
            }
        } else {
            echo "Gladiador no encontrado.";
        }

        return $gladiador;
    }


    // public static function obtenerPuntosPorCategoria($categoria)
    // {
    //     // Definir puntos por categoría
    //     $puntosPorCategoria = [
    //         1 => 18,
    //         2 => 15,
    //         3 => 12,
    //         4 => 8,
    //     ];

    //     // Verificar si la categoría existe
    //     if (array_key_exists($categoria, $puntosPorCategoria)) {
    //         return $puntosPorCategoria[$categoria];
    //     }

    //     // Devolver un valor por defecto o manejar el error según tus necesidades
    //     return 0;
    // }

}
