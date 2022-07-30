<form action="{{ $user ? route('users.update', [$user]) : route('users.store') }}" method="POST">
    @csrf
    @if ($user)
    @method('PUT')
    @endif
    <div class="border-0 shadow card" x-data="data()">
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-12">
                    <label for="" class="label__header">Nombre</label>
                    <input type="text" value="{{ $user ? strtoupper($user->name) : '' }}" name="name" class="form-control" placeholder="Nombre" required>
                </div>
                <div class="mb-3 col-12">
                    <label for="" class="label__header">Correo</label>
                    <input type="email" value="{{ $user ? $user->email : '' }}" name="email" class="form-control" placeholder="Correo" required>
                </div>
                <div class="mb-3 col-12">
                    <label for="" class="label__header">ID</label>
                    <input type="text" value="{{ $user ? $user->identifier : '' }}" name="identifier" class="form-control" placeholder="Identificador" required>
                </div>
                @if (is_null($user))
                <div class="mb-3 col-12">
                    <label for="" class="label__header">Contraseña</label>
                    <input type="password" name="password" minlength="8" class="form-control" placeholder="********" required x-on:keyup="validateNewPassword()" id="newPassword">
                </div>
                <div class="mb-3 col-12">
                    <label for="" class="label__header">Confirmar contraseña</label>
                    <input type="password" name="confirm_password" minlength="8" class="form-control" placeholder="********" required x-on:keyup="validateNewPassword()" id="confirmPassword">
                </div>
                @endif
                <div class="mb-3 col-12">
                    <label for="" class="label__header">Teléfono <small>(opcional)</small></label>
                    <input type="text" value="{{ $user ? $user->phone : '' }}" name="phone" pattern="\+*\d*" class="form-control" placeholder="Teléfono" maxlength="10">
                </div>
                <div class="mb-3 col-12">
                    <label class="label__header">Roles</label>
                    <select name="role" x-ref="roles" x-on:change="checkIfIsUser($refs.roles)" class="form-control" required>
                        <option value="" hidden>seleccionar</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ $user && $user->hasRole($role->id) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <template x-if="isEvaluator">
                    <div class="mb-3 col-12">
                        <label class="label__header">Nivel educativo</label>
                        <select name="educational_level" class="form-control" required>
                            <option value="" hidden>seleccionar</option>
                            <option value="des" {{ $user && $user->evaluator()->exists() && $user->evaluator()->first()->educational_level == 'des' ? 'selected' : '' }}>DES</option>
                            <option value="media_superior" {{ $user && $user->evaluator()->exists() && $user->evaluator()->first()->educational_level == 'media_superior' ? 'selected' : '' }}>Media superior</option>
                        </select>
                    </div>
                </template>
                <template x-if="isUser">
                    <div class="mb-3 col-12">
                        <label for="" class="text-muted text-uppercase">Nombre del REA</label>
                        <input type="text" name="repository_name" id="repository_name" class="form-control" value="{{ $user && $userUseRepository && $user->has_repositories ? $user->repositories()->first()->name : '' }}" required>
                    </div>
                </template>
                <div class="mb-3 col-12">
                    <label class="label__header">Unidad académica</label>
                    <select name="academic_unit_id" id="academic_unit_id" type="text" class="form-control" x-ref="academicUnitRef" x-on:change="randomEvaluator($refs.academicUnitRef)">
                        <option value="" disabled selected>seleccionar</option>
                        @foreach ($academicUnits as $academicUnit)
                        <option value="{{$academicUnit->id}}" {{ ($userAcademicUnitId == $academicUnit->id ? 'selected' : '') }}>{{$academicUnit->name}}</option>
                        @endforeach
                    </select>
                </div>
                @if (config('app.is_evaluable'))
                <template x-if="isUser">
                    <div class="mb-3 col-12">
                        <label for="" class="text-muted text-uppercase">Evaluador</label>
                        <select id="evaluator_id" x-ref="evaluator_id" class="form-control" required x-on:change="setEvalautorValue($refs.evaluator_id)">
                            <option value="" disabled selected>seleccionar</option>
                            @foreach ($evaluators as $evaluator)
                            <option value="{{ $evaluator->id }}" {{ $user && $userUseRepository && $user->repositories()->exists() && $user->repositories()->first()->evaluation->evaluator->id == $evaluator->id ? 'selected' : '' }}>
                            {{ $evaluator->name }}
                            </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="evaluator_id" value="{{ $user && $userUseRepository && $user->repositories()->exists() && $user->repositories()->first()->evaluation->evaluator->id ? $evaluator->id : '' }}">
                    </div>
                </template>
                @endif
                @if ($user)
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
                                            <input type="password" class="form-control" name="new_password" id="newEditedPassword" x-on:keyup="validateEditedPassword()" required minlength="8">
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label for="" class="text-uppercase text-muted">
                                                Repetir contraseña
                                            </label>
                                            <input type="password" class="form-control" name="new_password_repeated" id="confirmEditedPassword" x-on:keyup="validateEditedPassword()" required minlength="8">
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
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('users.index') }}" class="mr-3 btn btn-outline-danger btn-shadow rounded-0">
                <i class="fas fa-window-close"></i> Cancelar
            </a>
            <button class="btn btn-success btn-wide rounded-0 btn-shadow">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </div>

    <script>
        function data() {
            return {
                changePassword: false,
                isUser: parseInt({{ $userUseRepository ? 1 : 0 }}),
                isEvaluator: parseInt({{ $user && $user->is_evaluator ? 1 : 0 }}),
                isAdmin: parseInt({{ $user && $user->is_admin ? 1 : 0 }}),
                hasAcademicUnit: parseInt({{$userAcademicUnitId ? 1: 0}}),
                hasEvaluator: parseInt({{ $user && $userUseRepository && $user->repositories()->exists() && $user->repositories()->first()->evaluation->evaluator->id ? 1: '0' }}),
                checkIfIsUser(rolesInput) {
                    role = rolesInput.options[rolesInput.selectedIndex].text;
                    this.isUser = (role == 'docente' || role == 'coordinador' || role == 'director' || role == 'secretario') ? 1 : 0;
                    this.isEvaluator = role == 'evaluador' ? 1 : 0;
                    this.isAdmin = role == 'administrador' ? 1 : 0;

                    setTimeout(() => {
                        if (this.isUser) {
                            document.querySelector('#repository_name').value = "REA";
                        }
                        
                        if(!this.hasAcademicUnit){
                            document.querySelector('#evaluator_id').value = "";
                            document.querySelector('#academic_unit_id').value = "";
                        }
                    }, 200);
                },

                validateEditedPassword() {
                    newEditedPassword = document.getElementById('newEditedPassword');
                    confirmEditedPassword = document.getElementById('confirmEditedPassword');

                    if (newEditedPassword.value != confirmEditedPassword.value) {
                        confirmEditedPassword.setCustomValidity("No coincide con la nueva contraseña.");
                    } else {
                        confirmEditedPassword.setCustomValidity('');
                    }
                },

                validateNewPassword() {
                    newPassword = document.getElementById('newPassword');
                    confirmPassword = document.getElementById('confirmPassword');

                    if (newPassword.value != confirmPassword.value) {
                        confirmPassword.setCustomValidity("No coincide con la nueva contraseña.");
                    } else {
                        confirmPassword.setCustomValidity('');
                    }
                },
                async randomEvaluator(academicUnitInput) {
                    if (!this.isEvaluator && !this.isAdmin && !this.hasEvaluator) {
                        var educational_level = (['Preparatorias BUAP', 'Bachilleratos BUAP'].includes(academicUnitInput[academicUnitInput.selectedIndex].text)) ? 'media_superior' : 'des';

                        var async_request = await this.$wire.randomSelectedEvaluator(educational_level);
                        var random_evaluator = JSON.parse(async_request);
                        document.querySelector('#evaluator_id').value = random_evaluator.evaluator_id;
                        document.getElementsByName('evaluator_id')[0].value = random_evaluator.evaluator_id;
                    }
                },
                setEvalautorValue(evaluatorInput){
                    var evaluator_id = evaluatorInput[evaluatorInput.selectedIndex].value;
                    document.getElementsByName('evaluator_id')[0].value = evaluator_id;
                }
            }
        }
    </script>

</form>
