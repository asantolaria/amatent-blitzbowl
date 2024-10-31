<?php

namespace App\Http\Controllers;

use App\Models\Matchday;
use App\Models\League;
use Illuminate\Http\Request;

class MatchdayController extends Controller
{
    public function index()
    {
        $matchdays = Matchday::all();
        return view('matchdays.index', compact('matchdays'));
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'league_id' => 'required|exists:leagues,id',
                'date' => 'required|date',
                'description' => 'nullable|string',
                'round_number' => 'nullable|integer',
            ]);

            Matchday::create($request->all());

            // volver a la liga
            return redirect()->route('leagues.show', $request->league_id)->with('success', 'Matchday created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('leagues.show', $request->league_id)->with('error', 'Error creating matchday: ' . $e->getMessage());
        }
    }

    // public function show(Matchday $matchday)
    // {
    //     // Equipos que están inscritos en la liga de la jornada
    //     $teams = $matchday->league->teams;

    //     return view('matchdays.show', compact('matchday', 'teams'));
    // }

    public function show(Matchday $matchday)
    {
        // Cargar el matchday con sus juegos, liga y equipos necesarios
        $matchday = Matchday::with(['league', 'games.teamA', 'games.teamB'])->findOrFail($matchday->id);

        // Preparar una colección de juegos con los datos necesarios precalculados
        $gamesData = $matchday->games->map(function ($game) {
            // Determinar ganador, perdedor o empate
            $winner = $game->winner();
            if ($winner) {
                $winner = $winner->first();
            }
            $loser = $game->loser();
            if ($loser) {
                $loser = $loser->first();
            }

            $is_draw = is_null($winner);

            $status_a = $is_draw ? 'draw' : ($winner->id == $game->team_a_id ? 'winner' : 'loser');
            $status_b = $is_draw ? 'draw' : ($winner->id == $game->team_b_id ? 'winner' : 'loser');

            // Preparar los datos de cada equipo
            $team_a = [
                'name' => $game->teamA->name,
                'coach_name' => $game->teamA->coach_name,
                'status' => $status_a
            ];
            $team_b = [
                'name' => $game->teamB->name,
                'coach_name' => $game->teamB->coach_name,
                'status' => $status_b
            ];
            return [
                'team_a' => $team_a,
                'team_b' => $team_b,
                'touchdowns_a' => $game->touchdowns_a,
                'touchdowns_b' => $game->touchdowns_b,
                'injuries_a' => $game->injuries_a,
                'injuries_b' => $game->injuries_b,
                'cards_a' => $game->cards_a,
                'cards_b' => $game->cards_b,
                'score_a' => $game->score_a,
                'score_b' => $game->score_b,
                'id' => $game->id
            ];
        });

        return view('matchdays.show', compact('matchday', 'gamesData'));
    }



    public function update(Request $request, Matchday $matchday)
    {
        try {
            $request->validate([
                'league_id' => 'required|exists:leagues,id',
                'date' => 'required|date',
                'description' => 'nullable|string',
                'round_number' => 'nullable|integer',
            ]);

            $matchday->update($request->all());

            return redirect()->route('leagues.show', $request->league_id)->with('success', 'Matchday updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('leagues.show', $request->league_id)->with('error', 'Error updating matchday: ' . $e->getMessage());
        }
    }

    public function destroy(Matchday $matchday)
    {
        try {
            $matchday->delete();
            return redirect()->route('leagues.show', $matchday->league_id)->with('success', 'Matchday deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('leagues.show', $matchday->league_id)->with('error', 'Error deleting matchday: ' . $e->getMessage());
        }
    }
}
