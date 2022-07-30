<div class="mb-4" x-data="data()">
    <form action="{{ route('users.account.store', [$user]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 border-0 shadow card">
            <div class="card-body">
                <div class="row">
                    <div class="mb-3 col-12">
                        <img id="input-logo" src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('images/default/avatars/profile.jpg') }}" class="p-1 mb-3 border">
                        @if ($edit)
                        <label for="" class="text-uppercase text-muted">
                            Foto
                        </label>
                        <div class="custom-file">
                            <input name="file" type="file" class="custom-file-input" id="customFile" x-on:change="onImageSelected(event);">
                            <label class="custom-file-label" for="customFile">seleccionar</label>
                        </div>
                        @endif
                    </div>
                    <div class="mb-3 col-12">
                        <label for="" class="text-uppercase text-muted">
                            Nombre
                        </label>
                        <input name="name" type="text" value="{{ strtoupper($user->name) }}" class="form-control" {{ $edit ? '' : 'disabled' }} required>
                    </div>
                    <div class="mb-3 col-12">
                        <label for="" class="text-uppercase text-muted">
                            E-mail
                        </label>
                        <input name="email" type="email" value="{{ $user->email }}" class="form-control" {{ $edit ? '' : 'disabled' }} required>
                    </div>
                    <div class="mb-3 col-12">
                        <label for="" class="text-uppercase text-muted">
                            Teléfono <small>(opcional)</small>
                        </label>
                        <input name="phone" type="number" value="{{ $user->phone }}" class="form-control" {{ $edit ? '' : 'disabled' }}>
                    </div>

                    {{-- CHECKBOX TO REQUEST FOR A PASSWORD CHANGE --}}

                    @if ($edit)
                    <div class="mb-3 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="change_password" class="custom-control-input" id="changePassword" x-model="changePassword">
                                    <label class="custom-control-label text-uppercase text-muted" for="changePassword">
                                        ¿Cambiar contraseña?
                                    </label>
                                    <template x-if="changePassword">
                                        <div class="mt-3 row">
                                            <div class="mb-3 col-12">
                                                <label for="" class="text-uppercase text-muted">
                                                    Contraseña actual
                                                </label>
                                                <input type="password" class="form-control" name="current_password" required>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label for="" class="text-uppercase text-muted">
                                                    Nueva contraseña
                                                </label>
                                                <input type="password" class="form-control" name="new_password" id="newPassword" required x-on:keyup="validatePassword()">
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label for="" class="text-uppercase text-muted">
                                                    Repetir contraseña
                                                </label>
                                                <input type="password" class="form-control" name="new_password_repeated" id="confirmPassword" required x-on:keyup="validatePassword()">
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
        @if ($edit)
        <div class="d-flex justify-content-end">
            <a href="{{ route('users.account') }}" class="mr-3 btn btn-outline-danger btn-shadow rounded-0">
                <i class="fas fa-window-close"></i> Cancelar
            </a>
            <button class="float-right btn btn-success btn-wide btn-shadow rounded-0">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
        @endif
    </form>

    <script>
        function data() {
            return {
                changePassword: false,


                validatePassword() {
                    newPassword = document.getElementById('newPassword');
                    confirmPassword = document.getElementById('confirmPassword');

                    if (newPassword.value != confirmPassword.value) {
                        confirmPassword.setCustomValidity("No coincide con la nueva contraseña.");
                    } else {
                        confirmPassword.setCustomValidity('');
                    }
                },

                onImageSelected(event) {
                    const files = event.target.files

                    if (files && files[0]) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            document.getElementById('input-logo').setAttribute('src', e.target.result);
                        };

                        reader.readAsDataURL(files[0]);
                    }
                },
            }
        }
    </script>

</div>