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

        return view('leagues.show', compact('league'));
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
}
