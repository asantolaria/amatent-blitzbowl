<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\League;
use App\Models\Coach;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        $statistics = [];
        foreach ($teams as $team) {
            $statistics[] = $this->statistics($team);
        }
        $leagues = League::all();
        return view('teams.index', compact('teams', 'leagues', 'statistics'));
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|unique:teams|max:255',
                'race' => 'nullable|string',
                'league_id' => 'required|exists:leagues,id',
                'coach_id' => 'nullable|exists:coaches,id',
            ]);

            Team::create($request->all());

            // volver a la liga
            return redirect()->route('teams.index')->with('success', 'Equipo creado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('teams.index')->with('error', 'Error creatdo Equipo: ' . $e->getMessage());
        }
    }

    public function show(Team $team)
    {
        $games = $team->games;
        return view('teams.show', compact('team', 'games'));
    }

    public function edit(Team $team)
    {
        $leagues = League::all();
        $coaches = Coach::all();
        return view('teams.edit', compact('team', 'leagues', 'coaches'));
    }

    public function update(Request $request, Team $team)
    {
        try {
            $request->validate([
                'name' => 'required|max:255|unique:teams,name,' . $team->id,
                'race' => 'nullable|string',
                'league_id' => 'required|exists:leagues,id',
                'coach_id' => 'nullable|exists:coaches,id',
            ]);

            $team->update($request->all());
            return redirect()->route('teams.index')->with('success', 'Equipo actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('teams.index')->with('error', 'Error actualizando equipo: ' . $e->getMessage());
        }
    }

    public function destroy(Team $team)
    {
        try {
            $team->delete();
            // redirect a la liga
            return redirect()->route('teams.index')->with('success', 'Equipo eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('teams.index')->with('error', 'Error eliminando equipo: ' . $e->getMessage());
        }
    }

    private function statistics(Team $team)
    {
        $matches = $team->games;
        $wins = $team->gamesWon();
        $draws = $team->gamesDrawn();
        $losses = $team->gamesLost();
        $touchdowns = $matches->sum('touchdowns_a') + $matches->sum('touchdowns_b');
        $cards = $matches->sum('cards_a') + $matches->sum('cards_b');
        $injuries = $matches->sum('injuries_a') + $matches->sum('injuries_b');
        $points = count($wins) * 4 + count($draws) * 2 + count($losses);


        return [
            'team' => $team,
            'league' => $team->league,
            'matches' => $matches->count(),
            'wins' => count($wins),
            'draws' => count($draws),
            'losses' => count($losses),
            'touchdowns' => $touchdowns,
            'cards' => $cards,
            'injuries' => $injuries,
            'points' => $points,
        ];
    }
}
