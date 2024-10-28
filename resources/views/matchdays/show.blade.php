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

<!-- Lista de Partidos -->
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
            @if(Auth::user() && Auth::user()->admin)
            <th scope="col">Acciones</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($matchday->games as $match)
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
            @if(Auth::user() && Auth::user()->admin)
            <td>
                <!-- Botón Editar Partido -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editGameModal{{ $match->id }}">
                    <i class="fas fa-edit"></i>
                </button>

                <!-- Formulario Eliminar Partido -->
                <form action="{{ route('games.destroy', ['matchday' => $matchday->id, 'game' => $match->id]) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>

@if(Auth::user() && Auth::user()->admin)
<!-- Botón Añadir Partido -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addGameModal">
    Añadir Partido
</button>
@endif

<!-- Modal Crear Partido -->
<div class="modal fade" id="addGameModal" tabindex="-1" role="dialog" aria-labelledby="addGameModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('games.store', $matchday->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addGameModalLabel">Añadir Partido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Campos del Equipo Local -->
                        <div class="col-6">
                            <h5>Equipo Local</h5>
                            <div class="form-group">
                                <label for="team_a_id">Equipo Local</label>
                                <select class="form-control" id="team_a_id" name="team_a_id" required>
                                    @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }} ({{$team->coach_name}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="touchdowns_a">Touchdowns Local</label>
                                <input type="number" class="form-control" id="touchdowns_a" name="touchdowns_a" required>
                            </div>
                            <div class="form-group">
                                <label for="injuries_a">Lesiones Local</label>
                                <input type="number" class="form-control" id="injuries_a" name="injuries_a" required>
                            </div>
                            <div class="form-group">
                                <label for="cards_a">Cartas Local</label>
                                <input type="number" class="form-control" id="cards_a" name="cards_a" required>
                            </div>
                            <div class="form-group">
                                <label for="score_a">Puntuación Local</label>
                                <input type="number" class="form-control" id="score_a" name="score_a" required>
                            </div>
                        </div>

                        <!-- Campos del Equipo Visitante -->
                        <div class="col-6">
                            <h5>Equipo Visitante</h5>
                            <div class="form-group">
                                <label for="team_b_id">Equipo Visitante</label>
                                <select class="form-control" id="team_b_id" name="team_b_id" required>
                                    @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }} ({{$team->coach_name}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="touchdowns_b">Touchdowns Visitante</label>
                                <input type="number" class="form-control" id="touchdowns_b" name="touchdowns_b" required>
                            </div>
                            <div class="form-group">
                                <label for="injuries_b">Lesiones Visitante</label>
                                <input type="number" class="form-control" id="injuries_b" name="injuries_b" required>
                            </div>
                            <div class="form-group">
                                <label for="cards_b">Cartas Visitante</label>
                                <input type="number" class="form-control" id="cards_b" name="cards_b" required>
                            </div>
                            <div class="form-group">
                                <label for="score_b">Puntuación Visitante</label>
                                <input type="number" class="form-control" id="score_b" name="score_b" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Editar Partido -->
@if (Auth::user() && Auth::user()->admin)
@foreach ($matchday->games as $match)
<div class="modal fade" id="editGameModal{{ $match->id }}" tabindex="-1" role="dialog" aria-labelledby="editGameModalLabel{{ $match->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('games.update', ['matchday' => $matchday->id, 'game' => $match->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editGameModalLabel{{ $match->id }}">Editar Partido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <!-- Campos del Equipo Local -->
                        <div class="col-6">
                            <h5>Equipo Local</h5>
                            <div class="form-group">
                                <label for="team_a_id">Equipo Local</label>
                                <select class="form-control" id="team_a_id" name="team_a_id" required>
                                    @foreach ($teams as $team)
                                    <option value="{{ $team->id }}" @if($team->id == $match->team_a_id) selected @endif>{{ $team->name }} ({{$team->coach_name}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="touchdowns_a">Touchdowns Local</label>
                                <input type="number" class="form-control" id="touchdowns_a" name="touchdowns_a" value="{{ $match->touchdowns_a }}" required>
                            </div>
                            <div class="form-group">
                                <label for="injuries_a">Lesiones Local</label>
                                <input type="number" class="form-control" id="injuries_a" name="injuries_a" value="{{ $match->injuries_a }}" required>
                            </div>
                            <div class="form-group">
                                <label for="cards_a">Cartas Local</label>
                                <input type="number" class="form-control" id="cards_a" name="cards_a" value="{{ $match->cards_a }}" required>
                            </div>
                            <div class="form-group">
                                <label for="score_a">Puntuación Local</label>
                                <input type="number" class="form-control" id="score_a" name="score_a" value="{{ $match->score_a }}" required>
                            </div>
                        </div>

                        <!-- Campos del Equipo Visitante -->
                        <div class="col-6">
                            <h5>Equipo Visitante</h5>
                            <div class="form-group">
                                <label for="team_b_id">Equipo Visitante</label>
                                <select class="form-control" id="team_b_id" name="team_b_id" required>
                                    @foreach ($teams as $team)
                                    <option value="{{ $team->id }}" @if($team->id == $match->team_b_id) selected @endif>{{ $team->name }} ({{$team->coach_name}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="touchdowns_b">Touchdowns Visitante</label>
                                <input type="number" class="form-control" id="touchdowns_b" name="touchdowns_b" value="{{ $match->touchdowns_b }}" required>
                            </div>
                            <div class="form-group">
                                <label for="injuries_b">Lesiones Visitante</label>
                                <input type="number" class="form-control" id="injuries_b" name="injuries_b" value="{{ $match->injuries_b }}" required>
                            </div>
                            <div class="form-group">
                                <label for="cards_b">Cartas Visitante</label>
                                <input type="number" class="form-control" id="cards_b" name="cards_b" value="{{ $match->cards_b }}" required>
                            </div>
                            <div class="form-group">
                                <label for="score_b">Puntuación Visitante</label>
                                <input type="number" class="form-control" id="score_b" name="score_b" value="{{ $match->score_b }}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endforeach
@endif

@endsection