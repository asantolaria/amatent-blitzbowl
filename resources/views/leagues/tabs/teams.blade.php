<!-- resources/views/tabs/teams.blade.php -->
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