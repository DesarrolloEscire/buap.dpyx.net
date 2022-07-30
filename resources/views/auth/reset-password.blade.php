@extends('layouts.auth')

@section('content')
<div class="card-body p-0">
    <form method="POST" action="/reset-password">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="modal-body">
            <div class="h5 modal-title text-center">
                <h4 class="mt-2">


                    <div class="d-flex justify-content-center">
                        <img src="{{ url('images/logo.png') }}" width="120px" class="img-fluid" alt="">
                    </div>
                    <div>Modifica tu contraseña,</div>
                    <span>Completa y envía el formulario.</span>
                    @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                    @endif
                </h4>
            </div>

            <div class="form-row">
                <div class="col-md-12">
                    <label for="" class="text-uppercase text-muted">Correo</label>
                    <div class="position-relative form-group">
                        <input name="email" id="exampleEmail" type="email" value="{{ old('email', $request->email) }}" class="form-control" readonly required autofocus>
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="" class="text-uppercase text-muted">Contraseña</label>
                    <div class="position-relative form-group"><input name="password" id="examplePassword" placeholder="Password" type="password" class="form-control" required autocomplete="new-password"></div>
                </div>
                <div class="col-md-12">
                    <label for="" class="text-uppercase text-muted">Confirmar
                        contraseña</label>
                    <div class="position-relative form-group"><input name="password_confirmation" required placeholder="confirmar contraseña" autocomplete="new-password" type="password" class="form-control"></div>
                </div>
            </div>
            <div class="divider"></div>
        </div>
        <div class="modal-footer clearfix">
            <div class="float-right">
                <button class="btn btn-primary btn-lg">Cambiar contraseña</button>
            </div>
        </div>
    </form>
</div>
@endsection