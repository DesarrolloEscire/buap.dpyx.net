<div>
    <link href="{{asset('css/quill.snow.css')}}" rel="stylesheet">
    <script src="{{asset('js/highlight.min.js')}}"></script>
    <script src="{{asset('js/quill.js')}}"></script>
    <script>
        var quillOptions = {
            'placeholder': 'Ingrese la descripción de la sección',
            modules: {
                'syntax': true,
                'toolbar': [
                    [{
                        'size': []
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                            'color': []
                        },
                        {
                            'background': []
                        }
                    ],
                    [{
                        'script': 'super'
                    }, {
                        'script': 'sub'
                    }],
                    [{
                        'header': '1'
                    }, {
                        'header': '2'
                    }, 'blockquote', 'code-block'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }, {
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }],
                    [{
                        'direction': 'rtl'
                    }, {
                        'align': []
                    }],
                    ['link', 'image', 'video', 'formula'],
                    ['clean']
                ],
            },
            theme: 'snow'
        };
    </script>
    @section('header')
    <x-page-title title="Curso: {{strtoupper($course->course_name)}} / Tema: {{$topic->topic_name}} / Módulo: {{$module->module_name}}" description="Este módulo permite adminsitrar el contenido las tareas para el módulo {{$module->module_name}}">
    </x-page-title>
    @endsection

    <div class="card">
        <div class="card-body">
            <div class="card">
                <div class="card-header" style="background-color: #003b5c !important;color:white;" aria-expanded="true">
                    <h5>Datos generales de la tarea</h5>
                </div>
                <div id="generalData">
                    <div class="card-body">
                        <form id="task_form" action="{{ $task ? route('course.manage.task.update',[$course,$topic,$module,$task]) : route('course.manage.task.store',[$course,$topic,$module]) }}" method="POST">
                            @csrf
                            @if($task) @method('PUT') @endif
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="task_name" class="control-label">Nombre de la tarea</label>
                                        <input type="text" id="task_name" name="task_name" class="form-control" maxlength="200" placeholder="Nombre de la tarea" title="Nombre de la tarea" value="{{ ($task ? $task->task_name : '') }}" required />
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="title" class="control-label">Título de la tarea</label>
                                        <input type="text" id="title" name="title" class="form-control" maxlength="200" placeholder="Título de la tarea" title="Título de la tarea" value="{{($task ? $task->title : '')}}" required />
                                    </div>
                                </div>

                                <div class="col-12" wire:ignore>
                                    <div class="form-group">
                                        <label for="title" class="control-label">Objetivo de la tarea</label>
                                        <div id="goal_richtext" class="richtext">
                                            {!! ($task ? $task->goal : '') !!}
                                        </div>
                                        <textarea name="goal" class="richtext_textarea" id="goal_hidden" style="display:none"></textarea>
                                    </div>
                                </div>

                                <div class="col-12" wire:ignore>
                                    <div class="form-group">
                                        <label for="title" class="control-label">Evidencia de la tarea</label>
                                        <div id="evidence-richtext-container">
                                            <div id="evidence_richtext" class="richtext">
                                                {!! ($task ? $task->evidence : '') !!}
                                            </div>
                                            <textarea name="evidence" class="richtext_textarea" id="evidence_hidden" style="display:none"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="" class="control-label">Tiempo estimado para la actividad</label>
                                        <div class="form-check">
                                            <input class="form-check-input" wire:model="deadlineType" type="radio" name="limit_type" id="deadlineType_days" value="1" @if($deadlineType==1) checked @endif>
                                            <label class="form-check-label" for="deadlineType_days">Por días</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" wire:model="deadlineType" type="radio" name="limit_type" id="deadlineType_date" value="2" @if($deadlineType==2) checked @endif>
                                            <label class="form-check-label" for="deadlineType_date">Por fecha específica</label>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                @if($deadlineType == 1)
                                                <div class="input-group">
                                                    <input type="number" name="days" id="days" min="0" step="1" class="form-control" placeholder="0" title="Días" value="{{ ($task ? $task->days : '') }}" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2">días</span>
                                                    </div>
                                                </div>
                                                @elseif($deadlineType == 2)
                                                <input type="datetime-local" name="deadline_date" id="date" class="form-control" value="{{ ($task ? $task->deadline_date : '') }}" required>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12" wire:ignore>
                                    <div class="form-group">
                                        <label for="title" class="control-label">Evaluación de la tarea</label>
                                        <div id="evaluation_richtext" class="richtext">
                                            {!! ($task ? $task->evaluation : '') !!}
                                        </div>
                                        <textarea name="evaluation" class="richtext_textarea" id="evaluation_hidden" style="display:none"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer pr-0">
                                <div class="w-100 text-right">
                                    <button type="button" id="btn-submit-task" class="btn btn-primary btn-shadow rounded-0" title="Guardar datos generales de la tarea"><i class="fas fa-save"></i> Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <br>

            @if($task)
            <div class="card">
                <div class="card-header" style="background-color: #003b5c !important;color:white;" aria-expanded="false">
                    <h5>Datos complementarios de la tarea</h5>
                </div>
                <div id="complementaryData">
                    <div class="card-body">
                        <ul wire:ignore class="nav nav-tabs mb-0" id="task_complements" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if($complementTab == 'resources') active @endif" wire:click="toggleComplementTab('resources')" id="resources-tab" data-toggle="tab" href="#resources" role="tab" aria-controls="resources" aria-selected="true">Recursos ({{$task->resources()->count()}})</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($complementTab == 'activities') active @endif" wire:click="toggleComplementTab('activities')" id="activities-tab" data-toggle="tab" href="#activities" role="tab" aria-controls="activities" aria-selected="false">Actividades ({{$task->activities()->count()}})</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="task_complements_content">
                            <div class="tab-pane fade @if($complementTab == 'resources') show active @endif" id="resources" role="tabpanel" aria-labelledby="resources-tab">
                                <div class="card rounded-0">
                                    <div class="card-body">
                                        @include('livewire.courses.manage.helpers.resources-view-form')
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade @if($complementTab == 'activities') show active @endif" id="activities" role="tabpanel" aria-labelledby="activities-tab">
                                <div class="card rounded-0">
                                    <div class="card-body">
                                        @include('livewire.courses.manage.helpers.activities-view-form')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="card-footer pr-0">
                <div class="w-100 text-right">
                    <a href="{{ route('course.manage',['topics']) }}" class="btn btn-secondary btn-shadow rounded-0 mr-2" title="Cancelar y volver">Cancelar y volver</a>
                </div>
            </div>
        </div>
    </div>
    <br>

    <script>
        new Quill('#goal_richtext', quillOptions);
        new Quill('#evidence_richtext', quillOptions);
        new Quill('#evaluation_richtext', quillOptions);


        $(document).on('click','.btn-submit-resource-delete',function(){
            $('#delete_resource_form').attr('action',$(this).data('url')).submit();
        });
        
        
        $(document).on('click','.btn-submit-activity-delete',function(){
            $('#delete_activity_form').attr('action',$(this).data('url')).submit();
        });

        $(document).on('click', '#btn-submit-task', function() {
            $.each($('.richtext'), function(i, val) {
                var
                    richtext_id = $(this).attr('id'),
                    richtext_content = $("#" + richtext_id).html(),
                    textarea_id = richtext_id.replace('_richtext', '_hidden');
                $('#' + textarea_id).val(richtext_content);
            });

            $('#task_form').submit();
        });


        $(document).on('click', '#btn-submit-resources', function() {
            $.each($('#form_resources .richtext'), function(i, val) {
                var
                    richtext_id = $(this).attr('id'),
                    richtext_content = $("#" + richtext_id).html(),
                    textarea_id = richtext_id.replace('_richtext', '_hidden');
                $('#' + textarea_id).val(richtext_content);
            });
            $("#btn-submit-form-resources").trigger('click');
        });


        $(document).on('click', '.btn-edit-resource', function() {
            var id = $(this).data('id');
            $('#edit_resource_description_hidden_' + id).val($('#edit_resource_description_richtext_' + id).html());
            $("#form_resource_" + id).submit();
        });


        $(document).on('click', '#btn-submit-activities', function() {
            $.each($('#form_activities .richtext'), function(i, val) {
                var
                    richtext_id = $(this).attr('id'),
                    richtext_content = $("#" + richtext_id).html(),
                    textarea_id = richtext_id.replace('_richtext', '_hidden');
                $('#' + textarea_id).val(richtext_content);
            });
            $("#btn-submit-form-activities").trigger('click');
        });


        $(document).on('click', '.btn-edit-activity', function() {
            var id = $(this).data('id');
            $('#edit_instruction_hidden_' + id).val($('#edit_instruction_richtext_' + id).html());
            $("#form_activity_" + id).submit();
        });
    </script>
</div>