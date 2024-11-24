<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\League;
use App\Models\Game;
use App\Models\CoachFeature;

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
        $games = $this->games()->get();
        $gamesWon = [];
        foreach ($games as $game) {
            if ($game->winner() && $game->winner()->first()->id == $this->id) {
                $gamesWon[] = $game;
            }
        }
        return $gamesWon;
    }

    // Partidos empatados
    public function gamesDrawn()
    {
        $games = $this->games()->get();
        $gamesDrawn = [];
        foreach ($games as $game) {
            if ($game->winner() == null) {
                $gamesDrawn[] = $game;
            }
        }
        return $gamesDrawn;
    }

    // Partidos perdidos
    public function gamesLost()
    {
        $games = $this->games()->get();
        $gamesLost = [];
        foreach ($games as $game) {
            if ($game->loser() && $game->loser()->first()->id == $this->id) {
                $gamesLost[] = $game;
            }
        }
        return $gamesLost;
    }

    public function coachFeatures()
    {
        return $this->belongsToMany(CoachFeature::class, 'coach_feature_team')
            ->withTimestamps();
    }
}
