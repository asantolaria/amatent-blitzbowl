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
<h2>Información de Juego</h2>

<div class="row">

    <div class="col-md-12 mb-3">
        <h3>Mejoras de Habilidades Básicas</h3>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTableHabilidadesBasicasArmas" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mejora</th>
                        <th>Requisito</th>
                        <th>Efecto</th>
                        @if(auth()->user()->admin)
                        <th>Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($mejorasHabilidadesBasicas as $hba)
                    <tr>
                        <td>{{ $hba->id }}</td>
                        <td>{{ $hba->mejora }}</td>
                        <td>{{ $hba->requisito }}</td>
                        <td>{{ $hba->efecto }}</td>
                        @if(auth()->user()->admin)
                        <td>
                            <a class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')" href="{{ route('mejora-habilidad-basica.eliminar', ['id' => $hba->id]) }}">Eliminar</a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    @if(auth()->user()->admin)
                    <!-- Formulario para crear una nueva mejora habilidad básica  -->
                    <tr>
                        <form action="{{ route('mejora-habilidad-basica.crear') }}" method="post">
                            @csrf
                            <td></td>
                            <td><input type="text" name="mejora" placeholder="mejora" required></td>
                            <td><input type="text" name="requisito" placeholder="requisito" required></td>
                            <td><input type="text" name="efecto" placeholder="efecto" required></td>
                            <td><button type="submit" class="btn btn-success btn-sm">Crear</button></td>
                        </form>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-12 mb-3">
        <h3>Habilidades Especificas</h3>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTableHabilidadesEspecificasArmas" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Requisito</th>
                        <th>Maestría</th>
                        <th>Mejoras</th>
                        @if(auth()->user()->admin)
                        <th>Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($habilidadesEspecificasArmas as $hea)
                    <tr>
                        <td>{{ $hea->id }}</td>
                        <td>{{ $hea->nombre }}</td>
                        <td>{{ $hea->tipo }}</td>
                        <td>{{ $hea->requisito }}</td>
                        <td>{{ $hea->maestria }}</td>
                        <!-- Mejoras es un json. Mostrar nivel y descripción e cada mejora -->
                        <td>
                            @foreach(json_decode($hea->mejoras) as $mejora)
                            <p>{{ $mejora->nivel }}: {{ $mejora->descripcion }}</p>
                            @endforeach
                        </td>
                        @if(auth()->user()->admin)
                        <td>
                            <a class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')" href="{{ route('habilidad-especifica-arma.eliminar', ['id' => $hea->id]) }}">Eliminar</a>

                        </td>
                        @endif
                    </tr>
                    @endforeach
                    <!-- @if(auth()->user()->admin)
                    <tr>
                        <form action="{{ route('habilidad-especifica-arma.crear') }}" method="post">
                            @csrf
                            <td></td>
                            <td><input type="text" name="tipo" placeholder="tipo" required></td>
                            <td><input type="text" name="requisito" placeholder="requisito" required></td>
                            <td><input type="text" name="maestria" placeholder="maestria" required></td>
                            <td><input type="text" name="mejoras" placeholder="mejoras" required></td>
                            <td><button type="submit" class="btn btn-success btn-sm">Crear</button></td>
                        </form>
                    </tr>
                    @endif -->
                </tbody>
            </table>
        </div>


        <div class="col-md-12 mb-3">
            <h3>Lesiones</h3>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTableLesiones" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            @if(auth()->user()->admin)
                            <th>Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lesiones as $lesion)
                        <tr>
                            <td>{{ $lesion->id }}</td>
                            <td>{{ $lesion->nombre }}</td>
                            <td>{{ $lesion->descripcion }}</td>
                            @if(auth()->user()->admin)
                            <td>
                                <a class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')" href="{{ route('lesion.eliminar', ['id' => $lesion->id]) }}">Eliminar</a>

                            </td>
                            @endif
                        </tr>
                        @endforeach
                        @if(auth()->user()->admin)
                        <!-- Formulario para crear una nueva lesion -->
                        <tr>
                            <form action="{{ route('lesion.crear') }}" method="post">
                                @csrf
                                <td></td>
                                <td><input type="text" name="nombre" placeholder="nombre" required></td>
                                <td><input type="text" name="descripcion" placeholder="descripcion" required></td>
                                <td><button type="submit" class="btn btn-success btn-sm">Crear</button></td>
                            </form>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>



        <div class="col-md-12 mb-3">
            <h3>Tipos Arena</h3>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTableTiposArena" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Dinero Contrato</th>
                            <th>Dinero por Gladiador</th>
                            <th>Dinero por Fama</th>
                            <th>Límite por Fama</th>
                            <!-- Puedes ajustar las columnas según tus necesidades -->
                            @if(auth()->user()->admin)
                            <!-- <th>Acciones</th> -->
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tiposArena as $tipoArena)
                        <tr>
                            <td>{{ $tipoArena->id }}</td>
                            <td>{{ $tipoArena->nombre }}</td>
                            <td>{{ $tipoArena->dinero_contrato }}</td>
                            <td>{{ $tipoArena->dinero_por_gladiador }}</td>
                            <td>{{ $tipoArena->dinero_por_fama }}</td>
                            <td>{{ $tipoArena->limite_por_fama }}</td>
                            @if(auth()->user()->admin)
                            <!-- <th>Acciones</th> -->
                            @endif
                        </tr>
                        @endforeach

                    </tbody>
                </table>


            </div>
        </div>


    </div>
    @endsection