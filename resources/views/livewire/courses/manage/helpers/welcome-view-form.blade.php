<div class="row">
    <div class="col-12 col-md-3">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            @foreach($course->reaCourseSections()->get() as $key => $section)
            @php
            $keyclear = str_replace('seccion_','',$section->key_section);
            $active = (($tab == 'sections' && $pill != NULL && $pill == $keyclear) || ($pill == NULL && $key==0));
            @endphp

            <a 
                class="nav-link rounded-0 btn-shadow {{ ( $active ? 'active' : '' ) }}" 
                id="{{ $section->key_section }}-tab" 
                href="{{ route('course.manage' ,['sections',str_replace('seccion_','',$section->key_section)]) }}" 
                aria-selected="{{ ( $active ? 'true' : 'false' ) }}">
                {{ ($section->title === null ? $section->key_section : $section->title) }}
            </a>
            @endforeach
        </div>

    </div>
    <div class="col-12 col-lg-9">
        <div class="tab-content" id="v-pills-tabContent">

            @foreach($course->reaCourseSections()->get() as $key => $section)
            
            @php
            $keyclear = str_replace('seccion_','',$section->key_section);
            $active = (($tab == 'sections' && $pill != NULL && $pill == $keyclear) || ($pill == NULL && $key==0));
            @endphp

            <div 
                class="tab-pane fade {{($active ? ' show active' : '')}}" 
                id="{{$section->key_section}}">
                <form action="{{ route('course.manage.section', [$section] ) }}" method="POST" class="section-form" id="{{$section->key_section}}_form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="keyclear" value="{{$keyclear}}">
                    <div class="row">
                        <div class="col-12">
                            <h4>Sección - {{ ($section->title == NULL ? $section->key_section : $section->title) }}</h4>
                            <hr>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="" class="control-label">Título</label>
                                <input type="text" class="form-control" name="title" value="{{$section->title}}" maxlength="200" required placeholder="Título">
                            </div>
                        </div>
                        @if($section->key_section != 'seccion_asesores')
                        <div class="col-12">
                            <div class="form-group">
                                <label for="" class="control-label">Descripción general</label>
                                <div id="{{$section->key_section}}_richtext">{!! $section->description !!}</div>
                                <textarea name="description" id="{{$section->key_section}}_hidden" style="display:none"></textarea>
                            </div>
                        </div>
                        @endif
                        <div class="col-12">
                            <div class="form-group text-right">
                                <!-- <label for="icono_principal" class="btn btn-info btn-shadow rounded-0">
                                    <i class="fas fa-cloud-upload-alt"></i> Cargar ícono
                                    <input id="icono_principal" type="file" hidden>
                                </label> -->
                                <button class="btn btn-primary btn-shadow rounded-0"><i class="fas fa-save"></i> Guardar</button>
                            </div>
                            <hr>
                        </div>
                    </div>
                </form>
                @if($section->key_section == 'seccion_asesores')
                <div class="row">
                    <div class="col-12">
                        <h5>Lista de asesores</h5>
                        <hr>
                    </div>
                    <div class="col-12">
                        <button 
                        type="button" 
                        class="btn btn-primary btn-shadow rounded-0 mb-3 float-right btn-consultant-modal" 
                        data-id="0" 
                        data-target="#modalFormReaConsultant0" 
                        data-toggle="modal" 
                        title="Nuevo asesor"><i class="fas fa-plus"></i> Nuevo asesor</button>
                        <x-modals.courses.manage.form-rea-consultant edit="false" :course="$course" :keyclear="$keyclear"></x-modals.courses.manage.form-rea-consultant>
                    </div>
                    <div class="col-12">
                        <div class="bg-white shadow table-responsive">
                            <table id="table-consultants" class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Asesor</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($course->reaCourseConsultants()->get() as $consultant)
                                    <tr data-id="{{$consultant->id}}" data-order="{{$consultant->order}}">
                                        <td class="p-3" style="cursor:move;" title="Arrastrar para ordenar registro"><i class="fas fa-grip-vertical"></i></td>
                                        <td>{{ $consultant->consultant_name }}</td>
                                        <td>{!! $consultant->description !!}</td>
                                        <td class="td-actions">
                                            <button type="button" class="btn btn-primary btn-shadow rounded-0 btn-consultant-modal" data-id="{{$consultant->id}}" data-target="#modalFormReaConsultant{{$consultant->id}}" data-toggle="modal" title="Editar asesor">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <x-modals.courses.manage.form-rea-consultant edit="true" :consultant="$consultant" :course="$course" :id="$consultant->id" :keyclear="$keyclear"></x-modals.courses.manage.form-rea-consultant>
                                            
                                            <button type="button" class="btn btn-danger btn-shadow rounded-0" data-id="{{$consultant->id}}" data-target="#modalDeleteReaConsultant{{$consultant->id}}" data-toggle="modal" title="Eliminar asesor">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <x-modals.courses.manage.delete-rea-consultant :consultant="$consultant" :course="$course" :keyclear="$keyclear"></x-modals.courses.manage.delete-rea-consultant>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            No hay asesores registrados
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @endforeach
            <form id="sort_consultants_form" action="{{ route('course.manage.consultant.sort',[$course]) }}" method="POST">
                @csrf 
                @method('PATCH')
                <input type="hidden" name="consultantOrderedList" id="consultantOrderedList">
            </form>
        </div>

    </div>
</div>