<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
            'enabled' => false,
            'admin' => true,
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
            'password' => $request->input('password'),
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
