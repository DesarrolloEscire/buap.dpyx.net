<div id="modalDeleteReaQuestion{{$question->id}}" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar pregunta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-justify">
                    ¿Realmente desea elmininar la pregunta <strong>{{ $question->order }}</strong> de la actividad <strong>{{strtoupper($activity->title)}}</strong>? <br>
                    <small>Esta acción es irreversible</small>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-shadow rounded-0" data-dismiss="modal">Cancelar</button>
                <button type="button" data-url="{{ route('course.manage.question.delete',[$course,$topic,$module,$task,$activity,$question]) }}" class="btn btn-danger btn-shadow rounded-0 btn-delete-question"><i class="fas fa-trash"></i> Eliminar</button>
            </div>
        </div>
    </div>
</div>