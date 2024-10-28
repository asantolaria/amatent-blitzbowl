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

<h2>Detalles de la Liga {{ $league->name }}</h2>

<ul>
    <li><strong>Nombre:</strong> {{ $league->name }}</li>
    <li><strong>Descripción:</strong> {{ $league->description }}</li>
    <li><strong>Año de la temporada:</strong> {{ $league->season_year }}</li>
    <li><strong>Estado:</strong> {{ $league->enabled ? 'Activa' : 'Desactivada' }}</li>
</ul>

<div class="container">
    <!-- Tabs navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <!-- Tab - Equipos -->
        <li class="nav-item">
            <a class="nav-link" id="teams-tab" data-toggle="tab" href="#teams" role="tab" aria-controls="teams" aria-selected="false">
                {{ __('Equipos') }}
            </a>
        </li>

        <!-- Tab - Jornadas -->
        <li class="nav-item">
            <a class="nav-link" id="matchdays-tab" data-toggle="tab" href="#matchdays" role="tab" aria-controls="matchdays" aria-selected="false">
                {{ __('Jornadas') }}
            </a>
        </li>
    </ul>

    <!-- Tabs content, wrapped in the same container to ensure alignment below the tabs -->
    <div class="tab-content mt-3" id="myTabContent">
        <!-- Tab - Equipos -->
        <div class="tab-pane fade show active" id="teams" role="tabpanel" aria-labelledby="teams-tab">
            <div class="table-responsive mt-3">
                <table class="table table-bordered" id="dataTableTeams" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Entrenador</th>
                            <th>Nombre</th>
                            <th>Raza</th>
                            @if(Auth::user() && Auth::user()->admin)
                            <th>Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($league->teams as $team)
                        <tr>
                            <td>{{ $team->coach->name ?? 'Sin entrenador' }}</td>
                            <td>
                                <a href="{{ route('teams.show', ['team' => $team->id]) }}">{{ $team->name }}</a>
                            </td>
                            <td>{{ $team->race }}</td>
                            @if(Auth::user() && Auth::user()->admin)
                            <td>
                                <div class="d-flex">
                                    <!-- Edit button -->
                                    <button title="Editar" type="button" class="btn btn-sm btn-primary mr-1" data-toggle="modal" data-target="#editTeamModal{{ $team->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Delete form -->
                                    <form action="{{ route('teams.destroy', ['team' => $team->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button title="Eliminar" type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach

                        <!-- Create new team -->
                        @if(Auth::user() && Auth::user()->admin)
                        <tr>
                            <form action="{{ route('teams.store') }}" method="post">
                                @csrf
                                <td>
                                    <input type="hidden" name="league_id" value="{{ $league->id }}">
                                    <input type="text" name="coach_name" class="form-control" placeholder="Nombre del Entrenador">
                                </td>
                                <td>
                                    <input type="text" name="name" class="form-control" placeholder="Nombre del equipo">
                                </td>
                                <td>
                                    <input type="text" name="race" class="form-control" placeholder="Raza">
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </td>
                            </form>
                        </tr>
                        @endif
                    </tbody>
                </table>

            </div>
        </div>

        <!-- Tab - Jornadas -->
        <div class="tab-pane fade" id="matchdays" role="tabpanel" aria-labelledby="matchdays-tab">
            <div class="table-responsive mt-3">
                <table class="table table-bordered" id="dataTableMatchdays" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Jornada</th>
                            <th>Fecha</th>
                            @if(Auth::user() && Auth::user()->admin)
                            <th>Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($league->matchdays as $matchday)
                        <tr>
                            <td>
                                <a href="{{ route('matchdays.show', ['matchday' => $matchday->id]) }}">{{ $matchday->round_number }}</a>
                            </td>
                            <td>{{ $matchday->date }}</td>
                            <td>
                                <form action="{{ route('matchdays.destroy', ['matchday' => $matchday->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach

                        <!-- Create new matchday -->
                        @if(Auth::user() && Auth::user()->admin)

                        <tr>

                            <form action="{{ route('matchdays.store') }}" method="post">
                                @csrf
                                <td>
                                    <input type="hidden" name="league_id" value="{{ $league->id }}">
                                    <input type="number" name="round_number" class="form-control" placeholder="Número de la jornada">
                                </td>
                                <td>
                                    <input type="date" name="date" class="form-control" placeholder="Fecha">
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </td>
                            </form>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modals to edit team -->
@foreach($league->teams as $team)
<div class="modal fade" id="editTeamModal{{ $team->id }}" tabindex="-1" role="dialog" aria-labelledby="editTeamModal{{ $team->id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('teams.update', ['team' => $team->id]) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editTeamModal{{ $team->id }}Label">Editar Equipo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-group">
                    <label for="coach_name">Entrenador</label>
                    <input type="text" name="coach_name" value="{{ $team->coach->name ?? '' }}" class="form-control" required>
                    <label for="name">Nombre</label>
                    <input type="text" name="name" value="{{ $team->name }}" class="form-control" required>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection