<div class="mb-4" x-data="data()">

    @section('header')
    <x-page-title title="Lista de {{ __('containerNamePlural') }}" description="{{ __('messages.views.livewire.repositories.index.text1') }}"></x-page-title>
    @endsection

    <div class="mb-3 d-flex row justify-content-center">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow rounded-0">
                <div class="card-body text-center">
                    <h1>{{ $total_rea }}</h1>
                    <h6>REAs registrados</h6>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow rounded-0">
                <div class="card-body text-center">
                    <h1>{{ $total_published_rea }}</h1>
                    <h6>REAs publicados</h6>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow rounded-0">
                <div class="card-body text-center">
                    <h1>{{ $total_unpublished_rea }}</h1>
                    <h6>REAs no publicados</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3 row d-flex justify-content-between">
        
        <div class="mb-3 col-12 col-lg-{{ ((auth()->user()->is_admin) ? '3' : '4') }}">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text border-0" id="basic-addon1">
                        <i class="fas fa-chart-line"></i>
                    </span>
                </div>
                <select wire:model='progress_filter' class="form-control border-0 rounded-0 shadow">
                    <option value="" selected>Todos los progresos</option>
                    <option value="no_iniciado">No han realizado el curso</option>
                    <option value="cuestionarios">Cuestionario en progreso</option>
                    <option value="avances">Con avances</option>
                    <option value="terminados">Terminados</option>
                </select>
            </div>
        </div>

        <div class="mb-3 col-12 col-lg-{{ ((auth()->user()->is_admin) ? '3' : '4') }}">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text border-0" id="basic-addon1">
                        <i class="fas fa-tasks"></i>
                    </span>
                </div>
                <select wire:model='search_filter' class="form-control border-0 rounded-0 shadow">
                    <option value="Sin filtro" selected>Todas las evaluaciones</option>
                    <option value="Filtrar en progreso">Filtrar en progreso</option>
                    <option value="Filtrar en evaluación">Filtrar en evaluación</option>
                    <option value="Filtrar con observaciones">Filtrar con observaciones</option>
                    <option value="Filtrar aprobado">Filtrar aprobado</option>
                    <option value="Filtrar rechazado">Filtrar rechazado</option>
                </select>
            </div>
        </div>

        <div class="mb-3 col-12 col-lg-{{ ((auth()->user()->is_admin) ? '3' : '4') }}">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text border-0" id="basic-addon1">
                        <i class="fas fa-check"></i>
                    </span>
                </div>
                <select wire:model="publish_filter" class="form-control border-0 rounded-0 shadow">
                    <option value="">Todos los estatus</option>
                    <option value="publicado">Publicado</option>
                    <option value="no_publicado">No publicado</option>
                </select>
            </div>
        </div>

        @if(auth()->user()->is_admin)
        <div class="mb-3 col-12 col-lg-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text border-0" id="basic-addon1">
                        <i class="fas fa-users"></i>
                    </span>
                </div>
                <select wire:model="evaluator_filter" class="form-control border-0 rounded-0 shadow">
                    <option value="">Todos los evaluadores</option>
                    @foreach($evaluators as $evaluator)
                    <option value="{{ $evaluator->id }}">{{ $evaluator->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif

        <div class="col-12">
            <x-input-search />
        </div>
    </div>

    <div class="mb-3 row d-flex justify-content-between">
        <div class="col-12">
            <hr>
        </div>
        <div class="col-12 col-lg-4">
            @if (auth()->user()->is_evaluator || auth()->user()->is_admin)
            <a 
            href="{{ route('repositories.download.excel',[($search != '' ? $search : 'null'), ($search_filter != 'Sin filtro' ? $search_filter : 'null'), ($publish_filter != '' ? $publish_filter : 'null'), ($evaluator_filter != '' ? $evaluator_filter : 'null'), ($progress_filter != '' ? $progress_filter : 'null')]) }}"
            target="_BLANK"
            class="btn btn-success rounded-0 btn-shadow"
            title="Generar reporte Excel"><i class="fas fa-file-excel"></i> Generar Excel</a>
            @endif
        </div>
        <div class="text-right col-12 col-lg-4">
            @if (auth()->user()->is_evaluator || auth()->user()->is_admin)
            <span class="ml-2 text-info">
                AGLOMERADO GENERAL
            </span>
            <a href="{{ route('repositories.statistics.all') }}" class="btn btn-info btn-shadow rounded-0">
                <i class="fas fa-chart-pie"></i>
            </a>
            @endif
        </div>
    </div>

    <div class="mb-3 bg-white shadow table-responsive">
        <table class="table m-0 table-bordered">
            <thead>
                <tr>
                    <th class="text-uppercase">#</th>
                    <th class="text-uppercase">Nombre</th>
                    <th class="text-uppercase" nowrap>Publica tu REA</th>
                    <th class="text-uppercase">estatus</th>
                    @if (auth()->user()->is_admin || auth()->user()->is_evaluator)
                        <th class="text-uppercase" nowrap>recursos digitales</th>
                    @endif
                    <th class="text-uppercase">Cuestionario</th>
                    <th class="text-uppercase" nowrap>Progreso del curso REA</th>
                    <th class="text-uppercase">Encargado</th>
                    @if (auth()->user()->is_admin)
                    <th class="text-uppercase">Evaluador</th>
                    @endif
                    <th class="text-uppercase">{{ __('containerName') }}</th>
                    <th class="text-uppercase">Evaluación</th>
                    <th class="text-uppercase" nowrap>Gráfica de resultados</th>
                    <th class="text-uppercase">Historial</th>
                    <th class="text-uppercase">PDF</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($repositories as $repository_index => $repository)
                <tr>
                    <td>{{ $repository_index + 1 }}</td>
                    <td>
                        {{ $repository->name }}
                    </td>

                    {{-- PUBLISH REA --}}

                    <td class="text-center">
                        <a class="btn btn-success btn-shadow rounded-0" href="{{ route('repositories.metadata.required.index', [$repository]) }}">
                            <i class="fas fa-book-open"></i>
                        </a>
                    </td>
                    {{-- END PUBLUSH REA --}}

                    <td class="text-center">
                        @if ($repository->is_published)
                        <div class="status status--sm status--green">Publicado</div>
                        @else
                        <div class="status status--sm status--red">No publicado</div>
                        @endif
                    </td>

                    <td class="text-center">
                        <a href="{{route('repositories.digital-resources.index',[$repository])}}" class="btn btn-info btn-shadow rounded-0">
                            <i class="fas fa-box"></i>
                        </a>
                    </td>

                    <td class="text-center">
                        <a href="{{ route('evaluations.categories.questions.index', [$repository->evaluation, $firstCategory]) }}" class="btn btn-{{ $repository->evaluation->is_reviewed && $repository->is_aproved ? 'secondary' : 'primary' }} btn-shadow rounded-0 {{ $repository->evaluation->is_viewable ? '' : 'disabled' }}" data-{{ $repository->evaluation->is_viewable ? 'a' : 'b' }}>
                            <i class="fas fa-scroll"></i>
                        </a>
                    </td>

                    <td nowrap class="text-center">
                        @if ($repository->responsible->reaCourseResponses()->count() > 0 && $repository->responsible->reaCourseEvidences()->count() == 0)
                        <span>
                            Cuestionario en progreso
                        </span>
                        @elseif ($repository->responsible->reaCourseResponses()->count() > 0 && $repository->responsible->reaCourseEvidences()->count() > 0)
                        <a href="{{ route('course.board.teacher', [$repository->responsible->id, 'evaluation']) }}" class="btn btn-secondary btn-shadow rounded-0" title="Ver progreso del curso REA">
                            <i class="fas fa-chart-line"></i>
                            ({{ $this->course($repository->responsible) }}%)
                        </a>
                        @else
                        <span class="text-danger">
                            No ha realizado el curso
                        </span>
                        @endif
                    </td>

                    <td nowrap>{{ $repository->responsible->name }}</td>

                    @if (auth()->user()->is_admin)
                    <td nowrap>
                        @if ($repository->evaluation && isset($repository->evaluation->evaluator->name))
                        {{ $repository->evaluation->evaluator->name }} @else 'N/A' @endif
                    </td>
                    @endif
                    <td class="text-center">
                        <span class="badge badge-{{ $repository->status_color }}">
                            @if ($repository->evaluation->in_review)
                            En evaluación
                            @else
                            {{ $repository->status }}
                            @endif
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-{{ $repository->evaluation->status_color }}">
                            @if ($repository->is_aproved || $repository->is_rejected)
                            Concluido
                            @else
                            {{ $repository->evaluation->status }}
                            @endif
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('repositories.statistics.show', [$repository]) }}" class="btn btn-info btn-shadow rounded-0 {{ $repository->evaluation->answers->whereNotNull('choice_id')->count() ? '' : 'disabled' }}">
                            <i class="fas fa-chart-pie"></i>
                        </a>
                    </td>


                    <td class="text-center">
                        <button type="button" class="btn btn-info btn-shadow rounded-0" data-toggle="modal" data-target="#showEvaluationHistory{{ $repository->evaluation->id }}">
                            <i class="fas fa-history"></i>
                        </button>
                        <x-modals.evaluations.history :evaluation="$repository->evaluation"/>
                    </td>
                    <td>
                        <a href="{{ route('evaluations.pdf', [$repository->evaluation]) }}" class="btn btn-secondary btn-shadow rounded-0">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="">
        {{ $repositories->links() }}
    </div>

    <script>
        function data() {
            return {

            }
        }
    </script>

</div>