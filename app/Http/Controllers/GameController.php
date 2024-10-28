<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\Matchday;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with(['teamA', 'teamB', 'matchday'])->get();
        return view('games.index', compact('games'));
    }

    public function create()
    {
        $teams = Team::all();
        $matchdays = Matchday::all();
        return view('games.create', compact('teams', 'matchdays'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'matchday_id' => 'required|exists:matchdays,id',
            'team_a_id' => 'required|exists:teams,id|different:team_b_id',
            'team_b_id' => 'required|exists:teams,id|different:team_a_id',
            'score_a' => 'required|integer|min:0',
            'score_b' => 'required|integer|min:0',
        ]);

        Game::create($request->all());
        return redirect()->route('games.index')->with('success', 'Game created successfully.');
    }

    public function show(Game $game)
    {
        return view('games.show', compact('game'));
    }

    public function edit(Game $game)
    {
        $teams = Team::all();
        $matchdays = Matchday::all();
        return view('games.edit', compact('game', 'teams', 'matchdays'));
    }

    public function update(Request $request, Game $game)
    {
        $request->validate([
            'matchday_id' => 'required|exists:matchdays,id',
            'team_a_id' => 'required|exists:teams,id|different:team_b_id',
            'team_b_id' => 'required|exists:teams,id|different:team_a_id',
            'score_a' => 'required|integer|min:0',
            'score_b' => 'required|integer|min:0',
        ]);

        $game->update($request->all());
        return redirect()->route('games.index')->with('success', 'Game updated successfully.');
    }

    public function destroy(Game $game)
    {
        $game->delete();
        return redirect()->route('games.index')->with('success', 'Game deleted successfully.');
    }
}
