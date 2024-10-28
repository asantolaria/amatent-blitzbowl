<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\Matchday;
use Illuminate\Http\Request;

class GameController extends Controller
{


    public function store(Request $request)
    {
        try {
            $request->validate([
                'matchday_id' => 'required|exists:matchdays,id',
                'team_a_id' => 'required|exists:teams,id|different:team_b_id',
                'team_b_id' => 'required|exists:teams,id|different:team_a_id',
                'touchdowns_a' => 'required|integer|min:0',
                'touchdowns_b' => 'required|integer|min:0',
                'injuries_a' => 'required|integer|min:0',
                'injuries_b' => 'required|integer|min:0',
                'cards_a' => 'required|integer|min:0',
                'cards_b' => 'required|integer|min:0',
                'score_a' => 'required|integer|min:0',
                'score_b' => 'required|integer|min:0',
            ]);

            Game::create($request->all());

            // volver a la jornada
            return redirect()->route('matchdays.show', $request->matchday_id)->with('success', 'Game created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('matchdays.show', $request->matchday_id)->with('error', 'Error creating game: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Game $game)
    {
        try {
            $request->validate([
                'matchday_id' => 'required|exists:matchdays,id',
                'team_a_id' => 'required|exists:teams,id|different:team_b_id',
                'team_b_id' => 'required|exists:teams,id|different:team_a_id',
                'touchdowns_a' => 'required|integer|min:0',
                'touchdowns_b' => 'required|integer|min:0',
                'injuries_a' => 'required|integer|min:0',
                'injuries_b' => 'required|integer|min:0',
                'cards_a' => 'required|integer|min:0',
                'cards_b' => 'required|integer|min:0',
                'score_a' => 'required|integer|min:0',
                'score_b' => 'required|integer|min:0',
            ]);

            $game->update($request->all());

            // volver a la jornada
            return redirect()->route('matchdays.show', $request->matchday_id)->with('success', 'Game updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('matchdays.show', $request->matchday_id)->with('error', 'Error updating game: ' . $e->getMessage());
        }
    }

    public function destroy(Game $game)
    {
        try {

            $game->delete();
            // redirect a la jornada
            return redirect()->route('matchdays.show', $game->matchday_id)->with('success', 'Game deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('matchdays.show', $game->matchday_id)->with('error', 'Error deleting game: ' . $e->getMessage());
        }
    }
}
