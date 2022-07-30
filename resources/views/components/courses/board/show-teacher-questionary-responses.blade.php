<div id="modalQuestionaryResponses{{$questionary->id}}" class="modal" tabindex="-1" style="text-align:justify;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Respuestas del cuestionario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <h4>{{ $topic }} / {{ $module }}</h4>
                        <h6>{{ $task }}</h6>
                        <hr>
                        <span>Aciertos: <strong>{{ $hits }}/{{ $questionary->questions()->count() }}</strong></span>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <ul class="list-group">
                            @foreach($questionary->questions()->get() as $question_index => $question)
                            <li class="list-group-item my-2 {{ ($question->correct_answer == $responses[$question->id]->selected_option ? 'border-success' : 'border-danger') }}">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="{{ ($question->correct_answer == $responses[$question->id]->selected_option ? 'text-success' : 'text-danger') }}">
                                            @if($question->correct_answer == $responses[$question->id]->selected_option)
                                            <i class="fas fa-check-circle text-success"></i>
                                            @else
                                            <i class="fas fa-times-circle text-danger"></i>
                                            @endif
                                            Pregunta {{ ($question_index+1) }}:
                                        </div>
                                        {!! $question->question !!}
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                    <div class="col-12">
                                        <i>Respuesta del docente: <br> 
                                        <strong>{{ ucfirst($responses[$question->id]->selected_option) }}) {{ $responses[$question->id]->response }}</strong></i>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-shadow rounded-0" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        </form>
    </div>
</div>