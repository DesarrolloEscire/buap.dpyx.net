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
    <x-page-title title="Curso: {{strtoupper($course->course_name)}} / Tema: {{$topic->topic_name}} / Módulo: {{$module->module_name}}" description="Este módulo permite adminsitrar las preguntas de una actividad específica">
    </x-page-title>
    @endsection

    <div class="card">
        <div class="card-body">
            <div class="card">
                <div class="card-header bg-dark text-white" style="cursor: pointer;font-weight:200;" data-target="#collapse_activity" data-toggle="collapse">
                    <i class="fas fa-eye"></i>&nbsp;Detalles de la actividad
                </div>
                <div id="collapse_activity" class="card-body collapse">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Título de la actividad</label>
                                <h5>{{ $activity->title }}</h5>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Instrucciones</label>
                                <div>{!! $activity->instruction !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <h4>Cuestionario de evaluación</h4>
            <hr>

            <div class="row">
                <div class="col-12">
                    <div class="questions_list_container">
                        @if( sizeof($questions_list) == 0 && ($activity->questions()->count() == 0) )
                        <div class="row">
                            <div class="col-12 text-center">
                                No hay actividades registradas para esta tarea
                                <hr>
                            </div>
                        </div>
                        @endif

                        <div wire:ignore>
                            @foreach($activity->questions()->get() as $question_item)
                            <form id="form_question_{{$question_item->id}}" action="{{ route('course.manage.question.update',[$course,$topic,$module,$task,$activity,$question_item]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{$question_item->id}}">
                                <x-forms.courses.manage.form-rea-task-question :index="$question_item->id" :question="$question_item" edit="true">
                                    <div class="w-100 text-right">
                                        <button type="button" form="form_question_{{$question_item->id}}" data-id="{{$question_item->id}}" class="btn btn-success btn-shadow rounded-0 btn-edit-question"><i class="fas fa-edit"></i> Editar pregunta</button>
                                        
                                        <button type="button" class="btn btn-danger btn-shadow rounded-0" data-target="#modalDeleteReaQuestion{{$question_item->id}}" data-toggle="modal"><i class="fas fa-trash"></i> Eliminar pregunta</button>
                                        <x-modals.courses.manage.delete-rea-question 
                                        :course="$course" 
                                        :topic="$topic" 
                                        :module="$module" 
                                        :task="$task" 
                                        :activity="$activity" 
                                        :question="$question_item"></x-modals.courses.manage.delete-rea-question>
                                    </div>
                                    <script>
                                        new Quill('#edit_question_richtext_{{$question_item->id}}', quillOptions);
                                    </script>
                                </x-forms.courses.manage.form-rea-task-question>
                            </form>
                            @endforeach
                            <form action="" method="POST" id="delete_question_form">
                                @csrf 
                                @method('DELETE')
                            </form>
                        </div>


                        <form id="form_questions" action="{{ route('course.manage.question.store',[$course,$topic,$module,$task,$activity]) }}" method="POST">
                            @csrf
                            @foreach($questions_list as $index => $question_form)
                            <x-forms.courses.manage.form-rea-task-question edit="false" :index="$index">
                                <div class="w-100 text-right">
                                    <button type="button" class="btn btn-danger btn-shadow rounded-0" wire:click="removeQuestionForm({{$index}})"><i class="fas fa-minus"></i> Quitar formulario</button>
                                </div>
                                <script>
                                    new Quill('#question_richtext_{{$index}}', quillOptions);
                                </script>
                            </x-forms.courses.manage.form-rea-task-question>
                            @endforeach
                            <input type="submit" hidden id="btn-submit-form-questions">
                        </form>

                        <div class="card-footer pr-0">
                            <div class="w-100 text-right">
                                @if(sizeof($questions_list) > 0 )
                                <button type="button" id="btn-submit-questions" class="btn btn-success btn-shadow rounded-0"><i class="fas fa-save"></i> Guardar preguntas ({{sizeof($questions_list)}})</button>
                                @endif
                                <button type="button" id="btn-add-questions" wire:click="addQuestionForm()" class="btn btn-secondary btn-shadow rounded-0"><i class="fas fa-plus"></i> Agregar pregunta</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer pr-0">
                <div class="w-100 text-right">
                    <a href="{{ route('course.manage.task.view',[$course,$topic,$module,$task]) }}" class="btn btn-secondary btn-shadow rounded-0">Cancelar y volver</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click','.btn-delete-question',function(){
            $('#delete_question_form').attr('action',$(this).data('url')).submit();
        });

        $(document).on('click', '#btn-submit-questions', function() {
            $.each($('#form_questions .richtext'), function(i, val) {
                var
                    richtext_id = $(this).attr('id'),
                    richtext_content = $("#" + richtext_id + " .ql-editor").html(),
                    textarea_id = richtext_id.replace('_richtext', '_hidden');
                $('#' + textarea_id).val(richtext_content);
            });
            $("#btn-submit-form-questions").trigger('click');
        });


        $(document).on('click', '.btn-edit-question', function() {
            var id = $(this).data('id');
            $('#edit_question_hidden_' + id).val($('#edit_question_richtext_' + id).html());
            $("#form_question_" + id).submit();
        });
    </script>

</div>