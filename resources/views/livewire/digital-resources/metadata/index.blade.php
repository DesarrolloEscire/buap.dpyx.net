<div x-data="data()">

    @section('header')
        <x-page-title title="Metadatos" description="En esta página podrás subir recursos digitales (PDF, Power Point, Word, Excel, Imágenes, Audios, Videos, Sitios Web, etc.) que tengas desarrollados y que NO SON RECURSOS EDUCATIVOS ABIERTOS (REA)">
        </x-page-title>
    @endsection

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm mb-3"
                    style="border-left: 5px solid #eba421 !important; background: #ffd400;">
                    <div class="card-body" style="font-size: 120%">
                        1. Ingrese el texto y de clic en el símbolo +, de lo contrario, no se guardará la información.
                        <br>
                        2. Añada los archivos que se solicitan y verifique que la información ingresada sea correcta.

                    </div>
                </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <x-subnavigation
                :routes="['ver todos los recursos digitales' => route('repositories.digital-resources.index',[$digitalResource->repository]) ]" />
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ $activeSection == 'required' ? 'active' : '' }}"
                        href="{{ route('digital-resources.metadata.required.index', [$digitalResource]) }}">obligatorio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeSection == 'optional' ? 'active' : '' }}"
                        href="{{ route('digital-resources.metadata.optional.index', [$digitalResource]) }}">opcional</a>
                </li>
            </ul>
        </div>
    </div>

    @if ($activeSection == 'required')
        <h3 class="title">
            ARCHIVO
        </h3>
    @endif

    <form id="store-metadata-form" action="{{ route('digital-resources.metadata.update', [$digitalResource]) }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @if ($activeSection == 'required')
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <div class="card card--shadow" style="min-height: 150px">
                        <div class="card-body card-body--secondary">
                            <button type="button" class="btn btn-block btn-info mb-3"
                                x-on:click="document.getElementById('file-input').click()">
                                <small><i class="fas fa-plus"></i></small>
                                cargar archivo
                            </button>
                            <input id="file-input" name="file" type="file" class="form-control mb-3"
                                {{ $digitalResource->files()->exists() ? '' : 'required' }}
                                x-on:change="fileName($event.target)" hidden>

                            <template x-if="newFileName">
                                <div>
                                    <label class="label__header">archivo nuevo</label>
                                    <span class="label label--red text-muted mb-1" x-text="newFileName"></span>
                                </div>
                            </template>

                            @if ($digitalResource->files()->exists())
                                <label class="label__header">archivo actual</label>
                                <a class="label label--primary" href="{{route('files.download',[$digitalResource->files()->first()])}}">
                                    {{ $digitalResource->files()->first()->name }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="card card--shadow" style="min-height: 150px">
                        <div class="card-body card-body--secondary">
                            <label class="text-muted m-0">url</label>
                            <div>
                                <i>dc.identifier.url</i>
                            </div>
                            <input id="url-input" name="url" type="text" class="form-control" value="{{$digitalResource->urls()->first()->value ?? ''}}">
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <h3 class="title">
                    METADATOS
                </h3>
            </div>
            <template x-for="metadata in [...allMetadata]">
                <div class="col-12 col-md-6 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body card-body--primary">
                            <div class="row">
                                <div class="col-12">
                                    <label class="text-muted m-0" x-text="metadata.item.label"></label>
                                    <div>
                                        <i x-text="metadata.item.name"></i>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <template x-for="metadataValue in metadataValues.whereMetadata(metadata).get()">
                                        <div class="input-group mb-3">
                                            <input :value="metadataValue.value"
                                                :name="`metadata[${metadata.item.name}][]`" type="text"
                                                class="form-control" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-danger"
                                                    x-on:click="onDeleteMetadataValue(metadata, metadataValue)"
                                                    type="button">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                    <template x-if="!metadataValues.whereMetadata(metadata).exists()">
                                        <div class="status status--red mb-3">
                                            Ningún metadato añadido
                                        </div>
                                    </template>
                                </div>

                                {{-- INPUT TYPE --}}

                                <div class="col-12">

                                    {{-- ONEBOX INPUT --}}

                                    <template
                                        x-if="metadata.item.input_type == 'onebox' || metadata.item.input_type == 'textarea'">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control"
                                                :placeholder="metadata.item.placeholder" :metadata-id="metadata.item.id"
                                                :validator="metadata.item.name">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-success" type="button"
                                                    x-on:click="onAddMetadataValue(metadata)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </template>

                                    {{-- QUALDROP VALUE INPUT --}}

                                    <template x-if="metadata.item.input_type == 'qualdrop_value'">
                                        <div>

                                            <div class="input-group">
                                                <input class="form-control" list="browsers" name="myBrowser"
                                                    :metadata-id="metadata.item.id" />
                                                <input type="text" class="form-control" :metadata-id="metadata.item.id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-success" type="button"
                                                        x-on:click="onAddMetadataValue(metadata)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <datalist id="browsers">
                                                <template
                                                    x-for="valuePair in valuePairs[metadata.item.value_pair_group]">
                                                    <option :value="valuePair['stored_value']"></option>
                                                </template>
                                            </datalist>
                                        </div>
                                    </template>

                                    {{-- DATE INPUT --}}

                                    <template x-if="metadata.item.input_type == 'date'">
                                        <div class="input-group mb-3">
                                            <input type="date" class="form-control" :metadata-id="metadata.item.id"
                                                :validator="metadata.item.name">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-success" type="button"
                                                    x-on:click="onAddMetadataValue(metadata)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </template>

                                    {{-- DROPDOWN INPUT --}}

                                    <template x-if="metadata.item.input_type == 'dropdown'">
                                        <div class="input-group mb-3">
                                            <select class="form-control" :metadata-id="metadata.item.id"
                                                :validator="metadata.item.name">
                                                <option value="" hidden>seleccionar</option>
                                                <template
                                                    x-for="valuePair in valuePairs[metadata.item.value_pair_group] || []">
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

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div class="row">
            <div class="col-12 col-md-3 mb-3">
                <button type="button" class="btn btn-block btn-success btn-shadow btn-sm" x-on:click="onSave()">
                    <small class="mr-1"><i class="fas fa-save"></i></small>
                    guardar
                </button>
            </div>
        </div>
    </form>


    <script>
        class Iterable {

            constructor(items) {
                this.items = items
            }

            item(item) {
                return item
            }

            static fromJson(json) {
                return new this(JSON.parse(json))
            }

            [Symbol.iterator]() {
                var index = -1;
                var data = this.items;

                return {
                    next: () => ({
                        value: this.item(data[++index]),
                        done: !(index in data)
                    })
                };
            };
        }

    </script>

    <script>
        class Metadata {
            constructor(item) {
                this.item = item
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
                    return metadataValue.metadata_id == metadata.item.id
                }))
            }

            add(metadataId, value) {
                this.json.push({
                    metadata_id: metadataId,
                    value: value,
                })
            }
        }

        class MetadataCollection extends Iterable {
            item(item) {
                return new Metadata(item)
            }

            whereRequired() {
                return new MetadataCollection(this.items.filter(function(metadata) {
                    return metadata.is_required ? true : false
                }))
            }
        }

        function data() {
            return {
                allMetadata: new MetadataCollection(@json($allMetadata)),
                valuePairs: @json($valuePairs),
                metadataValues: new MetadataValues(@json($metadataValues)),
                newFileName: null,

                init() {},

                fileName(input) {
                    this.newFileName = input.files[0].name ?? null
                },

                onAddMetadataValue(metadata) {
                    const newMetadataInputs = document
                        .querySelectorAll(`[metadata-id="${metadata.item.id}"]`)

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
                        .add(metadata.item.id, values.join(";"))

                    newMetadataInputs
                        .forEach(input => input.value = '')
                },

                onDeleteMetadataValue(metadata, metadataValue) {
                    this.metadataValues.delete(metadata, metadataValue)
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

                validateForm() {
                    this.validateMetadataRequired()
                    this.validateFiles()
                },

                validateFiles() {
                    const fileInput = document.getElementById("file-input");
                    const urlInput = document.getElementById("url-input");

                    if (fileInput && fileInput.required && fileInput.files.length == 0 && !urlInput.value) {
                        throw "Falta cargar el archivo o el metadato dc.identifier.url"
                    }
                },

                validateMetadataRequired() {
                    const metadataValues = this.metadataValues

                    for (const metadata of this.allMetadata.whereRequired()) {
                        if (!metadataValues.whereMetadata(metadata).exists()) {
                            throw `el metadato ${metadata.item.name} es obligatorio`
                        }
                    }
                },

                async showMessage(title, text) {
                    Swal.fire({
                        title: title,
                        text: text,
                        icon: 'warning',
                    })
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

                    if (!metadata.item.is_repeatable && this.metadataValues.whereMetadata(metadata).exists()) {
                        throw "Este metadato solamente acepta un valor"
                    }

                    Validator.for(validatorName).validate(newMetadataInput.value)
                },

                showError(title, text) {
                    Swal.fire({
                        icon: 'error',
                        title: title,
                        text: text,
                    })
                },
            }
        }

    </script>

</div>
