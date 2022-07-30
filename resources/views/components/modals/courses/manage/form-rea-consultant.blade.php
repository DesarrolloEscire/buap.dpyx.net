<div id="modalFormReaConsultant{{$id}}" class="modal" tabindex="-1" style="text-align:justify;">
    <div class="modal-dialog modal-lg">
        <form id="asesor_form_{{$id}}" action="{{ ($edit ? route('course.manage.consultant.update',[$course,$consultant]) : route('course.manage.consultant.store',[$course])) }}" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $edit ? 'Editar asesor' : 'Nuevo asesor' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                @csrf
                @if($edit) @method('PUT') @endif
                <input type="hidden" name="keyclear" value="{{$keyclear}}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="consultant_name" class="control-label">Nombre del asesor</label>
                                <input type="text" id="consultant_name" name="consultant_name" class="form-control" title="Nombre del asesor" placeholder="Nombre del asesor" 
                                value="{{ ($edit ? $consultant->consultant_name : '') }}" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="" class="control-label">Descripción del asesor</label>
                                <div id="asesor_richtext_{{$id}}">{!! $edit ? $consultant->description : '' !!}</div>
                                <textarea name="description" id="asesor_hidden_{{$id}}" style="display:none;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-shadow rounded-0" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary btn-shadow rounded-0 btn-consultant-submit" data-id="{{$id}}">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>