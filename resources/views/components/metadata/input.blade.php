<div repository-id="{{$repository->id}}" metadata-id="{{$metadata->id}}">
    <label class="label__header">{{ $metadata->label }}</label>
    <div>
        {{ $metadata->is_required ? '*' : '' }}
        <i>{{ $metadata->name }}</i>
    </div>

    @foreach ($metadata->metadataValues()->whereRepository($repository)->get() as $metadataValue)
        <input name="metadata[{{ $metadata->name }}][]" type="text" class="form-control mb-1" value="{{$metadataValue->value}}" readonly>
    @endforeach

    @if (!$metadata->is_dropdown && !$metadata->is_qualdrop_value)
        <input type="text"
            value="{{ $repository->metadataValues()->whereMetadata($metadata)->first()->value ?? '' }}"
            class="form-control" placeholder="valor" {{ $metadata->is_required ? 'required' : '' }}>
    @endif

    @if ($metadata->is_dropdown)
        <select class="form-control">
            <option value="" hidden>seleccionar</option>
            @foreach (value_pairs($metadata->value_pair_group) as $value_pair)
                <option value="{{ $value_pair['stored_value'] }}">
                    {{ $value_pair['displayed_value'] }}
                </option>
            @endforeach
        </select>
    @endif
    
    <small class="text-muted">{{ $metadata->hint }}</small>

    <script>

    </script>
</div>
