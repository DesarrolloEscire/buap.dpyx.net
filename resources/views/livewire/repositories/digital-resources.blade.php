<div x-data="data()">

    @section('header')
        <x-page-title title="Recursos digitales" description="En esta página podrás subir recursos digitales (PDF, Power Point, Word, Excel, Imágenes, Audios, Videos, Sitios Web, etc.) que tengas desarrollados y que NO SON RECURSOS EDUCATIVOS ABIERTOS (REA)"></x-page-title>
    @endsection

    <div class="row mb-3">
        <div class="col-12">
            <x-subnavigation
                :routes="['ver el REA' => route('repositories.metadata.required.index',[$repository]) ]" />
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <form action="{{ route('repositories.digital-resources.store', [$repository]) }}" method="POST">
                @csrf
                <button class="btn btn-info btn-sm btn-shadow btn-wide">
                    <small><i class="fas fa-plus"></i></small> añadir
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse ($repository->digitalResources as $digitalResource)
            <div class="col-12 col-md-6">
                <div class="card card--shadow">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="label">
                            @if ($digitalResource->files()->exists())
                                <a href="{{route('files.download',[$digitalResource->files()->first()])}}">
                                    {{$digitalResource->files()->first()->name}}
                                </a>
                            @else
                            <span>SIN ARCHIVO</span>
                            @endif
                        </div>
                        <div>
                            <button class="btn btn-outline-danger btn-sm float-right">
                                <small><i class="fas fa-trash"></i></small> eliminar
                            </button>
                            <a href="{{route('digital-resources.metadata.required.index',[$digitalResource])}}" class="btn btn-outline-info btn-sm float-right mr-2">
                                <small><i class="fas fa-eye"></i></small> ver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card card--shadow">
                    <h3 class="text-center text-muted"><small class="text-uppercase">Ningún recurso digital</small></h3>
                </div>
            </div>
        @endforelse
    </div>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        function data(){
            return{
                init(){
                    swal("Recursos digitales", "Herramientas de apoyo a los procesos de enseñanza-aprendizaje en la educación superior, que fomentan la innovación educativa, la actualización docente, la vinculación de la universidad con la sociedad, además, permiten a personas ajenas al sistema educativo formal adquirir las competencias necesarias tanto para su desempeño profesional como para el aprendizaje a lo largo de toda la vida (CODAES).");
                }
            }
        }
    </script>

</div>
