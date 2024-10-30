@extends('layouts.admin')

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('About') }}</h1>

<div class="row justify-content-center">

    <div class="col-lg-6">

        <div class="card shadow mb-4">

            <div class="card-profile-image mt-4">
                <img src="{{ asset('img/favicon.ico') }}" class="rounded-circle" alt="user-image">
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <h5 class="font-weight-bold">Blitzbowl - Amatent</h5>
                        <p>Esta aplicación ha sido desarrollada para el club de juegos Amatent: <a href="https://clubamatent.cat" target="_blank">clubamatent.cat</a></p>
                        <p>El objetivo de esta aplicación es gestionar las ligas de blitzbowl con la finalidad de anotar los resultados y gestionar los emparejamientos.</p>
                        <p>La aplicación desarrollada en base al proyecto SB Admin 2 for Laravel.</p>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-lg-12">
                        <h5 class="font-weight-bold">Créditos</h5>
                        <p>Blitzbowl - Amatent utiliza algunas bibliotecas/paquetes de terceros open-source, muchas gracias a la comunidad web.</p>
                        <ul>
                            <li><a href="https://laravel.com" target="_blank">Laravel</a> - Open source framework.</li>
                            <li><a href="https://github.com/DevMarketer/LaravelEasyNav" target="_blank">LaravelEasyNav</a> - Making managing navigation in Laravel easy.</li>
                            <li><a href="https://startbootstrap.com/themes/sb-admin-2" target="_blank">SB Admin 2</a> - Thanks to Start Bootstrap.</li>
                            <li>Desarrollado por <strong>ASantolaria</strong></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

@endsection