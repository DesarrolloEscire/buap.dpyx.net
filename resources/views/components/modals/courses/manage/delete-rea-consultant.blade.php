<div id="modalDeleteReaConsultant{{$consultant->id}}" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar asesor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('course.manage.consultant.delete',[$course,$consultant]) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="keyclear" value="{{$keyclear}}">
                <div class="modal-body">
                    <p class="text-justify">
                        ¿Realmente desea elmininar a <strong>{{$consultant->consultant_name}}</strong> de la lista de asesores del curso <strong>{{strtoupper($course->course_name)}}</strong>? <br>
                        <small>Esta acción es irreversible</small>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-shadow rounded-0" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger btn-shadow rounded-0"><i class="fas fa-trash"></i> Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>