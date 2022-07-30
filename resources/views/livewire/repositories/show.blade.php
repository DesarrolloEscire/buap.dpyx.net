<div x-data="data()">
    @section('header')
        <x-page-title title="Mostrar REA" description="En esta sección podrás observar los detalles del REA"></x-page-title>
    @endsection

    @if ($repository->files()->wherePivot('type', 'exelearning')->first())
        <form id="delete-exelearning-file-form" class="d-inline-block"
            action="{{ route('files.delete', [
    $repository->files()->wherePivot('type', 'exelearning')->first(),
]) }}"
            method="POST">
            @csrf
            @method('DELETE')
        </form>
    @endif
    @if ($repository->files()->wherePivot('type', 'web')->first())
        <form id="delete-web-file-form" class="d-inline-block"
            action="{{ route('files.delete', [
    $repository->files()->wherePivot('type', 'web')->first(),
]) }}"
            method="POST">
            @csrf
            @method('DELETE')
        </form>
    @endif
    @if ($repository->files()->wherePivot('type', 'scorm')->first())
        <form id="delete-scorm-file-form" class="d-inline-block"
            action="{{ route('files.delete', [
    $repository->files()->wherePivot('type', 'scorm')->first(),
]) }}"
            method="POST">
            @csrf
            @method('DELETE')
        </form>
    @endif

    <div class="row">
        <div class="col-12 mb-2">
            <div class="label">
                <i class="fas fa-lightbulb" style="background: #c7c7c7; border-radius:50%; padding: 0.3rem"></i>
                El REA que publiques tendrá un Identificador de Objeto Digital
                (<a target="_blank" href="https://www.doi.org/" class="text-info">DOI</a>) y estará
                relacionado
                con tu Identificador Personal (<a target="_blank" href="https://orcid.org/"
                    class="text-info">ORCID</a>), por
                lo que el contenido es responsabilidad exclusiva de
                tu autoría.
            </div>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-3">
            @if (!$repository->is_published)

                <form id="publish-repository-form" action="{{ route('repositories.publish', [$repository]) }}"
                    method="POST">
                    @csrf
                </form>

                <div class="card border-0 shadow-sm mb-3"
                    style="border-left: 5px solid #eba421 !important; background: #ffd400;">
                    <div class="card-body" style="font-size: 120%">
                        1. Ingrese el texto y de clic en el símbolo +, de lo contrario, no se guardará la información.
                        <br>
                        2. Añada los archivos que se solicitan y verifique que la información ingresada sea correcta, ya
                        que una vez publicada no será posible corregir la información.
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-3"
                    style="border-left: 5px solid #eba421 !important; background: #ffd400;">
                    <div class="card-body" style="font-size: 120%">
                        Si desea incrementar la visibilidad de su REA, por favor, complete la información solicitada en
                        "Opcionales". En caso de no responder dicho formulario, la publicación de su REA no se verá
                        afectada.
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-3"
                    style="border-left: 5px solid #eba421 !important; background: #ffd400;">
                    <div class="card-body" style="font-size: 120%">
                        Una vez verificada y guardada la información debe dar clic en el botón "Publicar"
                    </div>
                </div>
            @else
                <div class="card border-0 shadow-sm mb-3"
                    style="border-left: 5px solid #5cd344 !important; background: #c6ffba;">
                    <div class="card-body" style="font-size: 120%">
                        Este REA se encuentra publicado
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <x-repositories.submenu :repository="$repository" :activeSection="$activeSection" />
        </div>
    </div>

    <form id="store-metadata-form" action="{{ route('repositories.metadata.update', [$repository]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row mb-4 d-flex align-items-center">
            @if (!$repository->is_aproved)
                <div class="col-12 col-sm-2">
                    <button type="button" class="btn btn-block btn-sm btn-success btn-shadow float-right"
                        x-on:click="onSave()">
                        <small><i class="fas fa-book-open mr-1"></i></small> guardar
                    </button>
                </div>
            @endif
            @if (!$repository->is_published)
                <div class="col-12 col-sm-2">
                    <button type="button" class="btn btn-block btn-sm btn-shadow btn-success float-right"
                        x-on:click="onPublish()">
                        <small><i class="fa fa-upload mr-1" aria-hidden="true"></i></small>
                        publicar
                    </button>
                </div>
            @endif
            <div>
                <a class="text-info" href="{{route('repositories.digital-resources.index',[$repository])}}" class="float-right">
                    ver recursos digitales ({{$repository->digitalResources()->count()}})
                </a>
            </div>
        </div>


        {{-- METADATA --}}

        <div class="row">

            <div class="col-12">
                <h3>
                    METADATOS
                </h3>
            </div>

            @if ($page ?? false)
                <div class="col-12">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            @for ($pageNumber = 1; $pageNumber <= $totalPages; $pageNumber++)
                                <a href="{{ route('repositories.metadata.optional.index', [$repository, $pageNumber]) }}"
                                    class="btn btn-outline-info {{ $page == $pageNumber ? 'active' : '' }} rounded-0">
                                    {{ $pageNumber }}
                                </a>
                            @endfor
                        </div>
                    </div>
                </div>
            @endif

            {{-- METADATA SIDE --}}
            <div class="col-12">
                <div class="row">
                    <div class="col-12 mb-2">
                        <div class="row">
                            <template x-for="metadata in allMetadata.get()">
                                <div class="col-12 col-md-6 mb-4">
                                    <div class="card border-0 shadow-sm"
                                        style="min-height: 300px; max-height: 300px; overflow-y: scroll;">
                                        <div class="card-body" style="border-left: 5px solid #16aaff !important">
                                            <label class="text-muted m-0" x-text="metadata.label"></label>
                                            <div>
                                                <template x-if="metadata.is_required">
                                                    <span>*</span>
                                                </template>
                                                <i x-text="metadata.name"></i>
                                            </div>
                                            <template
                                                x-for="metadataValue in metadataValues.whereMetadata(metadata).get()">
                                                <div class="input-group mb-3">
                                                    <input :value="metadataValue.value"
                                                        :name="`metadata[${metadata.name}][]`" type="text"
                                                        class="form-control" readonly>
                                                    <div class="input-group-append">
                                                        @if (!$repository->is_aproved)
                                                            <button class="btn btn-outline-danger"
                                                                x-on:click="onDeleteMetadataValue(metadata, metadataValue)"
                                                                type="button">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </template>
                                            <template x-if="!metadataValues.whereMetadata(metadata).exists()">
                                                <div class="status status--red mb-3">
                                                    Ningún metadato añadido
                                                </div>
                                            </template>

                                            {{-- INPUT EMPTY IF THERE ARE NOT RECORDS --}}

                                            <template x-if="!metadataValues.whereMetadata(metadata).exists()">
                                                <input :name="`metadata[${metadata.name}]`" type="text"
                                                    class="form-control" hidden>
                                            </template>
                                            {{-- @endforeach --}}

                                            {{-- INPUT ACCORDING TO THE TYPE --}}

                                            @if (!$repository->is_aproved)
                                                <template
                                                    x-if="metadata.input_type == 'onebox' || metadata.input_type == 'textarea'">
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control"
                                                            :placeholder="metadata.placeholder"
                                                            :metadata-id="metadata.id" :validator="metadata.name">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-success" type="button"
                                                                x-on:click="onAddMetadataValue(metadata)">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </template>

                                                <template x-if="metadata.input_type == 'qualdrop_value'">
                                                    <div>

                                                        <div class="input-group">
                                                            <input class="form-control" list="browsers" name="myBrowser"
                                                                :metadata-id="metadata.id" />
                                                            <input type="text" class="form-control"
                                                                :metadata-id="metadata.id">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-success" type="button"
                                                                    x-on:click="onAddMetadataValue(metadata)">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <datalist id="browsers">
                                                            <template
                                                                x-for="valuePair in valuePairs[metadata.value_pair_group]">
                                                                <option :value="valuePair['stored_value']"></option>
                                                            </template>
                                                        </datalist>
                                                    </div>
                                                </template>

                                                <template x-if="metadata.input_type == 'date'">
                                                    <div class="input-group mb-3">
                                                        <input type="date" class="form-control"
                                                            :metadata-id="metadata.id" :validator="metadata.name">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-success" type="button"
                                                                x-on:click="onAddMetadataValue(metadata)">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </template>

                                                <template x-if="metadata.input_type == 'dropdown'">
                                                    <div class="input-group mb-3">
                                                        <select class="form-control" :metadata-id="metadata.id"
                                                            :validator="metadata.name">
                                                            <option value="" hidden>seleccionar</option>
                                                            <template
                                                                x-for="valuePair in valuePairs[metadata.value_pair_group] || []">
                                                                <option :value="valuePair['stored_value']"
                                                                    x-text="valuePair['displayed_value']"></option>
                                                            </template>
                                                        </select>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-success" type="button"
                                                                x-on:click="onAddMetadataValue(metadata)">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </template>

                                            @endif
                                            <small class="text-muted" x-text="metadata.hint"></small>
                                        </div>
                                    </div>
                                </div>
                            </template>

                        </div>
                    </div>
                </div>
            </div>

            {{-- FOOTER --}}


        </div>

        {{-- FILES FORM --}}
        @if ($activeSection == 'required')
            <div class="row mb-4">

                <div class="col-12">
                    <h3>ARCHIVOS</h3>
                </div>

                <div class="col-12">

                    <div class="row">
                        <div class="col-12 col-md-4 mb-2">
                            <div class="card shadow-sm border-0">
                                <div class="card-body" style="border-left: 5px solid #ff8080 !important">
                                    @if (!$repository->is_aproved)
                                        <label for="" class="text-muted">Sube el archivo eXeLearning</label>

                                        <button type="button" class="btn btn-block btn-sm btn-outline-success mb-3"
                                            x-on:click="onSelectFile('exelearningFile')">
                                            <i class="fas fa-plus"></i> cargar
                                        </button>

                                        <div class="text-center border rounded p-2 mb-3 text-muted"
                                            x-show="newExeLearningFile != null">
                                            <i class="fas fa-file" style="font-size: 30px"></i> <br>
                                            <span x-text="newExeLearningFile"></span>
                                        </div>

                                        <div class="input-group mb-3 d-none">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">subir</span>
                                            </div>
                                            <div class="custom-file">
                                                <input id="exelearningFile" name="exelearning_file" type="file"
                                                    class="custom-file-input" id="exeLearningInputFile" accept=".elp"
                                                    x-on:change="newExeLearningFile = fileName($event)"
                                                    {{ $exeLearningFile ? '' : 'required' }}>
                                                <label class="custom-file-label" for="exeLearningInputFile">seleccionar
                                                    archivo</label>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($exeLearningFile)
                                        <div
                                            class="d-flex justify-content-between align-items-center label label--primary">
                                            <a class="text-info"
                                                href="{{ route('files.download', [$exeLearningFile]) }}">
                                                <small>descargar {{ $exeLearningFile->name ?? '' }}</small>
                                            </a>
                                            @if (!$repository->is_aproved)
                                                <button form="delete-exelearning-file-form"
                                                    class="btn btn-outline-danger float-right">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-2">

                            <div class="card shadow-sm border-0">
                                <div class="card-body" style="border-left: 5px solid #ff8080 !important">

                                    @if (!$repository->is_aproved)
                                        <label for="" class="text-muted">sube el archivo SCORM</label>

                                        <button type="button" class="btn btn-block btn-sm btn-outline-success mb-3"
                                            x-on:click="onSelectFile('scormFile')">
                                            <i class="fas fa-plus"></i> cargar
                                        </button>

                                        <div class="text-center border rounded p-2 mb-3 text-muted"
                                            x-show="newScormFile != null">
                                            <i class="fas fa-file" style="font-size: 30px"></i> <br>
                                            <span x-text="newScormFile"></span>
                                        </div>

                                        {{-- INPUT --}}

                                        <div class="input-group mb-3 d-none">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">subir</span>
                                            </div>
                                            <div class="custom-file">
                                                <input id="scormFile" name="scorm_file" accept=".zip" type="file"
                                                    class="custom-file-input" id="scormInputFile"
                                                    x-on:change="newScormFile = fileName($event)"
                                                    {{ $scormFile ? '' : 'required' }}>
                                                <label class="custom-file-label" for="scormInputFile">
                                                    seleccionar archivo
                                                </label>
                                            </div>
                                        </div>
                                    @endif



                                    @if ($scormFile)
                                        <div
                                            class="d-flex justify-content-between align-items-center label label--primary">
                                            <a class="text-info" href="{{ route('files.download', [$scormFile]) }}">
                                                <small>descargar {{ $scormFile->name }}</small>
                                            </a>
                                            @if (!$repository->is_aproved)
                                                <button form="delete-scorm-file-form"
                                                    class="btn btn-outline-danger float-right">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-2">

                            <div class="card shadow-sm border-0">
                                <div class="card-body" style="border-left: 5px solid #ff8080 !important">

                                    @if (!$repository->is_aproved)
                                        <label for="" class="text-muted">
                                            Sube el archivo de página web
                                        </label>

                                        <button type="button" class="btn btn-block btn-sm btn-outline-success mb-3"
                                            x-on:click="onSelectFile('webFile')">
                                            <i class="fas fa-plus"></i> cargar
                                        </button>

                                        <div class="text-center border rounded p-2 mb-3 text-muted"
                                            x-show="newWebFile != null">
                                            <i class="fas fa-file" style="font-size: 30px"></i> <br>
                                            <span x-text="newWebFile"></span>
                                        </div>

                                        {{-- INPUT --}}

                                        <div class="input-group mb-3 d-none">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">subir</span>
                                            </div>
                                            <div class="custom-file">
                                                <input id="webFile" name="web_file" type="file"
                                                    class="custom-file-input" id="webInputFile" accept=".zip"
                                                    x-on:change="newWebFile = fileName($event)"
                                                    {{ $webFile ? '' : 'required' }}>
                                                <label class="custom-file-label" for="webInputFile">seleccionar
                                                    archivo</label>
                                            </div>
                                        </div>

                                    @endif

                                    @if ($webFile)
                                        <div
                                            class="d-flex justify-content-between align-items-center label label--primary">
                                            <a class="text-info" href="{{ route('files.download', [$webFile]) }}">
                                                <small>descargar {{ $webFile->name }}</small>
                                            </a>
                                            @if (!$repository->is_aproved)
                                                <button form="delete-web-file-form"
                                                    class="btn btn-outline-danger float-right">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    @endif

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        @endif

        <div class="row mb-4">
            @if (!$repository->is_aproved)
                <div class="col-12 col-md-2">
                    <button type="button" class="btn btn-block btn-sm btn-success btn-shadow float-right"
                        x-on:click="onSave()">
                        <small><i class="fas fa-book-open mr-1"></i></small> guardar
                    </button>
                </div>
            @endif
            @if (!$repository->is_published)
                <div class="col-12 col-sm-2">
                    <button type="button" class="btn btn-block btn-sm btn-shadow btn-success float-right"
                        x-on:click="onPublish()">
                        <small><i class="fa fa-upload mr-1" aria-hidden="true"></i></small>
                        publicar
                    </button>
                </div>
            @endif
        </div>

    </form>

    <script>
        class MetadataCollection {
            constructor(json) {
                this.json = json
            }

            first() {
                return this.json[0]
            }

            get() {
                return this.json
            }

            whereRequired() {
                return new MetadataCollection(this.json.filter(function(metadata) {
                    return metadata.is_required ? true : false
                }))
            }
        }

        class MetadataValues {
            constructor(json) {
                this.json = json
            }

            get() {
                return this.json
            }

            first() {
                return this.json[0]
            }

            delete(metadata, metadataValueToDelete) {
                this.json = this.json.filter(function(metadataValue) {

                    if (metadataValue.metadata_id != metadataValueToDelete.metadata_id) {
                        return true
                    }

                    if (metadataValue.value != metadataValueToDelete.value) {
                        return true
                    }

                    return false
                })
            }

            exists() {
                return this.json.length > 0
            }

            whereValue(value) {
                return new MetadataValues(this.json.filter(function(metadataValue) {
                    return metadataValue.value == value
                }))
            }

            whereMetadata(metadata) {
                return new MetadataValues(this.json.filter(function(metadataValue) {
                    return metadataValue.metadata_id == metadata.id
                }))
            }

            add(metadataId, value) {
                this.json.push(
                    new Proxy({
                        metadata_id: metadataId,
                        value: value,
                    }, {})
                )
            }
        }

        function data() {
            return {

                newExeLearningFile: null,
                newScormFile: null,
                newWebFile: null,

                allMetadata: new MetadataCollection(@json($allMetadata)),
                metadataValues: new MetadataValues(@json($metadataValues)),
                valuePairs: @json($valuePairs),

                init() {},

                fileName(event) {

                    const files = event.target.files

                    if (!files) {
                        return null
                    }

                    if (!files[0]) {
                        return null
                    }

                    return files[0].name

                },

                onDeleteMetadataValue(metadata, metadataValue) {
                    this.metadataValues.delete(metadata, metadataValue)
                },

                onAddMetadataValue(metadata) {
                    const newMetadataInputs = document
                        .querySelectorAll(`[metadata-id="${metadata.id}"]`)

                    try {
                        newMetadataInputs.forEach(newMetadataInput => {
                            this.validateMetadataInput(metadata, newMetadataInput)
                        })
                    } catch (error) {
                        this.showError("¡Ups!", error)
                        return
                    }

                    const values = Array
                        .from(newMetadataInputs)
                        .map((input) => input.value)

                    this.metadataValues
                        .add(metadata.id, values.join(";"))


                    newMetadataInputs
                        .forEach(input => input.value = '')
                },

                validateMetadataInput(metadata, newMetadataInput) {
                    const validatorName = newMetadataInput.getAttribute('validator')

                    if (!newMetadataInput.value) {
                        throw "Por favor, completa el campo para que pueda ser añadido"
                    }

                    const newValueAlreadyExists = this
                        .metadataValues
                        .whereMetadata(metadata)
                        .whereValue(newMetadataInput.value)
                        .exists()

                    if (newValueAlreadyExists) {
                        throw "Este campo ya se encuentra agregado"
                    }

                    if (!metadata.is_repeatable && this.metadataValues.whereMetadata(metadata).exists()) {
                        throw "Este metadato solamente acepta un valor"
                    }

                    Validator.for(validatorName).validate(newMetadataInput.value)
                },

                onSave() {
                    try {
                        this.validateForm()
                    } catch (error) {
                        this.showError('¡Ups!', error)
                        return
                    }

                    this.showMessage('Guardando cambios', 'esta acción puede tardar algunos segundos')
                    document.getElementById("store-metadata-form").submit()
                },

                async showMessage(title, text) {
                    Swal.fire({
                        title: title,
                        text: text,
                        icon: 'warning',
                    })
                },

                onPublish() {
                    this.showConfirmationMessage()
                },

                showConfirmationMessage() {

                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-outline-danger mr-1'
                        },
                        buttonsStyling: false
                    }).fire({
                        title: '¿Estás seguro de realizar la publicación?',
                        text: "Asegúrate de haber guardado todos los metadatos, ya que esta acción no podrá ser revertida",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, adelante',
                        cancelButtonText: 'No, cancelar',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById("publish-repository-form").submit()
                        } else if (
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            swalWithBootstrapButtons.fire(
                                'Cancelled',
                                'Your imaginary file is safe :)',
                                'error'
                            )
                        }
                    })
                },

                validateForm() {
                    this.validateMetadataRequired()
                    this.validateFiles()
                },

                validateFiles() {

                    const exeLearningFileInput = document.getElementById("exelearningFile");

                    if (exeLearningFileInput.required && exeLearningFileInput.files.length == 0) {
                        throw "Falta cargar el archivo exelearning"
                    }

                    const scormFileInput = document.getElementById("scormFile");

                    if (scormFileInput.required && scormFileInput.files.length == 0) {
                        throw "Falta cargar el archivo scorm"
                    }

                    const webFileInput = document.getElementById("webFile");

                    if (webFileInput.required && webFileInput.files.length == 0) {
                        throw "Falta cargar el archivo web"
                    }
                },

                validateMetadataRequired() {
                    const metadataValues = this.metadataValues
                    this.allMetadata.whereRequired().get().forEach((metadata) => {
                        if (!metadataValues.whereMetadata(metadata).exists()) {
                            throw `el metadato ${metadata.name} es obligatorio`
                        }
                    })
                },

                onSelectFile(fileInput) {
                    document.getElementById(fileInput).click()
                },

                showError(title, text) {
                    Swal.fire({
                        icon: 'error',
                        title: title,
                        text: text,
                    })
                }
            }
        }

    </script>

</div>
