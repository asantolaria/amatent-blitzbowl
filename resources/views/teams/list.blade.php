    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Entrenador</th>
                <th>Raza</th>
                <th>Liga</th>
                <!-- <th>Partidos Jugados</th>
                <th>Ganados</th>
                <th>Empatados</th>
                <th>Perdidos</th>
                <th>Puntos</th>
                <th>Touchdowns</th>
                <th>Cartas</th>
                <th>Lesiones</th> -->
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($teams as $team)
            <tr>
                <td>
                    <a href="{{ route('teams.show', $team->id) }}">{{ $team->name }}</a>
                </td>
                <td>{{ $team->coach_name }}</td>
                <td>{{ $team->race }}</td>
                <td>
                    <a href="{{ route('leagues.show', $team->league()->first()->id) }}">{{ $team->league()->first()->name }}</a>
                </td>
                <!-- <td>{{ $team['matches'] }}</td>
                <td>{{ $team['wins'] }}</td>
                <td>{{ $team['draws'] }}</td>
                <td>{{ $team['losses'] }}</td>
                <td>{{ $team['points'] }}</td>
                <td>{{ $team['touchdowns'] }}</td>
                <td>{{ $team['cards'] }}</td>
                <td>{{ $team['injuries'] }}</td> -->
                <td class="d-flex">
                    <a title="Detalle" href="{{ route('teams.show', $team->id) }}" class="btn btn-sm btn-info mr-1">
                        <i class="fa fa-eye"></i>
                    </a>
                    @if (Auth::user() && Auth::user()->admin)
                    <!-- modal editar equipo -->
                    <button title="Editar" type="button" class="btn btn-sm btn-primary mr-1" data-toggle="modal" data-target="#editTeamModal{{ $team['id'] }}">
                        <i class="fa fa-edit"></i>
                    </button>
                    <form title="Eliminar" action="{{ route('teams.destroy', $team['id']) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
            <!-- row para agregar nuevo equipo -->
            @if (Auth::user() && Auth::user()->admin)
            <tr>
                <!-- formulario para crear un nuevo equipo -->
                @if(Auth::user() && Auth::user()->admin)
                <form action="{{ route('teams.store') }}" method="post">
                    @csrf
                    <td>
                        <input type="text" name="name" class="form-control" required>
                        <!-- hidden redirect to teams   -->
                        <input type="hidden" name="redirect" value="teams">
                    </td>
                    <td><input type="text" name="coach_name" class="form-control" required></td>
                    <td><input type="text" name="race" class="form-control" required></td>
                    <td>
                        <select name="league_id" class="form-control" required>
                            @foreach ($leagues as $league)
                            <option value="{{ $league->id }}">{{ $league->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Crear</button></td>
                </form>
                @endif
            </tr>
            @endif
        </tbody>
    </table>




    @if (Auth::user() && Auth::user()->admin)
    <!-- Modal editar equipo -->
    @foreach ($teams as $team)
    <div class="modal fade" id="editTeamModal{{ $team['id'] }}" tabindex="-1" role="dialog" aria-labelledby="editTeamModal{{ $team['id'] }}Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('teams.update', $team['id']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTeamModal{{ $team['id'] }}Label">Editar Equipo {{ $team['name'] }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body d-flex flex-column">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Nombre</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $team['name'] }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="coach_name" class="col-md-4 col-form-label text-md-right">Entrenador</label>
                            <div class="col-md-6">
                                <input id="coach_name" type="text" class="form-control" name="coach_name" value="{{ $team['coach_name'] }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="race" class="col-md-4 col-form-label text-md-right">Raza</label>
                            <div class="col-md-6">
                                <input id="race" type="text" class="form-control" name="race" value="{{ $team['race'] }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="league_id" class="col-md-4 col-form-label text-md-right">Liga</label>
                            <div class="col-md-6">
                                <select id="league_id" class="form-control" name="league_id" required>
                                    @foreach ($leagues as $league)
                                    <option value="{{ $league->id }}" @if ($team['league_id']==$league->id) selected @endif>{{ $league->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    @endif