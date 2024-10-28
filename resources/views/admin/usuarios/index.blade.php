@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h2>Administrar Usuarios</h2>

    <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary mb-2">Crear Usuario</a>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Administrador</th>
                <th>Habilitado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->id }}</td>
                <td>{{ $usuario->name }}</td>
                <td>{{ $usuario->last_name ?? '-' }}</td>
                <td>{{ $usuario->email }}</td>
                <td>
                    @if($usuario->admin)
                    <i class="fa-solid fa-check text-success"></i>
                    @else
                    <i class="fa-solid fa-circle-xmark text-danger"></i>
                    @endif

                </td>
                <td>
                    @if($usuario->enabled)
                    <i class="fa-solid fa-check text-success"></i>
                    @else
                    <i class="fa-solid fa-circle-xmark text-danger"></i>
                    @endif

                </td>
                <td>
                    <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="btn btn-sm mb-1 btn-primary">Editar</a>
                    <form id="edit-form" action="{{ route('admin.usuarios.reset-password', $usuario->id) }}" method="GET" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm mb-1 btn-warning" onclick="return confirm('¿Estás seguro? El valor de la nueva contraseña será: password123')">Resetear Contraseña</button>
                    </form>



                    <a class="btn btn-sm mb-1 btn-danger" onclick="return confirm('¿Estás seguro?')" href="{{ route('admin.usuarios.destroy', $usuario->id) }}">Eliminar</i></a>


                    <!-- si el usuario está habilitado, mostrar el botón de deshabilitar -->
                    @if($usuario->enabled)
                    <form id="disable-form" action="{{ route('admin.usuarios.disable', $usuario->id) }}" method="GET" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm mb-1 btn-danger">Deshabilitar</button>
                    </form>
                    @else
                    <form id="enable-form" action="{{ route('admin.usuarios.enable', $usuario->id) }}" method="GET" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm mb-1 btn-info">Habilitar</button>
                    </form>
                    @endif

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">No hay usuarios registrados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection