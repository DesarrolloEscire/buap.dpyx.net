@extends('layouts.auth')
@section('content')

<div class="card-body">
    <form method="POST" action="/forgot-password">
        @csrf
        <div class="h5 modal-title text-center">
            <h4 class="mt-2">
                <x-jet-validation-errors class="mb-4" />

                <div class="d-flex justify-content-center">
                    <!-- <img src="{{url('images/logo.png')}}" width="120px" class="img-fluid" alt=""> -->
                </div>
                <x-shared.auth-title title="¿Olvidaste tu contraseña?" subtitle="Completa el siguiente formulario para recuperarla">
                    </x-shared>
                @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
                @endif
            </h4>
        </div>
        <div>
            <div class="form-row">
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        <label for="exampleEmail" class="text-uppercase text-muted">Correo</label>
                        <input name="email" id="exampleEmail" type="email" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="divider"></div>
        <h6 class="mb-0">
            <a href="{{route('login')}}" class="auth-form-link">
                Iniciar sesión con una cuenta existente
            </a>
        </h6>
        <div class="modal-footer clearfix">
            <div class="float-right">
                <button class="btn btn-primary btn-lg">Recuperar contraseña</button>
            </div>
        </div>
    </form>
</div>
@endsection