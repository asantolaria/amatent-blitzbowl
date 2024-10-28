<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['matchday_id', 'team_a_id', 'team_b_id', 'touchdowns_a', 'touchdowns_b', 'injuries_a', 'injuries_b', 'cards_a', 'cards_b', 'score_a', 'score_b'];


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

    // Winner
    public function winner()
    {
        if ($this->score_a > $this->score_b) {
            return $this->teamA();
        } elseif ($this->score_a < $this->score_b) {
            return $this->teamB();
        } else {
            return null;
        }
    }

    // Loser
    public function loser()
    {
        if ($this->score_a > $this->score_b) {
            return $this->teamB;
        } elseif ($this->score_a < $this->score_b) {
            return $this->teamA;
        } else {
            return null;
        }
    }
}
