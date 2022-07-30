<div>
    @section('header')
    <x-page-title title="Progreso del curso {{strtoupper($course->course_name)}}" description="Este módulo permite revisar las estadísticas del curso {{strtoupper($course->course_name)}}">
    </x-page-title>
    @endsection


    <div class="mb-3 row justify-content-center">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow rounded-0">
                <div class="card-body text-center">
                    <h1>{{ $registeredUsers }}</h1>
                    <h6>Cursos registrados</h6>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow rounded-0">
                <div class="card-body text-center">
                    <h1>{{ $endedUsers }}</h1>
                    <h6>Cursos concluidos</h6>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow rounded-0">
                <div class="card-body text-center">
                    <h1>{{ $processUsers }}</h1>
                    <h6>Cursos en proceso</h6>
                </div>
            </div>
        </div>
    </div>


    <div class="mb-3 row">
        <div class="col-12">
            <p class="text-justify">
                * El botón con el ícono <i class="fas fa-file-excel"></i> genera un reporte en formato de hoja de cálculo basado en los filtros presentados a continuación, en caso de no colocar algún filtro, el reporte exportará toda la información presentada en esta ventana.
            </p>
        </div>
    </div>


    <div class="mb-3 row">
        <div class="col-12 col-md-6 col-lg-4">
            <x-input-search />
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="input-group shadow-sm">
            <div class="input-group-prepend">
                    <span class="input-group-text border-0" id=""><i class="fas fa-school"></i></span>
                </div>
                <select wire:model="searchAcademicUnit" class="custom-select border-0">
                    <option value="" selected>Todas las unidades académicas</option>
                    <option value="Sin filtro">Unidad académica no ligada</option>
                    @foreach($academicUnits as $academicUnit)
                    <option value="{{$academicUnit->name}}">{{ $academicUnit->name }}</option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <span class="input-group-text border-0" id="">
                        <a href=" {{ route('course.board.excel',[($search ? $search : '@'), ($searchAcademicUnit != '' ? $searchAcademicUnit : '@'), ($userStatus != '' ? $userStatus : '@')]) }} " target="_BLANK" class="btn btn-link text-dark p-0">
                            <i class="fas fa-file-excel"></i>
                        </a>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="input-group shadow-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text border-0" id=""><i class="fas fa-chart-line"></i></span>
                </div>
                <select wire:model="userStatus" class="custom-select border-0">
                    <option value="" selected>Todos los cursos</option>
                    <option value="complete">Concluidos</option>
                    <option value="incomplete">En proceso</option>
                </select>
                <div class="input-group-append">
                    <span class="input-group-text border-0" id="">
                    <a href=" {{ route('course.board.excel',[($search ? $search : '@'), ($searchAcademicUnit != '' ? $searchAcademicUnit : '@'), ($userStatus != '' ? $userStatus : '@')]) }} " target="_BLANK" class="btn btn-link text-dark p-0">
                            <i class="fas fa-file-excel"></i>
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3 bg-white shadow table-responsive">
        <table class="table m-0 table-bordered">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-uppercase">Identificador</th>
                    <th class="text-uppercase">Nombre</th>
                    <th class="text-uppercase">Unidad académica</th>
                    <th class="text-uppercase">Cuestionarios</th>
                    <th class="text-uppercase">Tareas</th>
                    <th class="text-uppercase">Estatus</th>
                    <th class="text-uppercase">Inicio del curso</th>
                    <th class="text-uppercase">Fin del curso</th>
                    <th class="text-uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $users as $user_index => $user )
                <tr>
                    <td class="text-center">{{ ($user_index + 1) }}</td>
                    <td>{{ $user->identifier }}</td>
                    <td>{{ $user->name }}</td>
                    <td>
                        @if($user->academicUnits()->exists())
                        {{ $user->academicUnits()->first()->name }}
                        @else
                        <span class="text-danger">Unidad académica no ligada</span>
                        @endif
                    </td>
                    <td style="min-width:150px !important;">
                        <div class="progress" style="height:30px;">
                            <div class="progress-bar bg-success {{ number_format(($user->answered_questionaries/$questionary)*100)==0 ? 'text-dark' : '' }}" role="progressbar" style="width: {{ number_format(($user->answered_questionaries/$questionary)*100) }}%" aria-valuenow="{{ number_format(($user->answered_questionaries/$questionary)*100) }}" aria-valuemin="0" aria-valuemax="100">
                                {{ number_format(($user->answered_questionaries/$questionary)*100) }}% ({{ $user->answered_questionaries }}/{{ $questionary }})
                            </div>
                        </div>
                    </td>
                    <td style="min-width:150px !important;">
                        <div class="progress" style="height:30px;">
                            <div class="progress-bar bg-success {{ number_format(($user->uploaded_evidences/$evidences)*100)==0 ? 'text-dark' : '' }}" role="progressbar" style="width: {{ number_format(($user->uploaded_evidences/$evidences)*100) }}%" aria-valuenow="{{ number_format(($user->uploaded_evidences/$evidences)*100) }}" aria-valuemin="0" aria-valuemax="100">
                                {{ number_format(($user->uploaded_evidences/$evidences)*100) }}% ({{ $user->uploaded_evidences }}/{{ $evidences }})
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        @if($user->status == 'complete')
                        <span>Concluido</span>
                        @elseif($user->status == 'incomplete')
                        <span>En proceso</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span>{{ $user->start }}</span>
                    </td>
                    <td class="text-center">
                        <span>{{ $user->end }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('course.board.teacher',[$user,'board']) }}" class="btn btn-secondary btn-shadow rounded-0"><i class="fas fa-eye"></i> Detalles</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    {{ $users->links() }}

</div>