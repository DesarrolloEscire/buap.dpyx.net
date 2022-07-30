<style>
    .ql-tooltip.ql-hidden{
        display: none !important;
    }
</style>

<a href="{{ route('course.panel.progress') }}" class="btn btn-secondary btn-shadow" style="opacity:0.7;position:fixed !important;bottom:55px;right:10px;z-index:10000; border-radius:50%;width:50px;height:50px;display:flex;font-size:1.3rem;" title="Ver progreso">
<div>
        <i class="fas fa-chart-line" style="margin:auto;"></i>
    </a>

    <div class="row bg-white p-0">
        <div class="col-12 p-0">
            <nav class="navbar navbar-dark py-3" style="background-color: #003b5c;color:white !important;">
                <button class="d-block d-lg-none navbar-toggle" type="button" data-target="#menu" data-toggle="collapse">
                    <i class="fas fa-bars"></i> Menú
                </button>
                <div class="d-none d-lg-block"></div>
                <div></div>
                <div>
                    <a href="#" id="btn-prev" class="btn btn-secondary btn-sm rounded-0 btn-shadow">Anterior</a>
                    <a href="#" id="btn-next" class="btn btn-secondary btn-sm rounded-0 btn-shadow">Siguiente</a>
                </div>

            </nav>
        </div>
        <div class="col-12 col-lg-3 p-0">
            <div class="collapse d-lg-block bg-white" id="menu">
                <div class="p-4">
                    <div class="row">
                        <div class="col-12">
                            <h6><i class="fas fa-chart-line"></i> Mi progreso</h6>
                        </div>
                        <!-- <div class="col-12" title="{{ $dates_message }}">
                            <i class="fas fa-tasks"></i> <span>Progreso teórico</span>
                            <div class="progress mb-1" title="{{ $dates_message }}">
                                <div 
                                class="progress-bar {{ (number_format(($teoric_days/$course->duration)*100)) == 0 ? 'text-dark' : '' }} {{ $dates_difference>=($course->duration*0.80) ? 'bg-danger' : 'bg-primary'}}" 
                                role="progressbar" style="width: {{ number_format(($teoric_days/$course->duration)*100) }}%" aria-valuenow="{{ number_format(($teoric_days/$course->duration)*100) }}" aria-valuemin="0" aria-valuemax="100">{{ number_format(($teoric_days/$course->duration)*100) }}% ({{ $dates_difference>=$course->duration ? '+' : '' }}{{$teoric_days}}/{{$course->duration}})</div>
                            </div>
                        </div> -->
                        <div class="col-12">
                            <i class="fas fa-tasks"></i> <span>Cuestionarios</span>
                            <div class="progress mb-1">
                                <div class="progress-bar bg-success {{ (number_format(($user_questionary/$questionary)*100)) == 0 ? 'text-dark' : '' }}" role="progressbar" style="width: {{ number_format(($user_questionary/$questionary)*100) }}%" aria-valuenow="{{ number_format(($user_questionary/$questionary)*100) }}" aria-valuemin="0" aria-valuemax="100">{{ number_format(($user_questionary/$questionary)*100) }}% ({{$user_questionary}}/{{$questionary}})</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <i class="fas fa-pencil-ruler"></i> <span>Tareas</span>
                            <div class="progress mb-1">
                                <div class="progress-bar bg-success {{ (number_format(($user_questionary/$questionary)*100)) == 0 ? 'text-dark' : '' }}" role="progressbar" style="width: {{ number_format(($user_evidences/$evidences)*100) }}%" aria-valuenow="{{ number_format(($user_evidences/$evidences)*100) }}" aria-valuemin="0" aria-valuemax="100">{{ number_format(($user_evidences/$evidences)*100) }}% ({{$user_evidences}}/{{$evidences}})</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('course.panel.progress') }}" class="text-dark" title="Ver progreso">
                                <i class="fas fa-eye"></i> Detalles de mi progreso
                            </a>
                        </div>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a data-order="{{++$counter}}" href="{{ route('course.panel.home') }}" class="nav-link @if(url()->current() == route('course.panel.home')) font-weight-bold active @endif" title="Ir a inicio">
                                {{ $course->title }}
                            </a>
                        </li>
                        @foreach($course->reaCourseTopics()->get() as $index_topic => $topic)
                        <li class="nav-item">
                            <a data-order="{{++$counter}}" href="{{ route('course.panel.topic.view',[$topic]) }}" class="nav-link @if(url()->current() == route('course.panel.topic.view',[$topic])) font-weight-bold active @endif" title="Ir a tema">{{ $topic->topic_name }}</a>
                            <div class="pl-3 collapse{{ (str_contains(url()->current(), route('course.panel.topic.view',[$topic])) ? 'show' : '') }}">
                                <ul class="nav flex-column">
                                    @foreach($topic->modules()->get() as $index_module => $module)
                                    <li class="nav-item">
                                        <a data-order="{{++$counter}}" href="{{ route('course.panel.module.view',[$topic,$module]) }}" class="nav-link @if(url()->current() == route('course.panel.module.view',[$topic,$module])) font-weight-bold active @endif" title="Ir a módulo">{{ $module->module_name }}</a>
                                        <div class="pl-3 collapse{{ (str_contains(url()->current(), route('course.panel.module.view',[$topic,$module])) ? 'show' : '') }}">
                                            <ul class="nav flex-column">
                                                @foreach($module->tasks()->get() as $index_task => $task)
                                                <a data-order="{{++$counter}}" href="{{ route('course.panel.task.view',[$topic,$module,$task]) }}" class="nav-link @if(url()->current() == route('course.panel.task.view',[$topic,$module,$task])) font-weight-bold active @endif" title="Ir a tarea">{{ $task->task_name }}</a>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-9">
            {{ $slot }}
        </div>
    </div>

    <script>
        $.each($('.ql-editor'), function(i, val) {
            $(this).attr('contenteditable', false).css({
                'padding': '0px'
            });
        });
        var
            max_counter = {{$counter}},
            active = $('.active').data('order');


        $(document).on('click', '#btn-prev', function(e) {
            e.preventDefault();
            if (max_counter > active && active > 1) {
                var link = $('.nav-link[data-order="' + (active - 1) + '"]').attr('href');
                window.location.href = link;
            }
        });
        $(document).on('click', '#btn-next', function(e) {
            e.preventDefault();
            if (active >= 1 && active < max_counter) {
                var link = $('.nav-link[data-order="' + (active + 1) + '"]').attr('href');
                window.location.href = link;
            }
        });
    </script>

</div>