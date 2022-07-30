<div class="shadow mb-2" x-data="data()" x-init="init()">

    <x-courses.panel.main-menu :title="$course->title" subtitle="Bienvenida">
        <div class="row bg-white">
            <div class="col-12 py-3">
                <h2 class="text-center">{{ $task->task_name }}</h2>
                <hr>
            </div>

            <div class="col-12 py-1 mb-3">
                <div class="card shadow rounded-0">
                    <div class="card-header bg-secondary text-white rounded-0" data-target="#collapse_{{ $topic->id }}" data-toggle="collapse" style="cursor:pointer;">
                        {{ $task->title }}
                    </div>
                    <div id="collapse_{{ $topic->id }}" class="card-body collapse show">
                        <div class="row mb-3">
                            <div class="col-12">
                                <h5>Objetivo</h5>
                                <span class="text-justify">{!! $task->goal !!}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-md-4">
                                <h5>Evidencia de aprendizaje</h5>
                                <span>{!! $task->evidence !!}</span>
                            </div>
                            <div class="col-12 col-md-4">
                                <h5>Tiempo estimado para la actividad</h5>
                                @if ($task->limit_type == 1)
                                <span>{{ $task->days }} días</span>
                                @elseif($task->limit_type == 2)
                                <span>{{ date_format($task->deadline_date, 'd/m/Y H:i') }}</span>
                                @endif
                            </div>
                            <div class="col-12 col-md-4">
                                <h5>Evaluación de la tarea</h5>
                                <div>
                                    {!! $task->evaluation !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12">
                <h3 class="text-center">Actividades</h3>
                <hr>
                <div class="accordion" id="accordion">
                    @forelse($task->activities()->get() as $index_activity => $activity)
                    <div class="card">
                        <div class="card-header bg-secondary text-white" id="heading_{{ $index_activity }}" data-toggle="collapse" data-target="#collapse_{{ $index_activity }}" aria-expanded="{{ $index_activity == 0 ? 'true' : 'false' }}" aria-controls="collapse_{{ $index_activity }}" style="cursor:pointer;">
                            {{ ($index_activity+1) }}: {{ $activity->title }}
                        </div>

                        <div id="collapse_{{ $index_activity }}" class="collapse {{ $index_activity == 0 ? 'show' : '' }}" aria-labelledby="heading_{{ $index_activity }}" data-parent="#accordion">
                            <div class="card shadow rounded-0">
                                <div class="card-body text-center">
                                    <form action="{{ route('course.manage.question.response.store', [$activity]) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <h5>Instrucciones</h5>
                                        <hr>
                                        <span class="text-justify">{!! $activity->instruction !!}</span>
                                        @if ($activity->embed_pdf_path)
                                        <div style="display:flex;padding:10px;width:100% !important">
                                            <iframe src="{{ asset('storage/' . $activity->embed_pdf_path) }}" style="margin:auto;" width="80%" height="400px"></iframe>
                                        </div>
                                        @endif
                                        @if ($activity->type == 2)
                                        <hr>


                                        @foreach ($activity->questions()->get() as $question)
                                        <div class="row">
                                            <div class="col-12 text-justify">
                                                {!! $question->question !!}
                                            </div>
                                            @if ($question->answer_a)
                                            <div class="col-12 col-md-4 my-3">
                                                <span class="text-justify">
                                                    <input type="radio" name="questions[{{ $question->id }}]" value="a_@_{{ $question->answer_a }}" {{ $question->responses()->whereUser(auth()->user())->whereResponse($question->answer_a)->exists()
    ? 'checked'
    : '' }}>
                                                    A) {!! $question->answer_a !!}
                                                </span>
                                            </div>
                                            @endif
                                            @if ($question->answer_b)
                                            <div class="col-12 col-md-4 my-3">
                                                <span class="text-justify">
                                                    <input type="radio" name="questions[{{ $question->id }}]" value="b_@_{{ $question->answer_b }}" {{ $question->responses()->whereUser(auth()->user())->whereResponse($question->answer_b)->exists()
    ? 'checked'
    : '' }}>
                                                    B) {!! $question->answer_b !!}
                                                </span>

                                            </div>
                                            @endif
                                            @if ($question->answer_c)
                                            <div class="col-12 col-md-4 my-3">
                                                <span class="text-justify">
                                                    <input type="radio" name="questions[{{ $question->id }}]" value="c_@_{{ $question->answer_c }}" {{ $question->responses()->whereUser(auth()->user())->whereResponse($question->answer_c)->exists()
    ? 'checked'
    : '' }}>
                                                    C) {!! $question->answer_c !!}
                                                </span>

                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                        @endif

                                        <div class="row">
                                            <div class="col-12 col-md-9 mb-1">
                                                @if ($activity->needs_evidence)
                                                <div class="custom-file">
                                                    <input name="evidence[]" multiple type="file" x-on:change="onChangeFile(event)" class="custom-file-input" id="customFile" required>
                                                    <label class="custom-file-label" for="customFile">
                                                        <span>seleccionar</span>
                                                    </label>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-md-3 mb-1">
                                                @if ($activity->questions()->exists() || $activity->needs_evidence)
                                                <button class="btn btn-success btn-shadow btn-block">
                                                    <i class="fas fa-save"></i>
                                                    Guardar
                                                </button>
                                                @endif
                                            </div>

                                            <div class="col-12">
                                                <template x-for="file in fileCollection.files">
                                                    <div class="label mb-1" x-text="file.name"></div>
                                                </template>
                                            </div>

                                            @foreach ($activity->fileEvidences as $fileEvidence)
                                            <div class="col-12 col-md-3">
                                                    <div class="d-inline-block border border-info my-2 p-2">
                                                        <a href="{{ route('file-evidences.download', [$fileEvidence]) }}" class="text-info">
                                                            <i class="fas fa-file text-info" style="font-size: 3rem"></i>
                                                            <br>
                                                            Descargar
                                                            {{ $fileEvidence->name }}
                                                        </a>
                                                    </div>
                                            </div>
                                            @endforeach
                                        </div>

                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 py-2">
                        <div class="card shadow rounded-0">
                            <div class="card-body text-center">
                                <h6>No hay actividades registrados para esta tarea</h6>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
                <br>
            </div>

            <div class="col-12 text-center">
                <h3>Recursos de la actividad</h3>
                <hr>
            </div>
            <div class="col-12 py-2">
                <div class="card shadow rounded-0">
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-0" id="resource_tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="required-tab" data-toggle="tab" href="#required" role="tab" aria-controls="required" aria-selected="true">Recursos obligatorios</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="complementary-tab" data-toggle="tab" href="#complementary" role="tab" aria-controls="complementary" aria-selected="false">Recursos
                                    complementarios</a>
                            </li>
                        </ul>

                        <div class="tab-content border" id="resource_tabs_content">
                            <div class="tab-pane fade show active p-2" id="required" role="tabpanel" aria-labelledby="required-tab">
                                @forelse($task->requiredResources()->get() as $required)
                                <div class="card rounded-0 shadow my-2">
                                    <div class="card-body">
                                        <h6>{{ ucfirst($required->resource_type) }}</h6>
                                        <hr>
                                        <span class="text-justify">{!! $required->resource_description !!}</span>
                                    </div>
                                </div>
                                @empty
                                <div class="card rounded-0 shadow my-2">
                                    <div class="card-body text-center">
                                        <h6>No hay recursos obligatorios registrados</h6>
                                    </div>
                                </div>
                                @endforelse
                            </div>
                            <div class="tab-pane fade p-2" id="complementary" role="tabpanel" aria-labelledby="complementary-tab">
                                @forelse($task->complementaryResources()->get() as $required)
                                <div class="card rounded-0 shadow my-2">
                                    <div class="card-body">
                                        <h6>{{ ucfirst($required->resource_type) }}</h6>
                                        <hr>
                                        <span class="text-justify">{!! $required->resource_description !!}</span>
                                    </div>
                                </div>
                                @empty
                                <div class="card rounded-0 shadow my-2">
                                    <div class="card-body text-center">
                                        <h6>No hay recursos comlementarios registrados</h6>
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-courses.panel.main-menu>

    <script>

        class FileCollection{
            constructor(files){
                this.MAX_FILE_SIZE = 2413585
                this.validate(files)
                this.files = files || []
            }

            validate(files){
                files.forEach( file => {
                    if(file.size > this.MAX_FILE_SIZE){
                        throw `el archivo ${file.name} es muy pesado`
                    }
                } )
            }

            forEach(callback){
                this.files.forEach(callback);
            }

            static create(files){
                return new FileCollection( Array.from(files) )
            }
        }

        function data() {
            return {

                MAX_FILE_SIZE: 2413585,
                fileMessage: "seleccionar archivo",
                fileCollection: new FileCollection([]),

                init() {
                    console.log(this.fileCollection)
                },

                showError(title, text){
                    Swal.fire({
                        icon: 'error',
                        title: title,
                        text: text,
                    })
                },

                onChangeFile(event) {
                    try {
                        this.fileCollection = FileCollection.create(event.target.files)
                    } catch (error) {
                        this.showError("¡Ups!", error)
                    }
                }
            }
        }
    </script>

</div>
<br>