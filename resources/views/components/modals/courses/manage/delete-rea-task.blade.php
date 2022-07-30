<div id="modalDeleteReaTask{{$task->id}}" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar tarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('course.manage.task.delete',[$course,$topic,$module,$task]) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p class="text-justify">
                        ¿Realmente desea elmininar la tarea <strong>{{$task->task_name}}</strong> del módulo <strong>{{strtoupper($module->module_name)}}</strong>? <br>
                        <small>Esta acción es irreversible y borrará los recursos, actividades y cuestionarios que pertenecen a esta tarea</small>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-shadow rounded-0" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger btn-shadow rounded-0 btn-submit-task-delete"><i class="fas fa-trash"></i> Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>