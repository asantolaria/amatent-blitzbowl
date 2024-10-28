<?php

namespace App\Http\Controllers;

use App\Models\Matchday;
use App\Models\League;
use Illuminate\Http\Request;

class MatchdayController extends Controller
{


    public function store(Request $request)
    {
        try {
            $request->validate([
                'league_id' => 'required|exists:leagues,id',
                'date' => 'required|date',
                'description' => 'nullable|string',
                'round_number' => 'nullable|integer',
            ]);

            // volver a la liga
            return redirect()->route('leagues.show', $request->league_id)->with('success', 'Matchday created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('leagues.show', $request->league_id)->with('error', 'Error creating matchday: ' . $e->getMessage());
        }
    }

    public function show(Matchday $matchday)
    {
        // Equipos que están inscritos en la liga de la jornada
        $teams = $matchday->league->teams;

        return view('matchdays.show', compact('matchday', 'teams'));
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
