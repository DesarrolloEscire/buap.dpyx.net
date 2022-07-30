<div id="modalFormReaTopic{{$id}}" class="modal" tabindex="-1" style="text-align:justify;">
    <div class="modal-dialog modal-lg">
        <form id="topic_form_{{$id}}" action="{{ $edit ? route('course.manage.topic.update',[$course,$topic]) : route('course.manage.topic.store',[$course]) }}" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $edit ? 'Editar tema' : 'Nuevo tema' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                @csrf
                @if($edit) @method('PUT') @endif
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="" class="control-label">Nombre del tema</label>
                                <input type="text" class="form-control" id="topic_name" name="topic_name" maxlength="200" placeholder="Nombre del tema" title="Nombre del tema" required value="{{ $edit ? $topic->topic_name: '' }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="" class="control-label">Título</label>
                                <input type="text" class="form-control" id="title" name="title" maxlength="200" placeholder="Título del tema" title="Título del tema" required value="{{ $edit ? $topic->title: '' }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="" class="control-label">Descripción</label>
                                <div id="topic_richtext_{{$id}}">{!! $edit ? $topic->description : '' !!}</div>
                                <textarea name="description" id="topic_hidden_{{$id}}" style="display:none;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-shadow rounded-0" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary btn-shadow rounded-0 btn-topic-submit" data-id="{{$id}}">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>