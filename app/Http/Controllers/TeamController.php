<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\League;
use App\Models\Coach;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $teams = Team::all();
        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        dd("Hola");
        $leagues = League::all();
        return view('teams.create', compact('leagues', 'coaches'));
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

            // volver a la liga
            return redirect()->route('leagues.show', $request->league_id)->with('success', 'Team created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('leagues.show', $request->league_id)->with('error', 'Error creating team: ' . $e->getMessage());
        }
    }

    public function show(Team $team)
    {
        return view('teams.show', compact('team'));
    }

    public function edit(Team $team)
    {
        $leagues = League::all();
        $coaches = Coach::all();
        return view('teams.edit', compact('team', 'leagues', 'coaches'));
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|max:255|unique:teams,name,' . $team->id,
            'race' => 'nullable|string',
            'league_id' => 'required|exists:leagues,id',
            'coach_id' => 'nullable|exists:coaches,id',
        ]);

        $team->update($request->all());
        return redirect()->route('teams.index')->with('success', 'Team updated successfully.');
    }

    public function destroy(Team $team)
    {
        try {
            $team->delete();
            // redirect a la liga
            return redirect()->route('leagues.show', $team->league_id)->with('success', 'Team deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('leagues.show', $team->league_id)->with('error', 'Error deleting team: ' . $e->getMessage());
        }
    }
}
