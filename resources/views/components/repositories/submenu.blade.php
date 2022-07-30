<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link {{$activeSection == 'required' ? 'active' : ''}}" href="{{route('repositories.metadata.required.index',[$repository])}}">
            obligatorio
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{$activeSection == 'optional' ? 'active' : ''}}" href="{{route('repositories.metadata.optional.index',[$repository, 1])}}">
            opcional
        </a>
    </li>
</ul>
