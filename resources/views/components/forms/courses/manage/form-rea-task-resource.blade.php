<div>
    <div class="card">
        <div class="card-header bg-{{ ($edit ? 'dark' : 'secondary') }} text-white" style="cursor: pointer;font-weight:200;" data-target="#collapse_{{$resource->id}}" data-toggle="collapse">
            @if($edit)
            <i class="fas fa-eye"></i> &nbsp;Recurso registrado {{ $resource->order }}
            @else
            <i class="fas fa-plus"></i> &nbsp;Nuevo recurso {{ $index+1 }}
            @endif
        </div>
        <div class="card-body {{ $edit ? 'collapse' : '' }}" @if($edit) id="collapse_{{$resource->id}}"  @endif)>
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="{{$edit ? 'edit_':''}}resource_category_{{$index}}" class="control-label">Categoría </label>
                        <select 
                        id="{{$edit ? 'edit_':''}}resource_category_{{$index}}"
                        class="form-control" 
                        name="{{($edit ? 'resource_category' : 'resources['.$index.'][resource_category]')}}" 
                        required>
                            <option value="" disabled selected>Categoría</option>
                            <option value="1" @if($edit && $resource->resource_category == 1) selected @endif >Obligatorio</option>
                            <option value="2" @if($edit && $resource->resource_category == 2) selected @endif >Complementario</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="{{$edit ? 'edit_':''}}resource_type_{{$index}}" class="control-label">Tipo</label>
                        <select 
                        name="{{ ($edit ? 'resource_type' : 'resources['.$index.'][resource_type]')}}"
                        id="{{$edit ? 'edit_':''}}resource_type_{{$index}}" 
                        class="form-control" 
                        required>
                            <option value="" disabled selected>Tipo</option>
                            <option value="img" @if($edit && $resource->resource_type == 'img') selected @endif >Imagen</option>
                            <option value="pdf" @if($edit && $resource->resource_type == 'pdf') selected @endif >Documento PDF</option>
                            <option value="web" @if($edit && $resource->resource_type == 'web') selected @endif >Sitio web</option>
                            <option value="video" @if($edit && $resource->resource_type == 'video') selected @endif >Video</option>
                        </select>
                    </div>
                </div>
                <div class="col-12" wire:ignore>
                    <div class="form-group">
                        <label for="{{$edit ? 'edit_' : ''}}resource_description_richtext_{{($edit ? $resource->id : $index)}}" class="control-label">Descripción</label>
                        <div id="{{$edit ? 'edit_' : ''}}resource_description_richtext_{{($edit ? $resource->id : $index)}}" @if(!$edit) class="richtext" @endif required>
                            {!! $resource->resource_description !!}
                        </div>
                        <textarea 
                        id="{{$edit ? 'edit_' : ''}}resource_description_hidden_{{($edit ? $resource->id : $index)}}" 
                        name="{{ ($edit ? 'resource_description' : 'resources['.$index.'][resource_description]') }}" 
                        style="display:none;" required></textarea>
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