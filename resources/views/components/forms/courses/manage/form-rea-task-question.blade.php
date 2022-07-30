<div>
    <div class="card">
        <div class="card-header bg-{{ ($edit ? 'dark' : 'secondary') }} text-white" style="cursor: pointer;font-weight:200;" data-target="#collapse_{{$question->id}}" data-toggle="collapse">
            @if($edit)
            <i class="fas fa-eye"></i> &nbsp;Pregunta registrada {{ $question->order }}
            @else
            <i class="fas fa-plus"></i> &nbsp;Nueva pregunta {{ $index+1 }}
            @endif
        </div>

        <div class="card-body {{ $edit ? 'collapse' : '' }}" @if($edit) id="collapse_{{$question->id}}" @endif)>
            <div class="row">
                <div class="col-12">
                    <div class="form-group" wire:ignore>
                        <label for="{{$edit ? 'edit_' : ''}}question_richtext_{{($edit ? $question->id : $index)}}" class="control-label">Pregunta</label>
                        <div id="{{$edit ? 'edit_' : ''}}question_richtext_{{($edit ? $question->id : $index)}}" @if(!$edit) class="richtext" @endif required>
                            {!! $question->question !!}
                        </div>
                        <textarea id="{{$edit ? 'edit_' : ''}}question_hidden_{{($edit ? $question->id : $index)}}" name="{{ ($edit ? 'question' : 'questions['.$index.'][question]') }}" style="display:none;" required></textarea>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="{{ $edit ? 'edit_' : '' }}answer_a_{{$index}}" class="control-label">Respuesta A</label>
                        <input type="text" id="{{ $edit ? 'edit_' : '' }}answer_a_{{$index}}" name="{{ $edit ? 'answer_a' : 'questions['.$index.'][answer_a]' }}" class="form-control" placeholder="Respuesta A" title="Respuesta A" value="{{ $edit ? $question->answer_a : '' }}" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="{{ $edit ? 'edit_' : '' }}answer_b_{{$index}}" class="control-label">Respuesta B</label>
                        <input type="text" id="{{ $edit ? 'edit_' : '' }}answer_b_{{$index}}" name="{{ $edit ? 'answer_b' : 'questions['.$index.'][answer_b]' }}" class="form-control" placeholder="Respuesta B" title="Respuesta B" value="{{ $edit ? $question->answer_b : '' }}" required>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="{{ $edit ? 'edit_' : '' }}answer_c_{{$index}}" class="control-label">Respuesta C</label>
                        <input type="text" id="{{ $edit ? 'edit_' : '' }}answer_c_{{$index}}" name="{{ $edit ? 'answer_c' : 'questions['.$index.'][answer_c]' }}" class="form-control" placeholder="Respuesta C" title="Respuesta C" value="{{ $edit ? $question->answer_c : '' }}">
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                    <label for="{{$edit ? 'edit_' : ''}}correct_answer_{{($edit ? $question->id : $index)}}" class="control-label">Respuesta correcta</label>
                        <select 
                        id="{{$edit ? 'edit_':''}}correct_answer_{{($edit ? $question->id : $index)}}"
                        class="form-control" 
                        name="{{($edit ? 'correct_answer' : 'questions['.$index.'][correct_answer]')}}" 
                        required>
                            <option value="" disabled selected>Respuesta correcta</option>
                            <option value="a" @if($edit && $question->correct_answer == 'a') selected @endif >Respuesta A</option>
                            <option value="b" @if($edit && $question->correct_answer == 'b') selected @endif >Respuesta B</option>
                            <option value="c" @if($edit && $question->correct_answer == 'c') selected @endif >Respuesta C</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-footer pr-0">
                {{ $slot }}
            </div>
        </div>
    </div>
    <br>
</div>