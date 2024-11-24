@extends('layouts.admin')

@section('main-content')

@php
use App\Models\CoachFeature;
$coachFeatures = CoachFeature::all();
@endphp

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
<div class="row">
    <div class="col-md-2">
        <br>
        <br>
        <ul>
            <li><strong>Entrenador:</strong> {{ $team->coach_name }}</li>
            <li><strong>Nombre:</strong> <a href="{{ route('teams.show', ['team' => $team->id]) }}">{{ $team->name }}</a></li>
            <li><strong>Raza:</strong> {{ $team->race }}</li>
            <li><strong>Liga:</strong> <a href="{{ route('leagues.show', ['league' => $team->league->id]) }}">{{ $team->league->name }}</a></li>
            <li><strong>Partidos Jugados:</strong> {{ $team->played }}</li>
            <li><strong>Ganados:</strong> {{ $team->won }}</li>
            <li><strong>Empatados:</strong> {{ $team->drawn }}</li>
            <li><strong>Perdidos:</strong> {{ $team->lost }}</li>
            <li><strong>Rasgos de Entrenador:</strong>
        </ul>
    </div>
    <div class="col-md-10">

        <!-- CoachFeatures  table -->

        <!-- si el usuario es administrador mostrar botón que muestre un modal para añadir un nuevo CoachFeature -->
        @if (Auth::user() && Auth::user()->admin)
        <div class="text-right">

            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#addCoachFeatureModal">
                <i class="fas fa-plus"></i> Añadir Rasgo de Entrenador
            </button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addCoachFeatureModal" tabindex="-1" role="dialog" aria-labelledby="addCoachFeatureModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('teams.assign-coach-feature', ['team' => $team->id]) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCoachFeatureModalLabel">Añadir Rasgo de Entrenador</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- bostrar coachFeatures disponibles -->
                        <div class="modal-body form-group">
                            <label for="coach_feature_id">Rasgo de Entrenador</label>
                            <select class="form-control" name="coach_feature_id" id="coach_feature_id">
                                @foreach ($coachFeatures as $coachFeature)
                                <option value="{{ $coachFeature->id }}">{{ $coachFeature->result }} - {{ $coachFeature->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="team_id" value="{{ $team->id }}">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Añadir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Número</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripción</th>
                    @if (Auth::user() && Auth::user()->admin)
                    <th scope="col">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($team->coachFeatures as $coachFeature)
                <tr>
                    <td>{{ $coachFeature->result }}</td>
                    <td>{{ $coachFeature->name }}</td>
                    <td>{{ $coachFeature->description }}</td>
                    @if (Auth::user() && Auth::user()->admin)
                    <td>
                        <!-- boton para hacer GET teams.unassign-coach-feature -->
                        <a class="btn btn-danger btn-sm" href="{{ route('teams.unassign-coach-feature', ['team' => $team->id, 'coachFeature' => $coachFeature->id]) }}"><i class="fas fa-trash"></i></a>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



<!-- lista de partidos -->
<h3>Partidos</h3>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Liga</th>
            <th scope="col">Fecha</th>
            <th scope="col">Jornada</th>
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
                <a href="{{ route('leagues.show', ['league' => $match['matchday']['league']['id']]) }}">
                    {{ $match['matchday']['league']['name'] }}
                </a>
            </td>
            <td>{{ $match['matchday']['date'] }}</td>
            <td>
                <a href="{{ route('matchdays.show', ['matchday' => $match['matchday']['id']]) }}">
                    {{ $match['matchday']['description'] }}
                </a>
            </td>
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