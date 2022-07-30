<div>
    @section('header')
    <x-page-title title="Progreso del curso {{strtoupper($course->course_name)}}" description="Este módulo permite revisar las estadísticas del curso {{strtoupper($course->course_name)}} de un docente">
    </x-page-title>
    @endsection

    <div class="mb-3 shadow bg-white p-4">
        <div class="row">
            <div class="col-12">
                <h3>{{ $teacher->name }} ({{ $teacher->identifier }})</h3>
                <hr>
            </div>
            <div class="col-12">
                <h5><i class="fas fa-chart-line"></i> Progreso</h5>
            </div>
            <!-- <div class="col-12" title="{{ $dates_message }}">
                <i class="fas fa-tasks"></i> <span>Progreso teórico - {{ $dates_message }}</span>
                <div class="progress mb-3" title="{{ $dates_message }}">
                    <div class="progress-bar {{ (number_format(($teoric_days/$course->duration)*100)) == 0 ? 'text-dark' : '' }} {{ $dates_difference>=($course->duration*0.80) ? 'bg-danger' : 'bg-primary'}}" role="progressbar" style="width: {{ number_format(($teoric_days/$course->duration)*100) }}%" aria-valuenow="{{ number_format(($teoric_days/$course->duration)*100) }}" aria-valuemin="0" aria-valuemax="100">{{ number_format(($teoric_days/$course->duration)*100) }}% ({{ $dates_difference>=$course->duration ? '+' : '' }}{{$teoric_days}}/{{$course->duration}})</div>
                </div>
            </div> -->
            <div class="col-12">
                <h6><i class="fas fa-tasks"></i> Cuestionarios</h6>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ number_format(($user_questionary/$questionary)*100) }}%" aria-valuenow="{{ number_format(($user_questionary/$questionary)*100) }}" aria-valuemin="0" aria-valuemax="100">{{ number_format(($user_questionary/$questionary)*100) }}% ({{$user_questionary}}/{{$questionary}})</div>
                </div>
            </div>
            <div class="col-12">
                <h6><i class="fas fa-pencil-ruler"></i> Tareas</h6>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ number_format(($user_evidences/$evidences)*100) }}%" aria-valuenow="{{ number_format(($user_evidences/$evidences)*100) }}" aria-valuemin="0" aria-valuemax="100">{{ number_format(($user_evidences/$evidences)*100) }}% ({{$user_evidences}}/{{$evidences}})</div>
                </div>
            </div>
            <div class="col-12">
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <ul class="nav nav-tabs mb-0" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="questionaries-tab" data-toggle="tab" href="#questionaries" role="tab" aria-controls="questionaries" aria-selected="true">Cuestionarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="evidences-tab" data-toggle="tab" href="#evidences" role="tab" aria-controls="evidences" aria-selected="true">Tareas</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane" id="questionaries" role="tabpanel" aria-labelledby="questionaries-tab">
                        <div class="card rounded-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h6>Cuestionarios</h6>
                                        <div class="progress mb-3">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ number_format(($user_questionary/$questionary)*100) }}%" aria-valuenow="{{ number_format(($user_questionary/$questionary)*100) }}" aria-valuemin="0" aria-valuemax="100">{{ number_format(($user_questionary/$questionary)*100) }}% ({{$user_questionary}}/{{$questionary}})</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">

                                        @foreach($questions as $topic_key => $topic)
                                        <div class="card rounded-0 shadow my-3">
                                            <div class="card-header bg-secondary text-white text-center">
                                                {{ $topic_key }}
                                            </div>
                                            <div class="card-body">
                                                @foreach($topic as $module_key => $module)
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                {{ $module_key }}
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($module as $task_index => $task)
                                                        <tr>
                                                            <td>
                                                                @if($task['answered'])
                                                                <i class="fas fa-check-circle text-success"></i> {{ $task_index }}
                                                                <div>
                                                                    <button type="button" class="btn btn-secondary btn-shadow rounded-0 my-2" data-toggle="modal" data-target="#modalQuestionaryResponses{{ $task['questionary']->id }}" title="Ver respuestas"><i class="fas fa-eye"></i>&nbsp;Aciertos: {{ $task['question']['correct_hits'] }}/{{ $task['question']['total_hits'] }}</button>

                                                                    <x-courses.board.show-teacher-questionary-responses :topic="$topic_key" :module="$module_key" :task="$task_index" :questionary="$task['questionary']" :responses="$user_questionary_data_responses" :hits="$task['question']['correct_hits']"></x-courses.board.show-teacher-questionary-responses>
                                                                </div>
                                                                @else
                                                                <i class="fas fa-times-circle text-danger"></i> {{ $task_index }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane" id="evidences" role="tabpanel" aria-labelledby="evidences-tab">
                        <div class="card rounded-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h6>Tareas</h6>
                                        <div class="progress mb-3">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ number_format(($user_evidences/$evidences)*100) }}%" aria-valuenow="{{ number_format(($user_evidences/$evidences)*100) }}" aria-valuemin="0" aria-valuemax="100">{{ number_format(($user_evidences/$evidences)*100) }}% ({{$user_evidences}}/{{$evidences}})</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">

                                        @foreach($tasks as $topic_key => $topic)
                                        <div class="card rounded-0 shadow my-3">
                                            <div class="card-header bg-secondary text-white text-center">
                                                {{ $topic_key }}
                                            </div>
                                            <div class="card-body">
                                                @foreach($topic as $module_key => $module)
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                {{ $module_key }}
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($module as $task_index => $task)
                                                        <tr>
                                                            <td>
                                                                @if($task['uploaded'])
                                                                <i class="fas fa-check-circle text-success"></i> {{ $task_index }}
                                                                <div class="my-2">
                                                                    <a href="{{ route('file-evidences.download',[ $user_evidence_data_responses[ $task['evidence'] ] ]) }}" class="btn btn-secondary btn-shadow rounded-0">
                                                                        <i class="fas fa-file-download"></i>&nbsp;Descargar tarea
                                                                    </a>
                                                                </div>
                                                                @else
                                                                <i class="fas fa-times-circle text-danger"></i> {{ $task_index }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 py-3 text-right">
                <a href="{{ $board }}" class="btn btn-secondary btn-shadow rounded-0">Volver</a>
            </div>
        </div>
    </div>
</div>