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

<h2>Listado de Jornadas</h2>

<!-- Tabla de jornadas -->
<div class="container">

    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="table-responsive">
                <table class="table table-striped" id="dataTableJornadas" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Descripction</th>
                            <th>Fecha</th>
                            <th>Liga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matchdays as $matchday)
                        <tr>
                            <td>
                                <!-- link a la página de la jornada -->
                                <a href="{{ route('matchdays.show', ['matchday' => $matchday->id]) }}">{{ $matchday->description }}</a>
                            </td>
                            <td>{{ $matchday->date }}</td>
                            <td>
                                <!-- link a la página de la liga -->
                                <a href="{{ route('leagues.show', ['league' => $matchday->league->id]) }}">{{ $matchday->league->name }}</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection