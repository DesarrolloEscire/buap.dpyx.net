@extends('layouts.auth')

@section('content')

<div class="card-body p-0">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="row">
            <div class="col-lg-6 d-none d-lg-block" style="background: url({{ asset('images/dashboard/others/dashboard-logo.png') }}); background-position: center; background-size: 95%; background-repeat: no-repeat;"></div>
            <div class="col-lg-6">
                <div class="p-5">
                    <x-jet-validation-errors class="mb-4" />

                    <x-shared.auth-title title="¡Bienvenido!" subtitle=""></x-shared>

                    <form class="user">
                        <div class="form-group">
                            <label for="" class="text-muted m-0"><small>ID</small></label>
                            <input type="text" class="form-control form-control-user @error('identifier') is-invalid @enderror" id="identifier" name="identifier" placeholder="ID" value="{{ old('identifier') }}" required autocomplete="identifier" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="" class="text-muted m-0"><small>Password</small></label>
                            <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="password" placeholder="Password" name="password" required autocomplete="current-password">
                        </div>
                        @if (session('status'))
                        <div class="mb-4 text-sm font-medium text-green-600">
                            {{ session('status') }}
                        </div>
                        @endif
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Iniciar sesión
                        </button>
                        <hr>
                        <div class="d-inline auth-form-links">
                            @if (Route::has('password.request'))
                            <a class="auth-form-link small float-left" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                            @endif
                            <a class="auth-form-link small float-right" href="{{ route('users.register') }}">Registrarme</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection