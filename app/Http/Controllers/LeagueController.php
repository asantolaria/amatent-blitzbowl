<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\League;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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

    public function standings(Request $request, League $league)
    {
        $ranking = $this->ranking($league);

        return DataTables::of($ranking)
            ->addColumn('team.coach_name', fn($row) => $row['team']->coach_name ?? 'Sin entrenador')
            ->addColumn('team.name', fn($row) => $row['team']->name)
            ->addColumn('matches', fn($row) => $row['matches'])
            ->addColumn('wins', fn($row) => $row['wins'])
            ->addColumn('draws', fn($row) => $row['draws'])
            ->addColumn('losses', fn($row) => $row['losses'])
            ->addColumn('points', fn($row) => $row['points'])
            ->addColumn('touchdowns', fn($row) => $row['touchdowns'])
            ->addColumn('cards', fn($row) => $row['cards'])
            ->addColumn('injuries', fn($row) => $row['injuries'])
            ->make(true);
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
        $matches = $league->matchdays()->with('games')->get()->pluck('games')->flatten();
        $teams = $league->teams;

        $ranking = $teams->map(function ($team) use ($matches) {
            $team_matches = $matches->filter(function ($match) use ($team) {
                return $match->team_a_id == $team->id || $match->team_b_id == $team->id;
            });

            $team_wins = $team_matches->filter(function ($match) use ($team) {
                $winner = $match->winner();
                return $winner && $winner->first()->id == $team->id;
            });

            $team_draws = $team_matches->filter(function ($match) {
                return $match->winner() === null && $match->loser() === null;
            });

            $team_losses = $team_matches->filter(function ($match) use ($team) {
                $loser = $match->loser();
                return $loser && $loser->first()->id == $team->id;
            });

            $team_touchdowns = $team_matches->sum(function ($match) use ($team) {
                return $match->team_a_id == $team->id ? $match->touchdowns_a : ($match->team_b_id == $team->id ? $match->touchdowns_b : 0);
            });

            $team_cards = $team_matches->sum(function ($match) use ($team) {
                return $match->team_a_id == $team->id ? $match->cards_a : ($match->team_b_id == $team->id ? $match->cards_b : 0);
            });

            $team_injuries = $team_matches->sum(function ($match) use ($team) {
                return $match->team_a_id == $team->id ? $match->injuries_a : ($match->team_b_id == $team->id ? $match->injuries_b : 0);
            });

            $team_points = $team_wins->count() * 4 + $team_draws->count() * 2;

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
        })->sortByDesc('points')->values();

        return $ranking;
    }
}