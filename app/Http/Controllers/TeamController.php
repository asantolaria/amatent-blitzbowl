<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\League;
use App\Models\Coach;
use App\Models\CoachFeature;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        $leagues = League::all();
        return view('teams.index', compact('teams', 'leagues'));
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
        // Cargar los juegos del equipo con las relaciones necesarias
        $games = $team->games()->with(['matchday.league', 'teamA', 'teamB'])->get();

        // Procesar cada juego para precalcular la información
        $gamesData = $games->map(function ($game) use ($team) {
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

            // Devolver la estructura de datos precalculada
            return [
                'team_a' => $team_a,
                'team_b' => $team_b,
                'matchday' => [
                    'id' => $game->matchday->id,
                    'date' => $game->matchday->date,
                    'description' => $game->matchday->description,
                    'league' => [
                        'id' => $game->matchday->league->id,
                        'name' => $game->matchday->league->name
                    ]
                ],
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

        return view('teams.show', compact('team', 'gamesData'));
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

    public function assignCoachFeature(Request $request, Team $team)
    {
        try {
            $request->validate([
                'coach_feature_id' => 'required|exists:coach_features,id'
            ]);
            $team->coachFeatures()->attach($request->coach_feature_id);
            return redirect()->route('teams.show', $team)->with('success', 'Rasgo de Entrenador asignado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('teams.show', $team)->with('error', 'Error asignando Rasgo de Entrenador: ' . $e->getMessage());
        }
    }

    public function unassignCoachFeature(Team $team, $coachFeature)
    {
        try {
            $team->coachFeatures()->detach($coachFeature);
            return redirect()->route('teams.show', $team)->with('success', 'Rasgo de Entrenador desasignado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('teams.show', $team)->with('error', 'Error desasignando Rasgo de Entrenador: ' . $e->getMessage());
        }
    }
}
