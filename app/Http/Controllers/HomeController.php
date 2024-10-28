<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\League;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();

        $widget = [
            'users' => $users,
            //...
        ];

        // Obtener las jornadas en curso
        $ligasConJornadasEnCurso = League::with(['matchdays'])->get();

        return view('home', compact('widget', 'ligasConJornadasEnCurso'));
    }
}
