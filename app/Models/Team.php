<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['league_id', 'coach_name', 'name', 'race', 'played', 'won', 'drawn', 'lost'];

    // Relación inversa: un equipo pertenece a una liga
    public function league()
    {
        return $this->belongsTo(League::class);
    }
}
