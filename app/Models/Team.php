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

    // Partidos jugados
    public function games()
    {
        return $this->hasMany(Game::class, 'team_a_id')->orWhere('team_b_id', $this->id);
    }

    // Partidos ganados
    public function gamesWon()
    {
        return $this->games->where('winner_id', $this->id);
    }

    // Partidos empatados
    public function gamesDrawn()
    {
        return $this->games->where('winner_id', null)->where('touchdowns_a', '>', 0);
    }
}
