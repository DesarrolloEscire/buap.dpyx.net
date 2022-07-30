<div class="shadow mb-2">
    
    <x-courses.panel.main-menu :title="$course->title" subtitle="Bienvenida">
        <div class="row bg-white">
            <div class="col-12 py-3">
                <h2 class="text-center">{{ $topic->topic_name }}</h2>
                <hr>
            </div>
    
            <div class="col-12 py-1">
                <div class="card shadow rounded-0">
                    <div class="card-header bg-secondary text-white rounded-0" data-target="#collapse_{{$topic->id}}" data-toggle="collapse" style="cursor:pointer;">
                        {{ $topic->title }}
                    </div>
                    <div id="collapse_{{$topic->id}}" class="card-body collapse show">
                        {!! $topic->description !!}
                    </div>
                </div>
            </div>
    
            
            <div class="col-12">
                <br>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <h3 class="text-center">Módulos del tema</h3>
                        <hr>
                    </div>
                    @forelse($topic->modules()->get() as $index_module => $module)
                    <div class="col-12 col-md-6 py-2">
                        <div class="card shadow rounded-0">
                            <div class="card-body text-center">
                                <h6>Módulo {{ $topic->order }}.{{$module->order}}: {{ $module->module_name }}</h6>
                                <hr>
                                <span>Subtemas a revisar: {{ $module->tasks()->count() }}</span>
                                <br>
                                <!-- <button class="my-3 btn btn-secondary btn-shadow rounded-0" data-target="#modalShowModuleDetail{{$module->id}}" data-toggle="modal" title="Ver detalles del módulo"><i class="fas fa-info-circle"></i> Ver detalles</button>
                                <x-modals.courses.panel.show-module-detail :module="$module" :index="$index_module" :order="$topic->order"></x-modals.courses.panel.show-module-detail> -->
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 py-2">
                        <div class="card shadow rounded-0">
                            <div class="card-body text-center">
                                <h6>No hay modulos registrados para este tema</h6>
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
<br>