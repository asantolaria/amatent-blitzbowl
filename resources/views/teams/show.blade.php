@extends('layouts.admin')

@section('main-content')
@if (session('success'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger border-left-danger" role="alert">
    <ul class="pl-4 my-2">
        <li>{{ session('error') }}</li>
    </ul>
</div>
@endif

<h2>Detalles de Equipo {{ $team->name }}</h2>

<ul>
    <li><strong>Entrenador:</strong> {{ $team->coach_name }}</li>
    <li><strong>Nombre:</strong> {{ $team->name }}</li>
    <li><strong>Raza:</strong> {{ $team->race }}</li>
    <li><strong>Liga:</strong> {{ $team->league->name }}</li>
    <li><strong>Partidos Jugados:</strong> {{ $team->played }}</li>
    <li><strong>Ganados:</strong> {{ $team->won }}</li>
    <li><strong>Empatados:</strong> {{ $team->drawn }}</li>
    <li><strong>Perdidos:</strong> {{ $team->lost }}</li>

</ul>

<div class="container">
    <!-- lista de partidos -->
    <h3>Partidos</h3>
    TODO: Lista de partidos mostrando fecha, rival, resultado, etc.
</div>

@endsection