<div>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet">
    <link href="{{asset('css/jquery.treetable.css')}}" rel="stylesheet">
    <style>
        .td-actions {
            min-width: 150px !important;
            text-align: center;
        }

        .td-actions .btn {
            margin: auto 5px;
        }
    </style>

    @section('header')
    <x-page-title title="Gestión de temas, módulos y tareas del curso {{strtoupper($course->course_name)}}" description="Este módulo permite adminsitrar el contenido del curso {{strtoupper($course->course_name)}}">
    </x-page-title>
    @endsection

    <div class="card">
        @php
        $emptyUrl = ($tab==NULL && $pill==NULL);
        @endphp
        <div class="card-body">
            @if($tab == 'sections' || ($tab == NULL && $pill == NULL))
            <form id="form_course" action="{{ route('course.manage.update',[$course]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <h5>Datos generales del curso</h5>
                        <hr>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="" class="control-label">Título del curso</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Título del curso" title="Título del curso" value="{{ $course->title }}" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="" class="control-label">Descripción del curso</label>
                            <div id="description_richtext">{!! $course->description !!}</div>
                            <textarea id="description_hidden" name="description" style="display:none;"></textarea>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="duration" class="control-label">Duración del curso (días naturales)</label>
                            <input type="number" name="duration" id="duration" class="form-control" min="1" step="1" placeholder="Duración" title="Duración del curso" value="{{ $course->duration }}" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group text-right">
                            <button type="button" id="btn-submit-course" class="btn btn-primary btn-shadow rounded-0"><i class="fas fa-save"></i> Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
            @endif
            
            <nav>
                <div class="nav nav-tabs mb-0" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link {{ ($tab=='sections' || $emptyUrl ? 'active' : '') }}" href="{{ route('course.manage',['sections']) }}" role="tab" aria-controls="welcome-view" aria-selected="true">Pantalla principal</a>
                    <a class="nav-item nav-link {{ ($tab=='topics' ? 'active' : '') }}" href="{{ route('course.manage',['topics']) }}" role="tab" aria-controls="topics-view" aria-selected="false">Temas, módulos y tareas</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade {{ ($tab=='sections' || $emptyUrl ? 'show active' : '') }}" id="welcome-view" role="tabpanel" aria-labelledby="welcome-view-tab">
                    <div class="card">
                        <div class="card-body">
                            @include('livewire.courses.manage.helpers.welcome-view-form')
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade {{ ($tab=='topics' ? 'show active' : '') }}" id="topics-view" role="tabpanel" aria-labelledby="topics-view-tab">
                    <div class="card">
                        <div class="card-body">
                            @include('livewire.courses.manage.helpers.topics-view-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Include the Quill library -->
    <script src="{{asset('js/jquery.treetable.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
    <script src="{{asset('js/highlight.min.js')}}"></script>
    <script src="{{asset('js/quill.js')}}"></script>

    <!-- Initialize Quill editor -->
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

        if($('#description_richtext').length > 0){
            new Quill('#description_richtext', quillOptions);
        }
        new Quill('#seccion_principal_richtext', quillOptions);
        new Quill('#seccion_acercade_richtext', quillOptions);
        new Quill('#seccion_requisitos_richtext', quillOptions);


        // $('#table-consultants tbody').sortable({
        //     stop: function(event, ui) {
        //         var
        //             listElements = $(this).children(),
        //             params = {
        //                 _token: $('input[name="_token"]').val(),
        //                 _method: 'PATCH',
        //                 consultantOrderedList: []
        //             };

        //         listElements.each(function(i, val) {
        //             var objData = {
        //                 id: $(this).data('id'),
        //                 order: (i + 1)
        //             };

        //             params.consultantOrderedList.push(objData);
        //         });

        //         $.post('{{ route("course.manage.consultant.sort",[$course]) }}', params);
        //     }
        // });


        $('#table-topics').treetable({
            expandable: true,
            indent: 10,
            expanderTemplate: '<a href="#" class="expander-icon"><i class="fas fa-chevron-right"></i>&nbsp;</a>'
        });




        $(document).on('click', '.expander-icon', function() {
            if ($(this).attr('title') == 'Expand') {
                $(this).html('<i class="fas fa-chevron-right"></i>&nbsp;');
            } else if ($(this).attr('title') == 'Collapse') {
                $(this).html('<i class="fas fa-chevron-down"></i>&nbsp;');
            }
        });


        $(document).on('click','#btn-submit-course',function(){
            $("#description_hidden").val($('#description_richtext').html());
            $('#form_course').submit();
        });



        $(document).on('submit', '.section-form', function() {
            var formId = $(this).attr('id').replace('_form', '');
            $("#" + formId + '_hidden').val($("#" + formId + '_richtext').html());
        });




        $(document).on('click', '.btn-consultant-modal', function() {
            var id = $(this).data('id');
            new Quill('#asesor_richtext_' + id, quillOptions);
        });
        $(document).on('click', '.btn-consultant-submit', function() {
            var id = $(this).data('id');
            $("#asesor_hidden_" + id).val($("#asesor_richtext_" + id).html());
            $('#asesor_form_' + id).submit();
        });

        $(document).on('click', '.btn-topic-modal', function() {
            var id = $(this).data('id');
            new Quill('#topic_richtext_' + id, quillOptions);
        });
        $(document).on('click', '.btn-topic-submit', function() {
            var id = $(this).data('id');
            $("#topic_hidden_" + id).val($("#topic_richtext_" + id).html());
            $('#topic_form_' + id).submit();
        });

        $(document).on('click', '.btn-module-modal', function() {
            var id = $(this).data('id');
            new Quill('#module_richtext_' + id, quillOptions);
        });
        $(document).on('click', '.btn-module-submit', function() {
            var id = $(this).data('id');
            $("#module_hidden_" + id).val($("#module_richtext_" + id).html());
            $('#module_form_' + id).submit();
        });
    </script>
</div>