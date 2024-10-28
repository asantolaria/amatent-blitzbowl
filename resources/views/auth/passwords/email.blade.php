@extends('layouts.auth')

@section('main-content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5 forgot-password">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image forgot-password"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">{{ __('Olvidaste la contraseña?') }}</h1>
                                </div>

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
                                <p>No disponemos de sistema automático de recuperación de contraseña.</p>
                                <p>Para recuperar tu contraseña habla con el administrador de la aplicación para que la resetee.</p>
                                <p>Disculpa las molestias.</p>

                                <a href="{{ route('login') }}" class="btn btn-primary">Volver</a>


                                <!-- <form method="POST" action="{{ route('password.email') }}" class="user">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" name="email" placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            {{ __('Send Password Reset Link') }}
                                        </button>
                                    </div>
                                </form> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection