<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\League;

class LeagueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        League::create([
            'name' => 'Amatent-Blitzbowl',
            'description' => 'Liga oficial de Blitzbowl organizada por Amatent.',
            'season_year' => 2024,
            'enabled' => true
        ]);
    }
}
