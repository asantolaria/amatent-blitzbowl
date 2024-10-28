<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Coach;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            ['coach_name' => 'Maria Rosa', 'team_name' => 'Lagartones', 'race' => 'Hombres lagarto'],
            ['coach_name' => 'Ariadkas', 'team_name' => 'Tigres de Nagaroth', 'race' => 'Elfos oscuros'],
            ['coach_name' => 'Andres', 'team_name' => 'Pies de Hierro', 'race' => 'Enanos'],
            ['coach_name' => 'Alex', 'team_name' => 'Bollichaos', 'race' => 'Elegidos del caos'],
            ['coach_name' => 'Danny', 'team_name' => 'NK Surfers', 'race' => 'Orcos negros'],
            ['coach_name' => 'Kaiden', 'team_name' => 'Marditos Roedores', 'race' => 'Skavens'],
        ];

        foreach ($teams as $teamData) {
            // Crea el equipo asociado con el entrenador
            Team::create([
                'coach_name' => $teamData['coach_name'],
                'name' => $teamData['team_name'],
                'race' => $teamData['race'],
                'league_id' => 1, // Ajusta según el ID de la liga si es necesario
            ]);
        }
    }
}
