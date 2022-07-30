<div class="shadow mb-2">
    
    <x-courses.panel.main-menu :title="$course->title" subtitle="Bienvenida">
        <div class="row bg-white">
            <div class="col-12 py-3">
                <h2 class="text-center">{{ $module->module_name }}</h2>
                <hr>
            </div>
    
            <div class="col-12 py-1">
                <div class="card shadow rounded-0">
                    <div class="card-header bg-secondary text-white rounded-0" data-target="#collapse_{{$module->id}}" data-toggle="collapse" style="cursor:pointer;">
                        {{ $module->title }}
                    </div>
                    <div id="collapse_{{$module->id}}" class="card-body collapse show">
                        <div class="row mb-3">
                            <div class="col-12">
                                <h5>Objetivo</h5>
                                <span class="text-justify">{{ $module->goal }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <h5>Contenido del módulo</h5>
                                <div>{!! $module->description !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            
            <div class="col-12">
                <br>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <h3 class="text-center">Actividades del módulo</h3>
                        <hr>
                    </div>
                    @forelse($module->tasks()->get() as $index_task => $task)
                    <div class="col-12 col-md-6 py-2">
                        <div class="card shadow rounded-0">
                            <div class="card-body text-center">
                                <h6>{{ $topic->order }}.{{$module->order}}.{{$task->order}}: {{ $task->task_name }}</h6>
                                <hr>
                                <span>Actividades a realizar: {{ $task->activities()->count() }}</span>
                                <br>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 py-2">
                        <div class="card shadow rounded-0">
                            <div class="card-body text-center">
                                <h6>No hay tareas registradas para este módulo</h6>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
                <br>
            </div>
        </div>
    </x-courses.panel.main-menu>
</div>