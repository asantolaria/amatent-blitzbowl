<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Blitzbowl Amatent">
    <meta name="author" content="Alejandro SR">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Blitzbowl Amatent') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/blitzbowl.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon" type="image/png">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center amatent-bg-color" href="/">
                <div class="sidebar-brand-icon">
                    <img src="{{ asset('img/ball.png') }}" alt="Blitzbowl" class="img-fluid" style="width: 150px;">
                </div>
                <div class="sidebar-brand-text mx-3">Blitzbowl - Amatent</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ Nav::isRoute('home') }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-fw fa-home"></i>
                    <span>{{ __('Inicio') }}</span>
                </a>
            </li>

            <!-- Nav Item - Ligas -->
            <li class="nav-item {{ Nav::isRoute(['leagues.index']) }}">
                <a class="nav-link" href="{{ route('leagues.index') }}">
                    <i class="fas fa-trophy"></i>
                    <span>{{ __('Ligas') }}</span>
                </a>
            </li>

            <!-- Nav Item - Equipos -->
            <li class="nav-item {{ Nav::isRoute(['teams.index']) }}">
                <a class="nav-link" href="{{ route('teams.index') }}">
                    <i class="fas fa-users"></i>
                    <span>{{ __('Equipos') }}</span>
                </a>
            </li>

            <!-- Nav Item - Entrenadores -->
            <li class="nav-item {{ Nav::isRoute(['coaches.index']) }}">
                <a class="nav-link" href="{{ route('coaches.index') }}">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>{{ __('Entrenadores') }}</span>
                </a>
            </li>

            <!-- Nav Item - Jornadas -->
            <li class="nav-item {{ Nav::isRoute(['matchdays.index']) }}">
                <a class="nav-link" href="{{ route('matchdays.index') }}">
                    <i class="fas fa-calendar-day"></i>
                    <span>{{ __('Jornadas') }}</span>
                </a>
            </li>

            <!-- Nav Item - Partidos -->
            <li class="nav-item {{ Nav::isRoute(['games.index']) }}">
                <a class="nav-link" href="{{ route('games.index') }}">
                    <i class="fas fa-football-ball"></i>
                    <span>{{ __('Partidos') }}</span>
                </a>
            </li>

            @if(Auth::user() && Auth::user()->admin)
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                {{ __('Administrador') }}
            </div>

            <!-- Nav Item - Gestión de Usuarios -->
            <li class="nav-item {{ Nav::isRoute(['admin.usuarios.index', 'admin.usuarios.create', 'admin.usuarios.edit']) }}">
                <a class="nav-link" href="{{ route('admin.usuarios.index') }}">
                    <i class="fas fa-users-cog"></i>
                    <span>{{ __('Gestión Usuarios') }}</span>
                </a>
            </li>
            @endif

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                {{ __('Configuración') }}
            </div>

            @if(Auth::user())
            <!-- Nav Item - Profile -->
            <li class="nav-item {{ Nav::isRoute('profile') }}">
                <a class="nav-link" href="{{ route('profile') }}">
                    <i class="fas fa-fw fa-user"></i>
                    <span>{{ __('Perfil') }}</span>
                </a>
            </li>
            @endif

            <!-- Nav Item - About -->
            <li class="nav-item {{ Nav::isRoute('about') }}">
                <a class="nav-link" href="{{ route('about') }}">
                    <i class="fas fa-fw fa-info-circle"></i>
                    <span>{{ __('Créditos') }}</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            @if(Auth::user())
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <figure class="img-profile rounded-circle avatar font-weight-bold" data-initial="{{ Auth::user()->name[0] }}"></figure>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('Perfil') }}
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('Logout') }}
                                </a>
                            </div>
                            @else
                            <!-- button to login with icon -->
                            <a class="btn btn-primary" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i>
                                <span class="d-none d-lg-inline ml-2">{{ __('Login') }}</span>
                            </a>
                            @endif
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('main-content')
                    @stack('scripts')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; <a href="https://github.com/asantolaria" target="_blank">ASantolaria</a> {{ now()->year }}</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('¿Quiere cerrar sesión?') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecciona "Logout" para finalizar tu sesión.</div>
                <div class="modal-footer">
                    <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Cancelar') }}</button>
                    <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />

    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

</body>

</html>