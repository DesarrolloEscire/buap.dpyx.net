<div id="modalFormReaModule{{$id}}" class="modal" tabindex="-1" style="text-align:justify;">
    <div class="modal-dialog modal-lg">
        <form id="module_form_{{$id}}" action="{{ $edit ? route('course.manage.module.update',[$course,$topic,$module]) : route('course.manage.module.store',[$course,$topic]) }}" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $edit ? 'Editar módulo' : 'Nuevo módulo' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                @csrf
                @if($edit) @method('PUT') @endif
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="" class="control-label">Nombre del módulo</label>
                                <input type="text" class="form-control" id="module_name" name="module_name" maxlength="200" placeholder="Nombre del módulo" title="Nombre del módulo" required value="{{ $edit ? $module->module_name: '' }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="" class="control-label">Título</label>
                                <input type="text" class="form-control" id="title" name="title" maxlength="200" placeholder="Título del módulo" title="Título del módulo" required value="{{ $edit ? $module->title: '' }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="" class="control-label">Objetivo</label>
                                <textarea name="goal" class="form-control" rows="3" placeholder="Objetivo del módulo">{{ ($edit ? $module->goal : '') }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="" class="control-label">Descripción</label>
                                <div id="module_richtext_{{$id}}">{!! $edit ? $module->description : '' !!}</div>
                                <textarea name="description" id="module_hidden_{{$id}}" style="display:none;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-shadow rounded-0" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary btn-shadow rounded-0 btn-module-submit" data-id="{{$id}}">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>