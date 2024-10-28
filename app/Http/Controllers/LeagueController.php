<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\League;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    public function index()
    {
        $leagues = League::all();
        return view('leagues.index', compact('leagues'));
    }

    public function create()
    {
        return view('leagues.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|unique:leagues|max:255',
                'description' => 'required|string',
                'season_year' => 'required|integer',
            ]);

            League::create($request->all());
            return redirect()->route('leagues.index')->with('success', 'League created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('leagues.index')->with('error', 'Error creating league: ' . $e->getMessage());
        }
    }

    public function show(League $league)
    {
        $ranking = $this->ranking($league);
        return view('leagues.show', compact('league', 'ranking'));
    }

    public function edit(League $league)
    {
        return view('leagues.edit', compact('league'));
    }

    public function update(Request $request, League $league)
    {
        try {
            $request->validate([
                'name' => 'required|max:255|unique:leagues,name,' . $league->id,
                'description' => 'nullable',
                'season_year' => 'nullable|integer',
            ]);

            $league->update($request->all());
            return redirect()->route('leagues.index')->with('success', 'League updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('leagues.index')->with('error', 'Error updating league: ' . $e->getMessage());
        }
    }

    public function destroy(League $league)
    {
        try {
            $league->delete();
            return redirect()->route('leagues.index')->with('success', 'League deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('leagues.index')->with('error', 'Error deleting league: ' . $e->getMessage());
        }
    }

    public function enable(League $league)
    {
        try {
            $league->enabled = true;
            $league->save();
            return redirect()->route('leagues.index')->with('success', 'League enabled successfully.');
        } catch (\Exception $e) {
            return redirect()->route('leagues.index')->with('error', 'Error enabling league: ' . $e->getMessage());
        }
    }

    public function disable(League $league)
    {
        try {
            $league->enabled = false;
            $league->save();
            return redirect()->route('leagues.index')->with('success', 'League disabled successfully.');
        } catch (\Exception $e) {
            return redirect()->route('leagues.index')->with('error', 'Error disabling league: ' . $e->getMessage());
        }
    }

    public function ranking(League $league)
    {
        // Recoger todos los partidos jugados de las jornadas de la liga
        $matches = $league->matchdays()->with('games')->get()->pluck('games')->flatten();

        // Recoger todos los equipos de la liga
        $teams = $league->teams;

        // Crear un objeto con los equipos, partidos jugados, partidos ganados, partidos empatados, partidos perdidos, touchdowns, cartas, lesiones y puntuaciones
        $ranking = $teams->map(function ($team) use ($matches) {
            $team_matches = $matches->filter(function ($match) use ($team) {
                return $match->team_a_id == $team->id || $match->team_b_id == $team->id;
            });

            $team_wins = $team_matches->filter(function ($match) use ($team) {
                $winner = $match->winner();
                if ($winner) {
                    return $winner->first()->id == $team->id;
                }
            });


            $team_draws = $team_matches->filter(function ($match) use ($team) {
                $winner = $match->winner();
                $loser = $match->loser();
                if ($winner == null && $loser == null) {
                    return true;
                }
            });


            $team_losses = $team_matches->filter(function ($match) use ($team) {
                $loser = $match->loser();
                if ($loser) {
                    return $loser->first()->id == $team->id;
                }
            });

            $team_touchdowns = 0;
            $team_cards = 0;
            $team_injuries = 0;
            foreach ($team_matches as $match) {
                if ($match->team_a_id == $team->id) {
                    $team_touchdowns += $match->touchdowns_a;
                    $team_cards += $match->cards_a;
                    $team_injuries += $match->injuries_a;
                }

                if ($match->team_b_id == $team->id) {
                    $team_touchdowns += $match->touchdowns_b;
                    $team_cards += $match->cards_b;
                    $team_injuries += $match->injuries_b;
                }
            }

            $team_points = $team_wins->count() * 4 + $team_draws->count() * 2 + $team_losses->count();

            return [
                'team' => $team,
                'matches' => $team_matches->count(),
                'wins' => $team_wins->count(),
                'draws' => $team_draws->count(),
                'losses' => $team_losses->count(),
                'touchdowns' => $team_touchdowns,
                'cards' => $team_cards,
                'injuries' => $team_injuries,
                'points' => $team_points,
            ];
        });

        // Ordenar el ranking por puntos
        $ranking = $ranking->sortByDesc('points');

        return $ranking;
    }
}
