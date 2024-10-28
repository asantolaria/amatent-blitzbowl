<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'season_year', 'enabled'];

    // Relación uno a muchos: una liga tiene muchos equipos
    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    // Relación uno a muchos: una liga tiene muchas jornadas
    public function matchdays()
    {
        return $this->hasMany(Matchday::class);
    }
}
