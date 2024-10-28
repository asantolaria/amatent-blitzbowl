@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h2>Editar Usuario</h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    ID: {{$usuario->id}}
    <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Campos del formulario -->
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $usuario->name) }}">
        </div>

        <div class="form-group">
            <label for="last_name">Apellido</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $usuario->last_name) }}">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $usuario->email) }}">
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="admin">Administrator:</label>
            <input type="checkbox" name="admin" id="admin" value="1">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
    </form>
</div>
@endsection