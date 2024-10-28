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

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="container">
    <h2>Crear/Editar Gladiador</h2>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="row">
        <div class="col-lg-6 order-lg-6">
            <div class="card-body">
                <form action="{{ route('admin.gladiadores.store') }}" method="POST">
                    @csrf
                    <!-- hidden gladiador id si existe  -->
                    <input type="hidden" name="gladiador_id" value="{{$gladiador->id}}">

                    <div class="form-group row">
                        <label for="nombre" class="col-sm-6 col-form-label">Nombre</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="{{$gladiador->nombre}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lodis_id" class="col-sm-6 col-form-label">Lodis (propietario)</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="lodis_id" name="lodis_id">
                                <option value="">-</option>
                                @foreach($lodis as $l)
                                @if($l->id == $gladiador->lodis_id)
                                <option value="{{$l->id}}" selected>{{$l->nombre}}</option>
                                @else
                                <option value="{{$l->id}}">{{$l->nombre}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="mote" class="col-sm-6 col-form-label">Mote</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="mote" name="mote" placeholder="Mote" value="{{$gladiador->mote}}">
                        </div>
                    </div>

                    <div class="form-group  row">
                        <label for="raza" class="col-sm-6 col-form-label">Raza</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="raza" name="raza" placeholder="Raza" value="{{$gladiador->raza}}">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="condicion_social" class="col-sm-6 col-form-label">Condición Social</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="condicion_social" name="condicion_social" placeholder="Condición Social" value="{{$gladiador->condicion_social}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="estado_fisico" class="col-sm-6 col-form-label">Estado Físico</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="estado_fisico" name="estado_fisico" placeholder="Estado Físico" value="{{$gladiador->estado_fisico}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="miniatura" class="col-sm-6 col-form-label">Miniatura</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="miniatura" name="miniatura" placeholder="Miniatura" value="{{$gladiador->miniatura}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="categoria" class="col-sm-6 col-form-label">Categoría</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="categoria" name="categoria" placeholder="Categoría" value="{{$gladiador->categoria}}">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="precio_venta" class="col-sm-6 col-form-label">Precio de Venta</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="precio_venta" name="precio_venta" placeholder="Precio de Venta" value="{{$gladiador->precio_venta}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="precio_subasta" class="col-sm-6 col-form-label">Precio de Subasta</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="precio_subasta" name="precio_subasta" placeholder="Precio de Subasta" value="{{$gladiador->precio_subasta}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="velocidad" class="col-sm-6 col-form-label">Velocidad</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="velocidad" name="velocidad" placeholder="Velocidad" value="{{$gladiador->velocidad}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fuerza" class="col-sm-6 col-form-label">Fuerza</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="fuerza" name="fuerza" placeholder="Fuerza" value="{{$gladiador->fuerza}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="destreza" class="col-sm-6 col-form-label">Destreza</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="destreza" name="destreza" placeholder="Destreza" value="{{$gladiador->destreza}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="iniciativa" class="col-sm-6 col-form-label">Iniciativa</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="iniciativa" name="iniciativa" placeholder="Iniciativa" value="{{$gladiador->iniciativa}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="dureza" class="col-sm-6 col-form-label">Dureza</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="dureza" name="dureza" placeholder="Dureza" value="{{$gladiador->dureza}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="resistencia" class="col-sm-6 col-form-label">Resistencia</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="resistencia" name="resistencia" placeholder="Resistencia" value="{{$gladiador->resistencia}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inteligencia" class="col-sm-6 col-form-label">Inteligencia</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="inteligencia" name="inteligencia" placeholder="Inteligencia" value="{{$gladiador->inteligencia}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="sabiduria" class="col-sm-6 col-form-label">Sabiduría</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="sabiduria" name="sabiduria" placeholder="Sabiduría" value="{{$gladiador->sabiduria}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="carisma" class="col-sm-6 col-form-label">Carisma</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="carisma" name="carisma" placeholder="Carisma" value="{{$gladiador->carisma}}">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="puja_lodis" class="col-sm-6 col-form-label">Última Lodis que ha pujado</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="puja_lodis" name="puja_lodis">
                                <option value="">-</option>
                                @foreach($lodis as $l)
                                @if($l->id == $gladiador->puja_lodis)
                                <option value="{{$l->id}}" selected>{{$l->nombre}}</option>
                                @else
                                <option value="{{$l->id}}">{{$l->nombre}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="puja_fecha_fin" class="col-sm-6 col-form-label">Puja Fecha Fin</label>
                        <div class="col-sm-6">
                            <input type="date" class="form-control" id="puja_fecha_fin" name="puja_fecha_fin" placeholder="Puja Fecha Fin" value="{{$gladiador->puja_fecha_fin}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="puja_finalizada" class="col-sm-6 col-form-label">Puja Finalizada</label>
                        <div class="col-sm-6">
                            <!-- checkbox -->
                            @if($gladiador->puja_finalizada)
                            <input type="checkbox" id="puja_finalizada" name="puja_finalizada" checked>
                            @else
                            <input type="checkbox" id="puja_finalizada" name="puja_finalizada">
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="puntos_aprendizaje_sin_asignar" class="col-sm-6 col-form-label">Puntos de Aprendizaje sin Asignar</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="puntos_aprendizaje_sin_asignar" name="puntos_aprendizaje_sin_asignar" placeholder="Puntos de Aprendizaje sin Asignar" value="{{$gladiador->puntos_aprendizaje_sin_asignar}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="heridas_provocadas" class="col-sm-6 col-form-label">Heridas Provocadas</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="heridas_provocadas" name="heridas_provocadas" placeholder="Heridas Provocadas" value="{{$gladiador->heridas_provocadas}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="muertes_provocadas" class="col-sm-6 col-form-label">Muertes Provocadas</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="muertes_provocadas" name="muertes_provocadas" placeholder="Muertes Provocadas" value="{{$gladiador->muertes_provocadas}}">
                        </div>
                    </div>



                    <button type="submit" class="btn btn-primary">Guardar Gladiador</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection