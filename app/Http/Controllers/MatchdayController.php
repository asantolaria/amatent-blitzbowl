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

    public function create()
    {
        $leagues = League::all();
        return view('matchdays.create', compact('leagues'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'league_id' => 'required|exists:leagues,id',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'round_number' => 'nullable|integer',
        ]);

        Matchday::create($request->all());
        return redirect()->route('matchdays.index')->with('success', 'Matchday created successfully.');
    }

    public function show(Matchday $matchday)
    {
        return view('matchdays.show', compact('matchday'));
    }

    public function edit(Matchday $matchday)
    {
        $leagues = League::all();
        return view('matchdays.edit', compact('matchday', 'leagues'));
    }

    public function update(Request $request, Matchday $matchday)
    {
        $request->validate([
            'league_id' => 'required|exists:leagues,id',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'round_number' => 'nullable|integer',
        ]);

        $matchday->update($request->all());
        return redirect()->route('matchdays.index')->with('success', 'Matchday updated successfully.');
    }

    public function destroy(Matchday $matchday)
    {
        $matchday->delete();
        return redirect()->route('matchdays.index')->with('success', 'Matchday deleted successfully.');
    }
}
