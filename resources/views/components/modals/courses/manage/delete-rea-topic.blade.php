<div id="modalDeleteReaTopic{{$topic->id}}" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar tema</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('course.manage.topic.delete',[$course,$topic]) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p class="text-justify">
                        ¿Realmente desea elmininar el tema <strong>{{$topic->topic_name}}</strong> del curso <strong>{{strtoupper($course->course_name)}}</strong>? <br>
                        <small>Esta acción es irreversible y borrará los módulos, tareas, recursos, actividades y cuestionarios que pertenecen a esta tarea</small>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-shadow rounded-0" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger btn-shadow rounded-0 btn-submit-topic-delete"><i class="fas fa-trash"></i> Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>