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

<h2>Detalles de Jornada {{ $matchday->description }}</h2>

<ul>
    <li><strong>Fecha:</strong> {{ $matchday->date }}</li>
    <li><strong>Descripción:</strong> {{ $matchday->description }}</li>
    <li><strong>Liga:</strong> <a href="{{ route('leagues.show', $matchday->league->id) }}">{{ $matchday->league->name }}</a></li>
</ul>

<!-- lista de partidos -->
<h3>Partidos</h3>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Fecha</th>
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
            <td>{{ $match->date }}</td>
            <td>{{ $match->localTeam->name }}</td>
            <td>{{ $match->visitorTeam->name }}</td>
            <td>{{ $match->local_touchdowns }}</td>
            <td>{{ $match->visitor_touchdowns }}</td>
            <td>{{ $match->local_injuries }}</td>
            <td>{{ $match->visitor_injuries }}</td>
            <td>{{ $match->local_cards }}</td>
            <td>{{ $match->visitor_cards }}</td>
            <td>{{ $match->local_score }}</td>
            <td>{{ $match->visitor_score }}</td>
            @if(Auth::user() && Auth::user()->admin)
            <td>
                <!-- botón editar partido que muestra un modal con el formulario de editar partido -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editGameModal{{ $match->id }}">
                    <i class="fas fa-edit"></i>
                </button>

                <form action="{{ route('games.destroy', $match->id) }}" method="POST" style="display: inline;">
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
<!-- boton añadir partido que muestra un modal con el formulario de añadir partido -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addGameModal">
    Añadir Partido
</button>
@endif


<!-- Modal Crear Partido -->
<div class="modal fade" id="addGameModal" tabindex="-1" role="dialog" aria-labelledby="addGameModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('games.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addGameModalLabel">Añadir Partido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Fecha del Partido -->
                    <div class="form-group">
                        <label for="date">Fecha</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>

                    <div class="row">
                        <!-- Campos del Equipo Local -->
                        <div class="col-6">
                            <h5>Equipo Local</h5>
                            <div class="form-group">
                                <label for="local_team">Equipo Local</label>
                                <select class="form-control" id="local_team" name="local_team" required>
                                    @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="local_touchdowns">Touchdowns Local</label>
                                <input type="number" class="form-control" id="local_touchdowns" name="local_touchdowns" required>
                            </div>
                            <div class="form-group">
                                <label for="local_injuries">Lesiones Local</label>
                                <input type="number" class="form-control" id="local_injuries" name="local_injuries" required>
                            </div>
                            <div class="form-group">
                                <label for="local_cards">Cartas Local</label>
                                <input type="number" class="form-control" id="local_cards" name="local_cards" required>
                            </div>
                            <div class="form-group">
                                <label for="local_score">Puntuación Local</label>
                                <input type="number" class="form-control" id="local_score" name="local_score" required>
                            </div>
                        </div>

                        <!-- Campos del Equipo Visitante -->
                        <div class="col-6">
                            <h5>Equipo Visitante</h5>
                            <div class="form-group">
                                <label for="visitor_team">Equipo Visitante</label>
                                <select class="form-control" id="visitor_team" name="visitor_team" required>
                                    @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="visitor_touchdowns">Touchdowns Visitante</label>
                                <input type="number" class="form-control" id="visitor_touchdowns" name="visitor_touchdowns" required>
                            </div>
                            <div class="form-group">
                                <label for="visitor_injuries">Lesiones Visitante</label>
                                <input type="number" class="form-control" id="visitor_injuries" name="visitor_injuries" required>
                            </div>
                            <div class="form-group">
                                <label for="visitor_cards">Cartas Visitante</label>
                                <input type="number" class="form-control" id="visitor_cards" name="visitor_cards" required>
                            </div>
                            <div class="form-group">
                                <label for="visitor_score">Puntuación Visitante</label>
                                <input type="number" class="form-control" id="visitor_score" name="visitor_score" required>
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
            <form action="{{ route('games.update', $match->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editGameModalLabel{{ $match->id }}">Editar Partido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Fecha del Partido -->
                    <div class="form-group">
                        <label for="date">Fecha</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ $match->date }}" required>
                    </div>

                    <div class="row">
                        <!-- Campos del Equipo Local -->
                        <div class="col-6">
                            <h5>Equipo Local</h5>
                            <div class="form-group">
                                <label for="local_team">Equipo Local</label>
                                <select class="form-control" id="local_team" name="local_team" required>
                                    @foreach ($teams as $team)
                                    <option value="{{ $team->id }}" @if($team->id == $match->local_team_id) selected @endif>{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="local_touchdowns">Touchdowns Local</label>
                                <input type="number" class="form-control" id="local_touchdowns" name="local_touchdowns" value="{{ $match->local_touchdowns }}" required>
                            </div>
                            <div class="form-group">
                                <label for="local_injuries">Lesiones Local</label>
                                <input type="number" class="form-control" id="local_injuries" name="local_injuries" value="{{ $match->local_injuries }}" required>
                            </div>
                            <div class="form-group">
                                <label for="local_cards">Cartas Local</label>
                                <input type="number" class="form-control" id="local_cards" name="local_cards" value="{{ $match->local_cards }}" required>
                            </div>
                            <div class="form-group">
                                <label for="local_score">Puntuación Local</label>
                                <input type="number" class="form-control" id="local_score" name="local_score" value="{{ $match->local_score }}" required>
                            </div>
                        </div>

                        <!-- Campos del Equipo Visitante -->
                        <div class="col-6">
                            <h5>Equipo Visitante</h5>
                            <div class="form-group">
                                <label for="visitor_team">Equipo Visitante</label>
                                <select class="form-control" id="visitor_team" name="visitor_team" required>
                                    @foreach ($teams as $team)
                                    <option value="{{ $team->id }}" @if($team->id == $match->visitor_team_id) selected @endif>{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="visitor_touchdowns">Touchdowns Visitante</label>
                                <input type="number" class="form-control" id="visitor_touchdowns" name="visitor_touchdowns" value="{{ $match->visitor_touchdowns }}" required>
                            </div>
                            <div class="form-group">
                                <label for="visitor_injuries">Lesiones Visitante</label>
                                <input type="number" class="form-control" id="visitor_injuries" name="visitor_injuries" value="{{ $match->visitor_injuries }}" required>
                            </div>
                            <div class="form-group">
                                <label for="visitor_cards">Cartas Visitante</label>
                                <input type="number" class="form-control" id="visitor_cards" name="visitor_cards" value="{{ $match->visitor_cards }}" required>
                            </div>
                            <div class="form-group">
                                <label for="visitor_score">Puntuación Visitante</label>
                                <input type="number" class="form-control" id="visitor_score" name="visitor_score" value="{{ $match->visitor_score }}" required>
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