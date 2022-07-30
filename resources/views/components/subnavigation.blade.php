<div>
    <i class="fas fa-globe mr-1"></i> /
    @foreach ($routes as $routeText => $route)
        <a class="text-info" href="{{$route}}">{{$routeText}}</a> /
    @endforeach
</div>