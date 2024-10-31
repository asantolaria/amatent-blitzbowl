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

<h2>Detalles de {{ $matchday->description }}</h2>

<ul>
    <li><strong>Fecha:</strong> {{ $matchday->date }}</li>
    <li><strong>Descripción:</strong> <a href="{{ route('matchdays.show', $matchday->id) }}">{{ $matchday->description }}</a></li>
    <li><strong>Liga:</strong> <a href="{{ route('leagues.show', $matchday->league->id) }}">{{ $matchday->league->name }}</a></li>
</ul>

<!-- boton para ir a jornada anterior -->
@if ($matchday->previous())
<a href="{{ route('matchdays.show', $matchday->previous()->id) }}" class="btn btn-sm btn-primary">
    <i class="fas fa-arrow-left"></i>
    Jornada Anterior</a>
@endif

<!-- boton para ir a siguiente jornada -->
@if ($matchday->next())
<a href="{{ route('matchdays.show', $matchday->next()->id) }}" class="btn btn-sm btn-primary">
    Siguiente Jornada
    <i class="fas fa-arrow-right"></i>
</a>
@endif

<br><br>

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
        @foreach ($gamesData as $match)
        <tr>
            <td>
                <h4>
                    <span class="badge 
                        @if($match['team_a']['status'] === 'winner') badge-success 
                        @elseif($match['team_a']['status'] === 'loser') badge-danger 
                        @else badge-warning 
                        @endif">
                        {{ $match['team_a']['name'] }}
                    </span>
                </h4>
                {{ $match['team_a']['coach_name'] }}
            </td>
            <td>
                <h4>
                    <span class="badge 
                        @if($match['team_b']['status'] === 'winner') badge-success 
                        @elseif($match['team_b']['status'] === 'loser') badge-danger 
                        @else badge-warning 
                        @endif">
                        {{ $match['team_b']['name'] }}
                    </span>
                </h4>
                {{ $match['team_b']['coach_name'] }}
            </td>
            <td>{{ $match['touchdowns_a'] }}</td>
            <td>{{ $match['touchdowns_b'] }}</td>
            <td>{{ $match['injuries_a'] }}</td>
            <td>{{ $match['injuries_b'] }}</td>
            <td>{{ $match['cards_a'] }}</td>
            <td>{{ $match['cards_b'] }}</td>
            <td>{{ $match['score_a'] }}</td>
            <td>{{ $match['score_b'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection