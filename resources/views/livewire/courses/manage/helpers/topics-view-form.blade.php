<div class="row">
    <div class="col-12">
        <div class="form-group">
            <button 
            type="button"
            class="btn btn-primary rounded-0 btn-shadow float-right mb-2 btn-topic-modal" 
            data-id="0"
            data-target="#modalFormReaTopic0"
            data-toggle="modal" 
            title="Nuevo tema"><i class="fas fa-plus"></i> Nuevo tema</button>
            <x-modals.courses.manage.form-rea-topic edit="false" :course="$course"></x-modals.courses.manage.form-rea-topic>
        </div>
    </div>
    <div class="col-12">
        <div class="bg-white shadow table-responsive">
            <table id="table-topics" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Tema</th>
                        <th>Título</th>
                        <th>Módulos/Tareas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                    $counter = 0;
                    $parent_1 = 1;
                    $parent_2 = 0;
                    @endphp
                    
                    @forelse($course->reaCourseTopics()->get() as $index1 => $topic)
                    
                    @php 
                    $counter+=1;
                    $parent_1=$counter;
                    @endphp 
                    
                    <tr data-tt-id="{{$counter}}">
                        <td><strong>{{ ($index1+1) }}</strong> - {{ $topic->topic_name }}</td>
                        <td>{{ $topic->title }}</td>
                        <td></td>
                        <td class="text-center td-actions">
                            <button
                            type="button" 
                            class="btn btn-primary btn-shadow rounded-0 btn-topic-modal" 
                            data-id="{{$topic->id}}"
                            data-target="#modalFormReaTopic{{$topic->id}}"
                            data-toggle="modal"
                            title="Editar tema"><i class="fas fa-edit"></i></button>
                            <x-modals.courses.manage.form-rea-topic edit="true" :course="$course" :id="$topic->id" :topic="$topic"></x-modals.courses.manage.form-rea-topic>

                            <button 
                            data-target="#modalDeleteReaTopic{{$topic->id}}"
                            data-toggle="modal"
                            type="button" 
                            class="btn btn-danger btn-shadow rounded-0"
                            title="Eliminar tema"><i class="fas fa-trash"></i></button>
                            <x-modals.courses.manage.delete-rea-topic
                            :course="$course"
                            :topic="$topic"></x-modals.courses.manage.delete-rea-topic>
                        </td>
                    </tr>

                    @forelse($topic->modules()->get() as $index2 => $module)
                    
                    @php
                    $counter+=1;
                    $parent_2=$counter;
                    @endphp
                    
                    <tr data-tt-id="{{$counter}}" data-tt-parent-id="{{$parent_1}}">
                        <td><strong>{{ ($index1+1) }}.{{ ($index2+1) }}</strong> - {{ $module->module_name }}</td>
                        <td>{{ $module->title }}</td>
                        <td></td>
                        <td class="text-center td-actions">
                            <button 
                            type="button" 
                            class="btn btn-success btn-shadow rounded-0 btn-module-modal"
                            data-id="{{$topic->id}}_0"
                            data-target="#modalFormReaModule{{$topic->id}}_0" 
                            data-toggle="modal"
                            title="Agregar módulo"><i class="fas fa-plus"></i> </button>
                            <x-modals.courses.manage.form-rea-module edit="false" :course="$course" :topic="$topic" :id="$topic->id.'_0'"></x-modals.courses.manage.form-rea-module>

                            <button
                            type="button" 
                            class="btn btn-primary btn-shadow rounded-0 btn-module-modal" 
                            data-id="{{$topic->id}}_{{$module->id}}"
                            data-target="#modalFormReaModule{{$topic->id}}_{{$module->id}}"
                            data-toggle="modal"
                            title="Editar módulo"><i class="fas fa-edit"></i></button>
                            <x-modals.courses.manage.form-rea-module edit="true" :course="$course" :topic="$topic" :module="$module" :id="$topic->id.'_'.$module->id"></x-modals.courses.manage.form-rea-module>

                            <button 
                            data-target="#modalDeleteReaModule{{$module->id}}"
                            data-toggle="modal"
                            type="button" 
                            class="btn btn-danger btn-shadow rounded-0"
                            title="Eliminar módulo"><i class="fas fa-trash"></i></button>
                            <x-modals.courses.manage.delete-rea-module
                            :course="$course"
                            :topic="$topic"
                            :module="$module"></x-modals.courses.manage.delete-rea-module>
                        </td>
                    </tr>

                    @forelse($module->tasks()->get() as $index3 => $task)

                    @php
                    $counter+=1;
                    $parent_3=$counter;
                    @endphp

                    <tr data-tt-id="{{$counter}}" data-tt-parent-id="{{$parent_2}}">
                        <td><strong>{{ ($index1+1) }}.{{ ($index2+1) }}.{{ ($index3+1) }}</strong> - {{ $task->task_name }}</td>
                        <td>{{ $task->title }}</td>
                        <td></td>
                        <td class="text-center td-actions">
                        <a 
                            href="{{ route('course.manage.task.view',[$course,$topic,$module]) }}" 
                            class="btn btn-success btn-shadow rounded-0"
                            title="Agregar tarea"><i class="fas fa-plus"></i></a>

                            <a 
                            href="{{ route('course.manage.task.view',[$course,$topic,$module,$task]) }}"  
                            class="btn btn-primary btn-shadow rounded-0"
                            title="Editar tarea"><i class="fas fa-edit"></i>
                            </a>

                            <button 
                            data-target="#modalDeleteReaTask{{$task->id}}"
                            data-toggle="modal"
                            type="button" 
                            class="btn btn-danger btn-shadow rounded-0"
                            title="Eliminar tarea"><i class="fas fa-trash"></i></button>
                            <x-modals.courses.manage.delete-rea-task
                            :course="$course"
                            :topic="$topic"
                            :module="$module"
                            :task="$task"></x-modals.courses.manage.delete-rea-task>
                        </td>
                    </tr>
                    
                    @empty
                    
                    @php
                    $counter+=1;
                    $parent_3=$counter;
                    @endphp

                    <tr data-tt-id="{{$counter}}" data-tt-parent-id="{{$parent_2}}">
                        <td class="text-center" colspan="4">
                            No hay tareas registradas para el módulo <strong>{{$module->module}}</strong>
                            <a 
                            href="{{ route('course.manage.task.view',[$course,$topic,$module]) }}" 
                            class="btn btn-success btn-shadow rounded-0"
                            title="Agregar tarea"><i class="fas fa-plus"></i> Agregar tarea</a>
                        </td>
                    </tr>

                    @endforelse

                    @empty

                    @php
                    $counter+=1;
                    $parent_2=$counter;
                    @endphp

                    <tr data-tt-id="{{$counter}}" data-tt-parent-id="{{$parent_1}}">
                        <td class="text-center" colspan="4">
                            No hay modulos registrados para el tema <strong>{{$topic->topic_name}}</strong>
                            <button 
                            type="button" 
                            class="btn btn-success btn-shadow rounded-0 btn-small btn-module-modal"
                            data-id="{{$topic->id}}_0"
                            data-target="#modalFormReaModule{{$topic->id}}_0" 
                            data-toggle="modal"
                            title="Agregar módulo"><i class="fas fa-plus"></i> Agregar módulo</button>
                            <x-modals.courses.manage.form-rea-module :edit="false" :course="$course" :topic="$topic" :id="$topic->id.'_0'"></x-modals.courses.manage.form-rea-module>
                        </td>
                    </tr>
                    @endforelse
                    
                    @empty
                    <tr>
                        <td class="text-center" colspan="4">No hay temas registrados</td>
                    </tr>
                    @endforelse
                    
                </tbody>
            </table>
        </div>
    </div>
</div>