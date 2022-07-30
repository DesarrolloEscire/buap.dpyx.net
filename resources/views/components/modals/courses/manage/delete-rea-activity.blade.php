<div id="modalDeleteReaActivity{{$activity->id}}" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar actividad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-justify">
                    ¿Realmente desea elmininar la pregunta <strong>{{ $activity->order }}</strong> de la tarea <strong>{{strtoupper($task->title)}}</strong>? <br>
                    <small>Esta acción es irreversible y si cuenta con algún cuestionario este será eliminado también</small>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-shadow rounded-0" data-dismiss="modal">Cancelar</button>
                <button type="button" data-url="{{ route('course.manage.activity.delete',[$course,$topic,$module,$task,$activity]) }}" class="btn btn-danger btn-shadow rounded-0 btn-submit-activity-delete"><i class="fas fa-trash"></i> Eliminar</button>
            </div>
        </div>
    </div>
</div>