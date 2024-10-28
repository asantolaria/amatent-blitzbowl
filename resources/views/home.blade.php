@extends('layouts.admin')

@section('main-content')
<div class="container">


    <h1>Gestor de ligas <strong>Blitzbowl - Amatent</strong></h1>
    </br>

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

    @if (session('status'))
    <div class="alert alert-success border-left-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <div class="container">

        <div class="card shadow mb-4">


            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <h5 class="font-weight-bold">Blitzbowl - Amatent</h5>
                        <p>
                        <ul>
                            <li><b>Entrenador</b>: Persona que dirige un equipo de Blitzbowl.</li>
                            <li><b>Equipo</b>: Conjunto de jugadores y personal de apoyo que compiten en un torneo de Blitzbowl.</li>
                            <li><b>Partido</b>: Encuentro entre dos equipos de Blitzbowl.</li>
                            <li><b>Liga</b>: Competición en la que participan varios equipos de Blitzbowl.</li>
                            <li><b>Jornada</b>: Ronda de partidos en una liga de Blitzbowl.</li>
                            <li><b>Clasificación</b>: Tabla que muestra la posición de los equipos en una liga de Blitzbowl.</li>
                            <li><b>Emparejamiento</b>: Asignación de los equipos que se enfrentan en una jornada de una liga de Blitzbowl.</li>
                            <li><b>Resultado</b>: Marcador final de un partido de Blitzbowl.</li>
                            <li><b>Usuarios</b>: Administradores de la aplicación para gestionar las ligas de Blitzbowl.</li>
                        </ul>
                        <p>
                    </div>
                </div>

                <hr>

                <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="{{ asset('img/blitzbowl-amatent.png') }}" alt="">
                </div>

            </div>
        </div>

    </div>


    @endsection