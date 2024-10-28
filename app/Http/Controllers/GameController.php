<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\Matchday;
use Illuminate\Http\Request;

class GameController extends Controller
{


    public function store(Request $request, Matchday $matchday)
    {
        try {
            $request->validate([
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

            // add matchday_id
            $request->merge(['matchday_id' => $matchday->id]);

            Game::create($request->all());


            // volver a la jornada
            return redirect()->route('matchdays.show', $matchday->id)->with('success', 'Partido creado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('matchdays.show', $matchday->id)->with('error', 'Error creando el Partido: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Matchday $matchday, Game $game)
    {
        try {
            $request->validate([
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

            // check if the game belongs to the matchday
            if ($game->matchday_id != $matchday->id) {
                return redirect()->route('matchdays.show', $matchday->id)->with('error', 'Error actualizando partido: El partido no pertenece a la jornada.');
            }

            $game->update($request->all());

            // volver a la jornada
            return redirect()->route('matchdays.show', $request->matchday_id)->with('success', 'Partido actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('matchdays.show', $matchday->id)->with('error', 'Error actualizando el partido: ' . $e->getMessage());
        }
    }

    public function destroy(Game $game)
    {
        try {

            $game->delete();
            // redirect a la jornada
            return redirect()->route('matchdays.show', $game->matchday_id)->with('success', 'Partido eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('matchdays.show', $game->matchday_id)->with('error', 'Error borrando el partido: ' . $e->getMessage());
        }
    }
}
