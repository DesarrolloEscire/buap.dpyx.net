<div class="row">
    <div class="col-12">
        <div id="resources_list_container">
            @if(!$task || (sizeof($resources_list) == 0 && ($task->resources()->count() == 0)) )
            <div class="row">
                <div class="col-12 text-center">
                    No hay recursos registrados para esta tarea
                    <hr>
                </div>
            </div>
            @endif


            <div wire:ignore>
                @foreach($task->resources()->get() as $resource_item)
                <form id="form_resource_{{$resource_item->id}}" action="{{ route('course.manage.resource.update',[$course,$topic,$module,$task,$resource_item]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$resource_item->id}}">
                    <x-forms.courses.manage.form-rea-task-resource :index="$resource_item->id" :resource="$resource_item" edit="true">
                        <div class="w-100 text-right">
                            <button type="button" form="form_resource_{{$resource_item->id}}" data-id="{{$resource_item->id}}" class="btn btn-success btn-shadow rounded-0 btn-edit-resource"><i class="fas fa-edit"></i> Editar recurso</button>
                            <button type="button" class="btn btn-danger btn-shadow rounded-0" data-target="#modalDeleteReaResource{{$resource_item->id}}" data-toggle="modal"><i class="fas fa-trash"></i> Eliminar recurso</button>
                            <x-modals.courses.manage.delete-rea-resource 
                            :course="$course"
                            :topic="$topic"
                            :module="$module"
                            :task="$task"
                            :resource="$resource_item"></x-modals.courses.manage.delete-rea-resource>
                        </div>
                        <script>
                            new Quill('#edit_resource_description_richtext_{{$resource_item->id}}', quillOptions);
                        </script>
                    </x-forms.courses.manage.form-rea-task-resource>
                </form>
                @endforeach
                <form action="" method="POST" id="delete_resource_form">
                    @csrf
                    @method('DELETE')
                </form>
            </div>

            <form id="form_resources" action="{{ route('course.manage.resource.store',[$course,$topic,$module,$task]) }}" method="POST">
                @csrf
                @foreach($resources_list as $index => $resource_form)
                <x-forms.courses.manage.form-rea-task-resource :index="$index" edit="false">
                    <div class="w-100 text-right">
                        <button type="button" class="btn btn-danger btn-shadow rounded-0" wire:click="removeResourceForm({{$index}})"><i class="fas fa-minus"></i> Quitar formulario</button>
                    </div>
                    <script>
                        new Quill('#resource_description_richtext_{{$index}}', quillOptions);
                    </script>
                </x-forms.courses.manage.form-rea-task-resource>
                @endforeach
                <input type="submit" hidden id="btn-submit-form-resources">
            </form>

            <div class="card-footer pr-0">
                <div class="w-100 text-right">
                    @if(sizeof($resources_list) > 0 )
                    <button type="button" id="btn-submit-resources" class="btn btn-success btn-shadow rounded-0"><i class="fas fa-save"></i> Guardar recursos ({{sizeof($resources_list)}})</button>
                    @endif
                    <button type="button" wire:click="addResourceForm()" class="btn btn-secondary btn-shadow rounded-0"><i class="fas fa-plus"></i> Agregar recurso</button>
                </div>
            </div>
        </div>
    </div>
</div>