@extends('layouts.admin')

@section('main-content')
<div class="container">
    <h2>Administrar Gladiadores</h2>

    <div class="row">
        <a href="{{ route('admin.gladiadores.create', '2') }}" class="btn btn-primary mb-2 mr-2">Crear Gladiador Categoría 2</a>
        <a href="{{ route('admin.gladiadores.create', '3') }}" class="btn btn-primary mb-2 mr-2">Crear Gladiador Categoría 3</a>
        <a href="{{ route('admin.gladiadores.create', '4') }}" class="btn btn-primary mb-2 mr-2">Crear Gladiador Categoría 4</a>
        <a href="{{ route('admin.gladiadores.create', '1') }}" class="btn btn-primary mb-2 mr-2">Crear Gladiador Categoría 1</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- formulario de filtro con border -->

    <div class="row border p-3 mt-3 mb-3">
        <div class="col-lg-6 order-lg-1">
            <form action="{{ route('admin.gladiadores.index') }}" method="GET">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ request('nombre') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="lodis">Lodis</label>
                        <select id="lodis" name="lodis" class="form-control">
                            <option value="">Selecciona...</option>
                            @foreach($lodis as $l)
                            <option value="{{ $l->id }}" {{ request('lodis') == $l->id ? 'selected' : '' }}>{{ $l->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <br>
                        <button type="submit" class="mt-2 btn btn-primary">Filtrar
                            <i class="fas fa-filter"></i>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-12 order-lg-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Lodis</th>
                            <th>Categoría</th>
                            <th class="hover-help" title="Velocidad">VEL</th>
                            <th class="hover-help" title="Fuerza">FUE</th>
                            <th class="hover-help" title="Destreza">DES</th>
                            <th class="hover-help" title="Iniciativa">INI</th>
                            <th class="hover-help" title="Dureza">DUR</th>
                            <th class="hover-help" title="Resistencia">RES</th>
                            <th class="hover-help" title="Inteligencia">INT</th>
                            <th class="hover-help" title="Sabiduría">SAB</th>
                            <th class="hover-help" title="Carisma">CAR</th>
                            <th class="hover-help" title="Puntos de aprendizaje sin asignar">Aprendizaje S/A</th>
                            <th class="hover-help" title="Puntos de atributo sin asignar">Atributos S/A</th>
                            <th class="hover-help">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gladiadores as $gladiador)
                        <tr>
                            <td><a href="{{ route('gladiadores.show', $gladiador->id) }}">{{ $gladiador->nombre }}</a></td>
                            <td>
                                @if($gladiador->lodis)
                                <a href="{{ route('lanista.ver-escuela', ['id' => $gladiador->lodis->id]) }}">{{ $gladiador->lodis->nombre }}</a>
                                @else
                                -
                                @endif
                                </a>
                            </td>
                            <td>{{ $gladiador->categoria }}</td>
                            <td>{{ $gladiador->velocidad }}</td>
                            <td>{{ $gladiador->fuerza }}</td>
                            <td>{{ $gladiador->destreza }}</td>
                            <td>{{ $gladiador->iniciativa }}</td>
                            <td>{{ $gladiador->dureza }}</td>
                            <td>{{ $gladiador->resistencia }}</td>
                            <td>{{ $gladiador->inteligencia }}</td>
                            <td>{{ $gladiador->sabiduria }}</td>
                            <td>{{ $gladiador->carisma }}</td>
                            <td>
                                {{ $gladiador->puntosAprendizajeSinAsignar() }}
                            </td>
                            <td>{{ $gladiador->puntosAtributosSinAsignar()}} / {{$gladiador->puntosAtributosSinAsignarTipo() }}</td>

                            <td>
                                <!-- iconos en la misma línea -->
                                <a href="{{ route('admin.gladiadores.edit', $gladiador->id) }}" class="text-primary mr-2 hover-help" title="Editar Gladiador"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('admin.gladiadores.delete', $gladiador->id) }}" class="text-danger hover-help" title="Eliminar Gladiador"><i class="fas fa-trash"></i></a>


                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- pagination -->
            <div class="d-flex justify-content-center">
                {!! $gladiadores->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection