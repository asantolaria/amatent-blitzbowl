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

<h2>Equipo {{ $team->name }}</h2>

<ul>
    <li><strong>Entrenador:</strong> {{ $team->coach_name }}</li>
    <li><strong>Nombre:</strong> <a href="{{ route('teams.show', ['team' => $team->id]) }}">{{ $team->name }}</a></li>
    <li><strong>Raza:</strong> {{ $team->race }}</li>
    <li><strong>Liga:</strong> <a href="{{ route('leagues.show', ['league' => $team->league->id]) }}">{{ $team->league->name }}</a></li>
    <li><strong>Partidos Jugados:</strong> {{ $team->played }}</li>
    <li><strong>Ganados:</strong> {{ $team->won }}</li>
    <li><strong>Empatados:</strong> {{ $team->drawn }}</li>
    <li><strong>Perdidos:</strong> {{ $team->lost }}</li>

</ul>

<div class="container">
    <!-- lista de partidos -->
    <h3>Partidos</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Equipo Local</th>
                <th scope="col">Equipo Visitante</th>
                <th scope="col">Touchdowns Local</th>
                <th scope="col">Touchdowns Visitante</th>
                <th scope="col">Lesiones Local</th>
                <th scope="col">Lesiones Visitante</th>
                <th scope="col">Cartas Local</th>
                <th scope="col">Cartas Visitante</th>
                <th scope="col">Puntuación Local</th>
                <th scope="col">Puntuación Visitante</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($games as $match)
            <tr>
                <td>
                    <!-- Verificar si el equipo local es el ganador o el perdedor -->
                    @if($match->winner() == null && $match->loser() == null)
                    <h4><span class="badge badge-warning">{{ $match->teamA->name }}</span></h4>
                    @elseif($match->winner()->first() && $match->winner()->first()->id == $match->team_a_id)
                    <h4><span class="badge badge-success">{{ $match->teamA->name }}</span></h4>
                    @elseif($match->loser() && $match->loser()->id == $match->team_a_id)
                    <h4><span class="badge badge-danger">{{ $match->teamA->name }}</span></h4>
                    @endif
                    {{$match->teamA->coach_name}}
                </td>
                <td>
                    <!-- Verificar si el equipo visitante es el ganador o el perdedor -->
                    @if($match->winner() == null && $match->loser() == null)
                    <h4><span class="badge badge-warning">{{ $match->teamB->name }}</span></h4>
                    @elseif($match->winner()->first() && $match->winner()->first()->id == $match->team_b_id)
                    <h4><span class="badge badge-success">{{ $match->teamB->name }}</span></h4>
                    @elseif($match->loser() && $match->loser()->id == $match->team_b_id)
                    <h4><span class="badge badge-danger">{{ $match->teamB->name }}</span></h4>
                    @endif
                    {{$match->teamB->coach_name}}
                </td>
                <td>{{ $match->touchdowns_a }}</td>
                <td>{{ $match->touchdowns_b }}</td>
                <td>{{ $match->injuries_a }}</td>
                <td>{{ $match->injuries_b }}</td>
                <td>{{ $match->cards_a }}</td>
                <td>{{ $match->cards_b }}</td>
                <td>{{ $match->score_a }}</td>
                <td>{{ $match->score_b }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection