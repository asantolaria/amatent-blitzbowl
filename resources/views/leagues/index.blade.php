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

<h2>Listado de Ligas</h2>

<!-- Tabla de ligas -->
<div class="row">
    <div class="col-md-12 mb-3">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTableLigas" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Año de la temporada</th>
                        <th>Estado</th>
                        @if(Auth::user() && Auth::user()->admin)
                        <th>Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($leagues as $liga)
                    <tr>
                        <td>{{ $liga->id }}</td>
                        <td>
                            <!-- link a la página de la liga -->
                            <a href="{{ route('leagues.show', ['league' => $liga->id]) }}">{{ $liga->name }}</a>
                        </td>
                        <td>{{ $liga->description }}</td>
                        <td>{{ $liga->season_year }}</td>
                        <td>
                            @if(Auth::user() && Auth::user()->admin)

                            <!-- Si la liga está activa, se muestra el botón de desactivar -->
                            @if($liga->enabled)
                            <!-- button para desactivar -->
                            <a title="Pulsa el botón para Desactivar" class="btn btn-success btn-sm" href="{{ route('leagues.disable', ['league' => $liga->id]) }}">
                                <!-- icono prohibido -->
                                Activa
                            </a>
                            @else
                            <!-- button para activar -->
                            <a title="Pulsa el botón para Activar" class="btn btn-danger btn-sm" href="{{ route('leagues.enable', ['league' => $liga->id]) }}">
                                <!-- icono prohibido -->
                                Desactivada
                            </a>
                            @endif
                            @else

                            @if($liga->enabled)
                            <span class="badge badge-success">Activa</span>
                            @else
                            <span class="badge badge-danger">Desactivada</span>
                            @endif
                            @endif

                        </td>
                        @if(Auth::user() && Auth::user()->admin)
                        <td>
                            <!-- si estás logueado como administrador, se muestra el botón de editar. Este botón activa un modal con un formulario para editar la liga -->
                            <button title="Editar" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editarLiga{{ $liga->id }}">
                                <!-- icono de lápiz -->
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <a title="Eliminar" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')" href="{{ route('leagues.delete', ['league' => $liga->id]) }}">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    <!-- Formulario para crear una nueva liga -->
                    <tr>
                        @if(Auth::user() && Auth::user()->admin)

                        <form action="{{ route('leagues.store') }}" method="post">
                            @csrf
                            <td></td>
                            <td><input type="text" name="name" placeholder="nombre" required></td>
                            <td><input type="text" name="description" placeholder="descripcion" required></td>
                            <td><input type="number" name="season_year" placeholder="año de la temporada" required></td>
                            <td></td>
                            <td><button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i>
                                </button></td>
                        </form>
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para editar una liga -->
    @foreach($leagues as $liga)
    <div class="modal fade" id="editarLiga{{ $liga->id }}" tabindex="-1" role="dialog" aria-labelledby="editarLiga{{ $liga->id }}Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('leagues.update', ['league' => $liga->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarLiga{{ $liga->id }}Label">Editar Liga</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="name" value="{{ $liga->name }}" class="form-control" required>
                        <label for="descripcion">Descripción</label>
                        <input type="text" name="description" value="{{ $liga->description }}" class="form-control" required>
                        <lablel for="season_year">Año de la temporada</lablel>
                        <input type="number" name="season_year" value="{{ $liga->season_year }}" class="form-control" required>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Editar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection