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


<!-- Tabs navigation -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <!-- Tab - Equipos -->
    <li class="nav-item">
        <a class="nav-link active" id="teams-tab" data-toggle="tab" href="#teams" role="tab" aria-controls="teams" aria-selected="true">
            {{ __('Equipos') }}
        </a>
    </li>

    <!-- Tab - Jornadas -->
    <li class="nav-item">
        <a class="nav-link" id="matchdays-tab" data-toggle="tab" href="#matchdays" role="tab" aria-controls="matchdays" aria-selected="false">
            {{ __('Jornadas') }}
        </a>
    </li>

    <!-- Tab - Clasificación -->
    <li class="nav-item">
        <a class="nav-link" id="standings-tab" data-toggle="tab" href="#standings" role="tab" aria-controls="standings" aria-selected="false">
            {{ __('Clasificación') }}
        </a>
    </li>

    <!-- Tab - Emparejamientos -->
    <li class="nav-item">
        <a class="nav-link" id="pairings-tab" data-toggle="tab" href="#pairings" role="tab" aria-controls="pairings" aria-selected="false">
            {{ __('Emparejamientos') }}
        </a>
    </li>
</ul>

<!-- Tabs content, wrapped in the same container to ensure alignment below the tabs -->
<div class="tab-content mt-3" id="myTabContent">
    <!-- Tab - Equipos -->
    <div class="tab-pane fade show active" id="teams" role="tabpanel" aria-labelledby="teams-tab">
        @include('leagues.tabs.teams')
    </div>

    <!-- Tab - Jornadas -->
    <div class="tab-pane fade" id="matchdays" role="tabpanel" aria-labelledby="matchdays-tab">
        @include('leagues.tabs.matchdays')
    </div>

    <!-- Tab - Clasificación -->
    <div class="tab-pane fade" id="standings" role="tabpanel" aria-labelledby="standings-tab">
        @include('leagues.tabs.standings')
    </div>



    <!-- Tab - Emparejamientos -->
    <div class="tab-pane fade" id="pairings" role="tabpanel" aria-labelledby="pairings-tab">
        @include('leagues.tabs.pairings')
    </div>
</div>


<!-- Modals to edit team -->
@if(Auth::user() && Auth::user()->admin)
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
@endif

<!-- Modals to edit matchday -->
@if(Auth::user() && Auth::user()->admin)
@foreach($league->matchdays as $matchday)
<div class="modal fade" id="editMatchdayModal{{ $matchday->id }}" tabindex="-1" role="dialog" aria-labelledby="editMatchdayModal{{ $matchday->id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('matchdays.update', ['matchday' => $matchday->id]) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editMatchdayModal{{ $matchday->id }}Label">Editar Jornada</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form-group">
                    <input type="hidden" name="league_id" value="{{ $league->id }}">
                    <label for="description">Descripción</label>
                    <input type="text" name="description" value="{{ $matchday->description }}" class="form-control" required>
                    <label for="date">Fecha</label>
                    <input type="date" name="date" value="{{ $matchday->date }}" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endif



@endsection