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
                            <td>{{ $team->coach_name ?? 'Sin entrenador' }}</td>
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
                            <th>Descripción</th>
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
                                <a href="{{ route('matchdays.show', ['matchday' => $matchday->id]) }}">{{$matchday->description}}</a>
                            </td>
                            <td>{{ $matchday->date }}</td>
                            @if (Auth::user() && Auth::user()->admin)
                            <td class="d-flex">

                                <!-- edit buttton showing modal -->
                                <button type="button" class="btn btn-primary btn-sm mr-1" data-toggle="modal" data-target="#editMatchdayModal{{ $matchday->id }}" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Delete form -->
                                <form action="{{ route('matchdays.destroy', ['matchday' => $matchday->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach

                        <!-- Create new matchday -->
                        @if(Auth::user() && Auth::user()->admin)

                        <tr>

                            <form action="{{ route('matchdays.store') }}" method="post">
                                @csrf
                                <td>
                                    <input type="hidden" name="league_id" value="{{ $league->id }}">

                                    <input type="text" name="description" class="form-control" placeholder="Descripción" required>
                                </td>
                                <td>
                                    <input type="date" name="date" class="form-control" placeholder="Fecha" required>
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

        <!-- Tab - Clasificación -->
        <div class="tab-pane fade" id="standings" role="tabpanel" aria-labelledby="standings-tab">
            <div class="table-responsive mt-3">
                <table class="table table-bordered display" id="dataTableStandings" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Entrenador</th>
                            <th>Equipo</th>
                            <th title="Partidos Jugados">PJ</th>
                            <th title="Partidos Ganados">PG</th>
                            <th title="Partidos Empatados">PE</th>
                            <th title="Partidos Perdidos">PP</th>
                            <th title="Puntos">PTS</th>
                            <th title="Touchdowns Anotados">Touchdowns</th>
                            <th title="Cartas Obtenidas">Cartas</th>
                            <th title="Lesiones Provocadas">Lesiones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ranking as $team)
                        <tr>
                            <td>{{ $team['team']->coach_name ?? 'Sin entrenador' }}</td>
                            <td>{{ $team['team']->name }}</td>
                            <td>{{ $team['matches'] }}</td>
                            <td>{{ $team['wins'] }}</td>
                            <td>{{ $team['draws'] }}</td>
                            <td>{{ $team['losses'] }}</td>
                            <td>{{ $team['points'] }}</td>
                            <td>{{ $team['touchdowns'] }}</td>
                            <td>{{ $team['cards'] }}</td>
                            <td>{{ $team['injuries'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>



        <!-- Tab - Emparejamientos -->
        <div class="tab-pane fade" id="pairings" role="tabpanel" aria-labelledby="pairings-tab">
            <div class="table-responsive mt-3">
                <table class="table table-bordered" id="dataTablePairings" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Jornada</th>
                            <th>Local</th>
                            <th>Visitante</th>
                            <th>Resultado</th>
                            @if(Auth::user() && Auth::user()->admin)
                            <th>Acciones</th>
                            @endif
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
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


<!-- Incluir el JS de DataTables en tu vista -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTableStandings').DataTable({
            processing: true,
            serverSide: true,
            paging: false,
            info: false,
            lengthChange: false,
            ajax: "{{ route('standings', ['league' => $league->id]) }}",
            order: [
                [6, 'desc']
            ], // Ordena por la columna de puntos (7ª columna, índice 6) en orden descendente
            columns: [{
                    data: 'team.coach_name',
                    name: 'team.coach_name'
                },
                {
                    data: 'team.name',
                    name: 'team.name'
                },
                {
                    data: 'matches',
                    name: 'matches'
                },
                {
                    data: 'wins',
                    name: 'wins'
                },
                {
                    data: 'draws',
                    name: 'draws'
                },
                {
                    data: 'losses',
                    name: 'losses'
                },
                {
                    data: 'points',
                    name: 'points'
                },
                {
                    data: 'touchdowns',
                    name: 'touchdowns'
                },
                {
                    data: 'cards',
                    name: 'cards'
                },
                {
                    data: 'injuries',
                    name: 'injuries'
                }
            ]
        });
    });
</script>

@endsection