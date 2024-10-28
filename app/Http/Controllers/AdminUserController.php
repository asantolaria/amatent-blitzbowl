<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gladiador;
use App\Models\Lodis;
use Illuminate\Support\Facades\Hash;
use App\Utils\GeneradorGladiadores;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Asegura que el usuario esté autenticado
        $this->middleware('can:administer-users'); // Asegura que el usuario tenga permisos de administración
    }

    public function index()
    {
        $usuarios = User::all();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Muestra la vista de la liga con la subasta con los gladiadores disponibles
     */
    public function indexgladiadores(Request $request)
    {
        // comprobar si vienen los campos nombre (de gladiador) y lodis
        if ($request->input('nombre') && $request->input('lodis')) {
            $gladiadores = Gladiador::where('nombre', 'like', '%' . $request->input('nombre') . '%')->where('lodis_id', $request->input('lodis'))->paginate(10);
        } else if ($request->input('nombre')) {
            $gladiadores = Gladiador::where('nombre', 'like', '%' . $request->input('nombre') . '%')->paginate(10);
        } else if ($request->input('lodis')) {
            $gladiadores = Gladiador::where('lodis_id', $request->input('lodis'))->paginate(10);
        } else {
            $gladiadores = Gladiador::paginate(10);
        }


        // cargar todas las lodis
        $lodis = Lodis::all();

        return view('admin.gladiadores.index', compact('gladiadores', 'lodis'));
    }

    public function creategladiadores($categoria)
    {
        $cat = intval($categoria);
        $gladiador = GeneradorGladiadores::generarGladiadorAleatorio($cat, false);
        $lodis = Lodis::all();
        return view('admin.gladiadores.createedit', compact('gladiador', 'lodis'))->with('success', 'Se ha generado un gladiador aleatorio de categoría ' . $categoria . ' . Puedes editarlo.');
    }

    public function editgladiadores(Gladiador $gladiador)
    {
        $lodis = Lodis::all();
        return view('admin.gladiadores.createedit', compact('gladiador', 'lodis'));
    }

    public function storegladiadores(Request $request)
    {

        $request->validate([
            'nombre' => 'required',
            'categoria' => 'required',
            'precio_venta' => 'required',
            'precio_subasta' => 'required',
            'velocidad' => 'required',
            'fuerza' => 'required',
            'destreza' => 'required',
            'iniciativa' => 'required',
            'dureza' => 'required',
            'resistencia' => 'required',
            'inteligencia' => 'required',
            'sabiduria' => 'required',
            'heridas_provocadas' => 'required',
            'muertes_provocadas' => 'required',
        ]);

        // comprobar si muerto
        if ($request->input('muerto') == 'on') {
            $muerto = 1;
        } else {
            $muerto = 0;
        }

        // comprobar si fecha de puja finalizada
        if ($request->input('puja_finalizada') == 'on') {
            $puja_finalizada = 1;
        } else {
            $puja_finalizada = 0;
        }

        // comprobar lodis_id
        if ($request->input('lodis_id') == '-') {
            $lodis_id = null;
        } else {
            $lodis_id = $request->input('lodis_id');
        }

        // comprobar puntos_sin_asignar_tipo
        if ($request->input('puntos_sin_asignar_tipo') == "") {
            $puntos_sin_asignar_tipo = null;
        } else {
            $puntos_sin_asignar_tipo = $request->input('puntos_sin_asignar_tipo');
        }

        // comprobar si es un gladiador existente
        if ($request->input('gladiador_id')) {
            $gladiador = Gladiador::find($request->input('gladiador_id'));
        } else {
            $gladiador = Gladiador::create([
                'nombre' => $request->input('nombre'),
                'propietario_id' => 1,
            ]);
        }

        // actualizar campos
        $gladiador->update([
            'nombre' => $request->input('nombre'),
            'mote' => $request->input('mote'),
            'raza' => $request->input('raza'),

            'condicion_social' => $request->input('condicion_social') ? $request->input('condicion_social') : '',
            'estado_fisico' => $request->input('estado_fisico'),
            'fama' => $request->input('fama'),
            'nivel' => $request->input('nivel'),
            'experiencia' => $request->input('experiencia'),
            'siguiente_nivel' => $request->input('siguiente_nivel'),
            'miniatura' => $request->input('miniatura'),
            'categoria' => $request->input('categoria'),
            'puntos' => $request->input('puntos'),
            'precio_venta' => $request->input('precio_venta'),
            'precio_subasta' => $request->input('precio_subasta'),
            'velocidad' => $request->input('velocidad'),
            'fuerza' => $request->input('fuerza'),
            'destreza' => $request->input('destreza'),
            'iniciativa' => $request->input('iniciativa'),
            'dureza' => $request->input('dureza'),
            'resistencia' => $request->input('resistencia'),
            'inteligencia' => $request->input('inteligencia'),
            'sabiduria' => $request->input('sabiduria'),
            'puntos_sin_asignar' => $request->input('puntos_sin_asignar'),
            'puntos_sin_asignar_tipo' => $puntos_sin_asignar_tipo,
            'muerto' => $muerto,
            'puja_lodis' => $request->input('puja_lodis'),
            'puja_fecha_fin' => $request->input('puja_fecha_fin'),
            'puja_finalizada' => $puja_finalizada,
            'puntos_aprendizaje_sin_asignar' => $request->input('puntos_aprendizaje_sin_asignar'),
            'heridas_provocadas' => $request->input('heridas_provocadas'),
            'muertes_provocadas' => $request->input('muertes_provocadas'),
            'victorias' => $request->input('victorias'),
            'derrotas' => $request->input('derrotas'),
            'empates' => $request->input('empates'),
        ]);



        if ($lodis_id != null) {
            $lodis = Lodis::find(intval($lodis_id));
            $lodis->gladiadores()->save($gladiador);
        }

        return redirect()->route('admin.gladiadores.index')->with('success', 'Gladiador ' . $request->input('nombre') . ' creado exitosamente.');
    }

    public function deletegladiadores(Gladiador $gladiador)
    {
        // si el gladiador tiene lodis, se elimina la relación
        if ($gladiador->lodis) {
            $lodis = Lodis::find($gladiador->lodis->id);
            $gladiador->lodis()->dissociate();
        }

        if ($gladiador->pujas) {
            $pujas = $gladiador->pujas;
            foreach ($pujas as $puja) {
                $puja->delete();
            }
        }

        $gladiador->delete();
        return redirect()->route('admin.gladiadores.index')->with('success', 'Gladiador eliminado exitosamente.');
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'last_name' => 'nullable',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => 'required',
            'last_name' => 'nullable',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'password' => 'required|min:6',
        ]);

        $usuario->update([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'admin' => $request->has('admin'),
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function enable(User $usuario)
    {
        $usuario->update([
            'enabled' => true,
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario habilitado exitosamente.');
    }

    public function disable(User $usuario)
    {
        $usuario->update([
            'enabled' => false,
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario deshabilitado exitosamente.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }

    public function resetPassword(User $usuario)
    {
        $usuario->update([
            'password' => 'password123',
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Contraseña reseteada exitosamente.');
    }
}
