<div id="modalDeleteReaModule{{$module->id}}" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar módulo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('course.manage.module.delete',[$course,$topic,$module,$module]) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p class="text-justify">
                        ¿Realmente desea elmininar el módulo <strong>{{$module->module_name}}</strong> del tema <strong>{{strtoupper($topic->topic_name)}}</strong>? <br>
                        <small>Esta acción es irreversible y borrará las tareas, recursos, actividades y cuestionarios que pertenecen a esta tarea</small>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-shadow rounded-0" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger btn-shadow rounded-0 btn-submit-module-delete"><i class="fas fa-trash"></i> Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>