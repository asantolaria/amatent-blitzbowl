<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matchday extends Model
{
    use HasFactory;

    protected $fillable = ['league_id', 'date', 'description', 'round_number'];

    // Relación inversa: una jornada pertenece a una liga
    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function next()
    {
        $output = Matchday::where('league_id', $this->league_id)
            ->where('date', '>', $this->date)
            ->orderBy('date', 'asc')
            ->first();

        if ($output) {
            return $output;
        } else {
            return null;
        }
    }

    public function previous()
    {
        $output = Matchday::where('league_id', $this->league_id)
            ->where('date', '<', $this->date)
            ->orderBy('date', 'desc')
            ->first();

        if ($output) {
            return $output;
        } else {
            return null;
        }
    }
}
