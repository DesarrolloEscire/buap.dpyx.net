<div class="shadow mb-2" x-data="data()">

    <x-courses.panel.main-menu :title="$course->title" subtitle="Bienvenida">

        <div class="row bg-white">
            <div class="col-12 py-3">
                <h2 class="text-center">{{ $course->title }}</h2>
                <hr>
                <div id="accordion">
                    @foreach($sections as $index => $section)
                    <div class="card my-3 rounded-0 shadow">
                        <div class="card-header bg-secondary rounded-0 text-white" style="cursor:pointer;" id="{{ $section->key_section }}" data-toggle="collapse" data-target="#collapse-{{$section->key_section}}" aria-expanded="true" aria-controls="collapse-{{$section->key_section}}">
                            <h5 class="mb-0">
                                {{ $section->title ? $section->title : str_replace('seccion_','',$section->key_section) }}
                            </h5>
                        </div>

                        <div id="collapse-{{$section->key_section}}" class="collapse @if($index==0) show @endif" aria-labelledby="{{ $section->key_section }}" data-parent="#accordion">
                            <div class="card-body">
                                {!! $section->description !!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>



            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <h3 class="text-center">Temas del curso</h3>
                        <hr>
                    </div>
                    @foreach($course->reaCourseTopics()->get() as $index_topic => $topic)
                    <div class="col-12 col-md-6 py-2">
                        <div class="card shadow rounded-0">
                            <div class="card-body text-center">
                                <h6>Tema {{ ($index_topic + 1) }}: {{ $topic->topic_name }}</h6>
                                <hr>
                                <span>Módulos: {{ $topic->modules()->count() }}</span>
                                <br>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <br>
            </div>

            <div class="col-12">
                <div class="card my-3 rounded-0 shadow">
                    <div class="card-header bg-secondary rounded-0 text-white" style="cursor:pointer;" id="resources" data-toggle="collapse" data-target="#collapse-resources" aria-expanded="true" aria-controls="collapse-resources">
                        <h5 class="mb-0">
                            Recursos
                        </h5>
                    </div>

                    <div id="collapse-resources" class="collapse @if($index==0) show @endif" aria-labelledby="resources" data-parent="#accordion">
                        <div class="card-body">
                            <ul class="nav nav-tabs mb-0" id="resource_tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="required-tab" data-toggle="tab" href="#required" role="tab" aria-controls="required" aria-selected="true">Asesores</a>
                                </li>
                            </ul>

                            <div class="tab-content border" id="resource_tabs_content">
                                <div class="tab-pane fade show active p-2" id="required" role="tabpanel" aria-labelledby="required-tab">
                                    <div id="accordion_2">
                                        @forelse($resources['consultants'] as $consultant_index => $consultant)
                                        <div class="card my-2 rounded-0">
                                            <div class="card-header text-dark rounded-0" style="cursor:pointer;" id="{{ $consultant->id }}" data-toggle="collapse" data-target="#collapse-{{ $consultant->id }}" aria-expanded="true" aria-controls="collapse-{{ $consultant->id }}">
                                                <h6 class="mb-0">{{ $consultant->consultant_name }}</h6>
                                            </div>
                                            <div id="collapse-{{ $consultant->id }}" class="p-3 collapse @if($consultant_index==0) show @endif" aria-labelledby="{{ $consultant->id }}" data-parent="#accordion_2">
                                                <div>
                                                    {!! $consultant->description !!}
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <div class="card rounded-0 shadow my-2">
                                            <div class="card-body text-center">
                                                <h6>No hay asesores registrados</h6>
                                            </div>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </x-courses.panel.main-menu>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        function data(){
            return {
                init(){
                    swal("Curso REA", "establecer conceptos relacionados con el aprendizaje abierto de forma que se pueda visualizar la relación entre los recursos, las personas y las tecnologías en el marco de la educación abierta, como una ruta de acción para abordar los retos que nos plantea la transformación digital, conformando un ecosistema institucional de aprendizaje abierto.");
                }
            }
        }
    </script>

</div>
<br>