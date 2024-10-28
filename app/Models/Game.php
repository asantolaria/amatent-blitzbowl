<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['matchday_id', 'team_a_id', 'team_b_id', 'score_a', 'score_b'];

    // Relación inversa: un partido pertenece a una jornada
    public function matchday()
    {
        return $this->belongsTo(Matchday::class);
    }

    // Relación con el equipo A
    public function teamA()
    {
        return $this->belongsTo(Team::class, 'team_a_id');
    }

    // Relación con el equipo B
    public function teamB()
    {
        return $this->belongsTo(Team::class, 'team_b_id');
    }
}
