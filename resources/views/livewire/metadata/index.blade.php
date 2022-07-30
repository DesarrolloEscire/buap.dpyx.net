<div>

    <div class="row mb-3">
        <div class="col-12">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success btn-sm btn-shadow" data-toggle="modal"
                data-target="#exampleModalCenter">
                <small><i class="fas fa-plus"></i></small> añadir
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Crear metadato</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('metadata.store') }}" class="row" method="POST">
                                @csrf
                                <div class="col-12 mb-3">
                                    <label class="label__header">nombre</label>
                                    <input name="name" type="text" class="form-control" maxlength="190"
                                        placeholder="ej. dc.contributor.author" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="label__header">posición</label>
                                    <input name="position" type="number" step="1" class="form-control"
                                        placeholder="ej. 3" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="label__header">label</label>
                                    <input name="label" type="text" class="form-control"
                                        placeholder="ej. Idioma / Language" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="label__header">hint</label>
                                    <textarea name="hint" id="" cols="30" rows="3" class="form-control" required
                                        placeholder="ej. Seleccionar el idioma o ..."></textarea>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="text-muted">¿es obligatorio?</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_required" value="true">
                                            <label class="form-check-label" for="inlineRadio1">sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_required" value="false">
                                            <label class="form-check-label" for="inlineRadio2">no</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="text-muted">¿es repetible?</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_repeatable" value="true">
                                            <label class="form-check-label" for="inlineRadio1">sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_repeatable" value="false">
                                            <label class="form-check-label" for="inlineRadio2">no</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="label__header">tipo de input</label>
                                    <select class="form-control" name="input_type" required>
                                        <option value="" hidden>seleccionar</option>
                                        <option value="dropdown">dropdown</option>
                                        <option value="twobox">twobox</option>
                                        <option value="name">name</option>
                                        <option value="date">date</option>
                                        <option value="textarea">textarea</option>
                                        <option value="onebox">onebox</option>
                                        <option value="qualdrop_value">qualdrop_value</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="label__header">value pairs (opcional)</label>
                                    <select class="form-control" name="value_pair_group">
                                        <option value="">seleccionar</option>
                                        <option value="languages">languages</option>
                                        <option value="genero">genero</option>
                                        <option value="estrategia">estrategia</option>
                                        <option value="agregación">agregación</option>
                                        <option value="estado">estado</option>
                                        <option value="contributor">contributor</option>
                                        <option value="facultad">facultad</option>
                                        <option value="creative_commons">creative_commons</option>
                                        <option value="rights">rights</option>
                                        <option value="asignaturas">asignaturas</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <hr>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-dismiss="modal">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <button type="submit" class="btn btn-success btn-sm btn-shadow">
                                        <i class="fas fa-plus"></i> guardar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-12 col-sm-6">

            <div class="row">
                <div class="col-12">
                    <h5>Obligatorios</h5>
                </div>
                @forelse ($requiredMetadata as $metadata)
                    <div class="col-12 mb-3">
                        <div class="card card--bordered shadow-sm border-0"
                            style="border-left: 5px solid #ff6666 !important">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="label__header"><b>dublin core</b></label> <br>
                                        <span class="label label--primary">{{ $metadata->name }}</span>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="label__header"><b>tipo de input</b></label> <br>
                                        <span class="label label--primary">{{ $metadata->input_type }}</span>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="label__header"><b>¿es obligatorio?</b></label> <br>
                                        <span
                                            class="label label--primary">{{ $metadata->is_required ? 'sí' : 'no' }}</span>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="label__header"><b>¿es repetible?</b></label> <br>
                                        <span
                                            class="label label--primary">{{ $metadata->is_repeatable ? 'sí' : 'no' }}</span>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="label__header"><b>value pairs</b></label> <br>
                                        <span
                                            class="label label--primary">{{ $metadata->value_pair_group ?? 'N/A' }}</span>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="label__header"><b>posición</b></label> <br>
                                        <span class="label label--primary">{{ $metadata->position ?? 'N/A' }}</span>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="label__header"><b>label</b></label> <br>
                                        <span class="label label--primary">{{ $metadata->label }}</span>
                                    </div>
                                    <div class="col-12 col-md-12 mb-2">
                                        <label class="label__header"><b>hint</b></label> <br>
                                        <span class="label label--primary">{{ $metadata->hint }}</span>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                        <form action="{{ route('metadata.delete', [$metadata]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger float-right">
                                                <i class="fas fa-trash"></i> eliminar
                                            </button>
                                        </form>

                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-warning float-right mr-1"
                                            data-toggle="modal" data-target="#editMetadataModal{{$metadata->id}}">
                                            <small><i class="fas fa-edit"></i></small> editar
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="editMetadataModal{{$metadata->id}}" tabindex="-1" role="dialog"
                                            aria-labelledby="editMetadataModal{{$metadata->id}}Title" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Crear
                                                            metadato</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('metadata.update',[$metadata]) }}" class="row"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="col-12 mb-3">
                                                                <label class="label__header">nombre</label>
                                                                <input value="{{ $metadata->name }}" name="name"
                                                                    type="text" class="form-control" maxlength="190"
                                                                    placeholder="ej. dc.contributor.author" required>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label class="label__header">posición</label>
                                                                <input value="{{ $metadata->position }}" name="position" type="number" step="1"
                                                                    class="form-control" placeholder="ej. 3" required>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label class="label__header">label</label>
                                                                <input value="{{ $metadata->label }}" name="label" type="text" class="form-control"
                                                                    placeholder="ej. Idioma / Language" required>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label class="label__header">hint</label>
                                                                <textarea name="hint" id="" cols="30" rows="3"
                                                                    class="form-control" required
                                                                    placeholder="ej. Seleccionar el idioma o ...">{{ $metadata->hint }}</textarea>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label for="text-muted">¿es obligatorio?</label>
                                                                <div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="is_required" value="true" {{ $metadata->is_required ? 'checked' : '' }}>
                                                                        <label class="form-check-label"
                                                                            for="inlineRadio1">sí</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            {{$metadata->is_required ? '' : 'checked'}} name="is_required" value="false">
                                                                        <label class="form-check-label"
                                                                            for="inlineRadio2">no</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label for="text-muted">¿es repetible?</label>
                                                                <div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="is_repeatable" value="true" {{ $metadata->is_repeatable ? 'checked' : '' }}>
                                                                        <label class="form-check-label"
                                                                            for="inlineRadio1">sí</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" name="is_repeatable" value="false" type="radio" {{$metadata->is_repeatable ? '' : 'checked'}} >
                                                                        <label class="form-check-label"
                                                                            for="inlineRadio2">no</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label class="label__header">tipo de input</label>
                                                                <select class="form-control" name="input_type" required>
                                                                    <option value="" hidden>seleccionar</option>
                                                                    <option {{$metadata->input_type == 'dropdown' ? 'selected' : ''}} value="dropdown">dropdown</option>
                                                                    <option {{$metadata->input_type == 'twobox' ? 'selected' : ''}} value="twobox">twobox</option>
                                                                    <option {{$metadata->input_type == 'name' ? 'selected' : ''}} value="name">name</option>
                                                                    <option {{$metadata->input_type == 'date' ? 'selected' : ''}} value="date">date</option>
                                                                    <option {{$metadata->input_type == 'textarea' ? 'selected' : ''}} value="textarea">textarea</option>
                                                                    <option {{$metadata->input_type == 'onebox' ? 'selected' : ''}} value="onebox">onebox</option>
                                                                    <option {{$metadata->input_type == 'qualdrop_value' ? 'selected' : ''}} value="qualdrop_value">qualdrop_value
                                                                </select>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label class="label__header">value pairs
                                                                    (opcional)</label>
                                                                <select class="form-control" name="value_pair_group">
                                                                    <option value="">ninguno</option>
                                                                    <option {{$metadata->value_pair_group == "languages" ? "selected" : ""}} value="languages">languages</option>
                                                                    <option {{$metadata->value_pair_group == "genero" ? "selected" : ""}} value="genero">genero</option>
                                                                    <option {{$metadata->value_pair_group == "estrategia" ? "selected" : ""}} value="estrategia">estrategia</option>
                                                                    <option {{$metadata->value_pair_group == "agregación" ? "selected" : ""}} value="agregación">agregación</option>
                                                                    <option {{$metadata->value_pair_group == "estado" ? "selected" : ""}} value="estado">estado</option>
                                                                    <option {{$metadata->value_pair_group == "contributor" ? "selected" : ""}} value="contributor">contributor</option>
                                                                    <option {{$metadata->value_pair_group == "facultad" ? "selected" : ""}} value="facultad">facultad</option>
                                                                    <option {{$metadata->value_pair_group == "creative_commons" ? "selected" : ""}} value="creative_commons">creative_commons</option>
                                                                    <option {{$metadata->value_pair_group == "rights" ? "selected" : ""}} value="rights">rights</option>
                                                                    <option {{$metadata->value_pair_group == "asignaturas" ? "selected" : ""}} value="asignaturas">asignaturas</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-12">
                                                                <hr>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-danger"
                                                                    data-dismiss="modal">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                                <button type="submit"
                                                                    class="btn btn-success btn-sm btn-shadow">
                                                                    <i class="fas fa-plus"></i> guardar
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body text-center">
                                <h5 class="text-muted m-0">Ningún metadato</h5>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>

        <div class="col-12 col-sm-6">

            <div class="row">
                <div class="col-12">
                    <h5>opcionales</h5>
                </div>
                @forelse ($optionalMetadata as $metadata)
                    <div class="col-12 mb-3">
                        <div class="card card--bordered shadow-sm border-0"
                            style="border-left: 5px solid #6697ff !important">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="label__header"><b>dublin core</b></label> <br>
                                        <span class="label label--primary">{{ $metadata->name }}</span>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="label__header"><b>tipo de input</b></label> <br>
                                        <span class="label label--primary">{{ $metadata->input_type }}</span>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="label__header"><b>¿es obligatorio?</b></label> <br>
                                        <span
                                            class="label label--primary">{{ $metadata->is_required ? 'sí' : 'no' }}</span>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="label__header"><b>¿es repetible?</b></label> <br>
                                        <span
                                            class="label label--primary">{{ $metadata->is_repeatable ? 'sí' : 'no' }}</span>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="label__header"><b>value pairs</b></label> <br>
                                        <span
                                            class="label label--primary">{{ $metadata->value_pair_group ?? 'N/A' }}</span>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="label__header"><b>posición</b></label> <br>
                                        <span class="label label--primary">{{ $metadata->position ?? 'N/A' }}</span>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="label__header"><b>label</b></label> <br>
                                        <span class="label label--primary">{{ $metadata->label }}</span>
                                    </div>
                                    <div class="col-12 col-md-12 mb-2">
                                        <label class="label__header"><b>hint</b></label> <br>
                                        <span class="label label--primary">{{ $metadata->hint }}</span>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                        <form action="{{ route('metadata.delete', [$metadata]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger float-right">
                                                <i class="fas fa-trash"></i> eliminar
                                            </button>
                                        </form>

                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-warning float-right mr-1"
                                            data-toggle="modal" data-target="#editMetadataModal{{$metadata->id}}">
                                            <small><i class="fas fa-edit"></i></small> editar
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="editMetadataModal{{$metadata->id}}" tabindex="-1" role="dialog"
                                            aria-labelledby="editMetadataModal{{$metadata->id}}Title" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">
                                                            Editar metadato
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('metadata.update',[$metadata]) }}" class="row"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="col-12 mb-3">
                                                                <label class="label__header">nombre</label>
                                                                <input value="{{ $metadata->name }}" name="name"
                                                                    type="text" class="form-control" maxlength="190"
                                                                    placeholder="ej. dc.contributor.author" required>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label class="label__header">posición</label>
                                                                <input value="{{ $metadata->position }}" name="position" type="number" step="1"
                                                                    class="form-control" placeholder="ej. 3" required>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label class="label__header">label</label>
                                                                <input value="{{ $metadata->label }}" name="label" type="text" class="form-control"
                                                                    placeholder="ej. Idioma / Language" required>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label class="label__header">hint</label>
                                                                <textarea name="hint" id="" cols="30" rows="3"
                                                                    class="form-control" required
                                                                    placeholder="ej. Seleccionar el idioma o ...">{{ $metadata->hint }}</textarea>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label for="text-muted">¿es obligatorio?</label>
                                                                <div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="is_required" value="true" {{ $metadata->is_required ? 'checked' : '' }}>
                                                                        <label class="form-check-label"
                                                                            for="inlineRadio1">sí</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            {{$metadata->is_required ? '' : 'checked'}} name="is_required" value="false">
                                                                        <label class="form-check-label"
                                                                            for="inlineRadio2">no</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label for="text-muted">¿es repetible?</label>
                                                                <div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="is_repeatable" value="true" {{ $metadata->is_repeatable ? 'checked' : '' }}>
                                                                        <label class="form-check-label"
                                                                            for="inlineRadio1">sí</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" name="is_repeatable" value="false" type="radio" {{$metadata->is_repeatable ? '' : 'checked'}} >
                                                                        <label class="form-check-label"
                                                                            for="inlineRadio2">no</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label class="label__header">tipo de input</label>
                                                                <select class="form-control" name="input_type" required>
                                                                    <option value="" hidden>seleccionar</option>
                                                                    <option {{$metadata->input_type == 'dropdown' ? 'selected' : ''}} value="dropdown">dropdown</option>
                                                                    <option {{$metadata->input_type == 'twobox' ? 'selected' : ''}} value="twobox">twobox</option>
                                                                    <option {{$metadata->input_type == 'name' ? 'selected' : ''}} value="name">name</option>
                                                                    <option {{$metadata->input_type == 'date' ? 'selected' : ''}} value="date">date</option>
                                                                    <option {{$metadata->input_type == 'textarea' ? 'selected' : ''}} value="textarea">textarea</option>
                                                                    <option {{$metadata->input_type == 'onebox' ? 'selected' : ''}} value="onebox">onebox</option>
                                                                    <option {{$metadata->input_type == 'qualdrop_value' ? 'selected' : ''}} value="qualdrop_value">qualdrop_value</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <label class="label__header">value pairs
                                                                    (opcional)</label>
                                                                <select class="form-control" name="value_pair_group">
                                                                    <option value="">ninguno</option>
                                                                    <option {{$metadata->value_pair_group == "languages" ? "selected" : ""}} value="languages">languages</option>
                                                                    <option {{$metadata->value_pair_group == "genero" ? "selected" : ""}} value="genero">genero</option>
                                                                    <option {{$metadata->value_pair_group == "estrategia" ? "selected" : ""}} value="estrategia">estrategia</option>
                                                                    <option {{$metadata->value_pair_group == "agregación" ? "selected" : ""}} value="agregación">agregación</option>
                                                                    <option {{$metadata->value_pair_group == "estado" ? "selected" : ""}} value="estado">estado</option>
                                                                    <option {{$metadata->value_pair_group == "contributor" ? "selected" : ""}} value="contributor">contributor</option>
                                                                    <option {{$metadata->value_pair_group == "facultad" ? "selected" : ""}} value="facultad">facultad</option>
                                                                    <option {{$metadata->value_pair_group == "creative_commons" ? "selected" : ""}} value="creative_commons">creative_commons</option>
                                                                    <option {{$metadata->value_pair_group == "rights" ? "selected" : ""}} value="rights">rights</option>
                                                                    <option {{$metadata->value_pair_group == "asignaturas" ? "selected" : ""}} value="asignaturas">asignaturas</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-12">
                                                                <hr>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-danger"
                                                                    data-dismiss="modal">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                                <button type="submit"
                                                                    class="btn btn-success btn-sm btn-shadow">
                                                                    <i class="fas fa-plus"></i> guardar
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body text-center">
                                <h5 class="text-muted m-0">Ningún metadato</h5>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>

    </div>

</div>
