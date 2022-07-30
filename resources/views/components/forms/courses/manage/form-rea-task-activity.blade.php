<div x-data="data()">
    <div class="card">
        <div class="card-header bg-{{ ($edit ? 'dark' : 'secondary') }} text-white" style="cursor: pointer;font-weight:200;" data-target="#collapse_{{$activity->id}}" data-toggle="collapse">
            @if($edit)
            <i class="fas fa-eye"></i> &nbsp;Actividad registrada {{ ($index+1) }}
            @else
            <i class="fas fa-plus"></i> &nbsp;Nueva actividad {{ $index+1 }}
            @endif
        </div>
        <div class="card-body {{ $edit ? 'collapse' : '' }}" @if($edit) id="collapse_{{$activity->id}}" @endif)>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="{{$edit ? 'edit_':''}}title_{{$index}}" class="control-label">Título</label>
                        <input type="text" id="{{$edit ? 'edit_':''}}title_{{$index}}" name="{{($edit ? 'title' : 'activities['.$index.'][title]')}}" class="form-control" placeholder="Título" title="Título" value="{{ $edit ? $activity->title : '' }}" required>
                    </div>
                </div>
                <div class="col-12" wire:ignore>
                    <div class="form-group">
                        <label for="{{$edit ? 'edit_' : ''}}instruction_richtext_{{($edit ? $activity->id : $index)}}" class="control-label">Instrucción</label>
                        <div id="{{$edit ? 'edit_' : ''}}instruction_richtext_{{($edit ? $activity->id : $index)}}" @if(!$edit) class="richtext" @endif required>
                            {!! $activity->instruction !!}
                        </div>
                        <textarea id="{{$edit ? 'edit_' : ''}}instruction_hidden_{{($edit ? $activity->id : $index)}}" name="{{ ($edit ? 'instruction' : 'activities['.$index.'][instruction]') }}" style="display:none;" required></textarea>
                    </div>
                </div>
                @if($edit)
                <div class="col-12">
                    <div class="form-group">
                        <label for="{{$edit ? 'edit_' : ''}}customFile_{{($edit ? $activity->id : $index)}}" class="control-label">
                            Cargar PDF
                            @if($edit && $activity->embed_pdf_path)
                            <div>
                                <a class="btn btn-dark btn-shadow rounded-0" href="{{asset('storage/' . $activity->embed_pdf_path)}}" target="_BLANK"><i class="fas fa-eye"></i> Ver documento</a>
                            </div>
                            @endif
                        </label>
                        <div class="custom-file">
                            <input 
                            name="{{ ($edit ? 'file' : 'activities['.$index.'][file]') }}" 
                            type="file" 
                            x-on:change="onFileSelected(event,{{$edit ? 'edit_' : ''}}customFile_{{($edit ? $activity->id : $index)}})" 
                            class="custom-file-input" id="{{$edit ? 'edit_' : ''}}customFile_{{($edit ? $activity->id : $index)}}">
                            <label class="custom-file-label" for="{{$edit ? 'edit_' : ''}}customFile_{{($edit ? $activity->id : $index)}}">seleccionar</label>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-12">
                    <div class="form-group">
                        <label for="{{$edit ? 'edit_' : ''}}type_{{($edit ? $activity->id : $index)}}" class="control-label">Tipo de actividad</label>
                        <select id="{{$edit ? 'edit_':''}}type_{{($edit ? $activity->id : $index)}}" class="form-control" name="{{($edit ? 'type' : 'activities['.$index.'][type]')}}" required>
                            <option value="" disabled selected>Tipo</option>
                            <option value="1" @if($edit && $activity->type == 1) selected @endif >Contenido</option>
                            <option value="2" @if($edit && $activity->type == 2) selected @endif >Cuestionario</option>
                        </select>
                        <small>* Al seleccionar el tipo de actividad <strong>Cuestionario</strong> primero será necesario guardar la actividad para que se habilite la opción <strong>Crear cuestionario</strong> en las opciones de edición de esta actividad</small>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="{{ $edit ? 'edit_':'' }}needs_evidence_{{$index}}" class="control-label">¿Necesita evidencia?</label>
                        <input type="hidden" name="{{($edit ? 'needs_evidence' : 'activities['.$index.'][needs_evidence]')}}" value="0">
                        <input type="checkbox" name="{{($edit ? 'needs_evidence' : 'activities['.$index.'][needs_evidence]')}}" id="{{ $edit ? 'edit_':'' }}needs_evidence_{{$index}}" value="1" {{($edit && $activity->needs_evidence ? 'checked' : '' )}}>
                    </div>
                </div>
            </div>
            <div class="card-footer pr-0">
                {{ $slot }}
            </div>
        </div>
    </div>
    <br>
    <script>
        function data() {
            return {

                onFileSelected(event, element) {
                    const files = event.target.files
                    var id = element.id;

                    if (files && files[0]) {
                        if (files[0].type == 'application/pdf') {
                            var reader = new FileReader();

                            reader.onload = function(e) {
                                var file = e.target.result;
                                $('label.custom-file-label[for="' + id + '"]').text(files[0].name);
                            };

                            reader.readAsDataURL(files[0]);
                        } else {
                            $('label.custom-file-label[for="' + id + '"]').text('seleccionar');
                            element.value = null;
                        }
                    }
                }
            }
        }
    </script>
</div>