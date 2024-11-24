<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachFeature extends Model
{
    use HasFactory;

    protected $fillable = ['result', 'name', 'description'];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'coach_feature_team')
            ->withTimestamps();
    }
}
