<div class="row">
    <div class="col-12">
        <div class="activities_list_container">
            @if(!$task || (sizeof($activities_list) == 0 && ($task->activities()->count() == 0)) )
            <div class="row">
                <div class="col-12 text-center">
                    No hay actividades registradas para esta tarea
                    <hr>
                </div>
            </div>
            @endif

            <div wire:ignore>
                @foreach($task->activities()->get() as $index_activity => $activity_item)
                <form enctype="multipart/form-data" id="form_activity_{{$activity_item->id}}" action="{{ route('course.manage.activity.update',[$course,$topic,$module,$task,$activity_item]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$activity_item->id}}">
                    <x-forms.courses.manage.form-rea-task-activity :index="$index_activity" :activity="$activity_item" edit="true">
                        <div class="w-100 text-right">
                            @if($activity_item->type == 2)
                            <a 
                            href="{{ route('course.manage.question.view',[$course,$topic,$module,$task,$activity_item]) }}" 
                            class="btn btn-secondary btn-shadow rounded-0"
                            ><i class="fas fa-question"></i> Cuestionario</a>
                            @endif
                            
                            <button type="button" form="form_activity_{{$activity_item->id}}" data-id="{{$activity_item->id}}" class="btn btn-success btn-shadow rounded-0 btn-edit-activity"><i class="fas fa-edit"></i> Editar actividad</button>
                            <button type="button" class="btn btn-danger btn-shadow rounded-0" data-target="#modalDeleteReaActivity{{$activity_item->id}}" data-toggle="modal"><i class="fas fa-trash"></i> Eliminar actividad</button>
                            <x-modals.courses.manage.delete-rea-activity 
                            :course="$course"
                            :topic="$topic"
                            :module="$module"
                            :task="$task"
                            :activity="$activity_item"></x-modals.courses.manage.delete-rea-activity>
                        </div>
                        <script>
                            new Quill('#edit_instruction_richtext_{{$activity_item->id}}', quillOptions);
                        </script>
                    </x-forms.courses.manage.form-rea-task-activity>
                </form>
                @endforeach
                <form action="" method="POST" id="delete_activity_form">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
    
            <form enctype="multipart/form-data" id="form_activities" action="{{ route('course.manage.activity.store',[$course,$topic,$module,$task]) }}" method="POST">
                @csrf
                @foreach($activities_list as $index => $activity_form)
                <x-forms.courses.manage.form-rea-task-activity :index="$index" edit="false">
                    <div class="w-100 text-right">
                        <button type="button" class="btn btn-danger btn-shadow rounded-0" wire:click="removeActivityForm({{$index}})"><i class="fas fa-minus"></i> Quitar formulario</button>
                    </div>
                    <script>
                        new Quill('#instruction_richtext_{{$index}}', quillOptions);
                    </script>
                </x-forms.courses.manage.form-rea-task-activity>
                @endforeach
                <input type="submit" hidden id="btn-submit-form-activities">
            </form>
    
            <div class="card-footer pr-0">
                <div class="w-100 text-right">
                    @if(sizeof($activities_list) > 0 )
                    <button type="button" id="btn-submit-activities" class="btn btn-success btn-shadow rounded-0"><i class="fas fa-save"></i> Guardar actividades ({{sizeof($activities_list)}})</button>
                    @endif
                    <button type="button" id="btn-add-activities" wire:click="addActivityForm()" class="btn btn-secondary btn-shadow rounded-0"><i class="fas fa-plus"></i> Agregar actividad</button>
                </div>
            </div>
        </div>
    </div>
</div>