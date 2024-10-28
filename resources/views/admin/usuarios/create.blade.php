@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h2>Create User</h2>

    {{-- Formulario para crear usuarios --}}
    <form method="POST" action="{{ route('admin.usuarios.store') }}">
        @csrf

        {{-- Campos del formulario --}}
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="admin">Administrator:</label>
            <input type="checkbox" name="admin" id="admin" value="1">
        </div>

        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>
@endsection