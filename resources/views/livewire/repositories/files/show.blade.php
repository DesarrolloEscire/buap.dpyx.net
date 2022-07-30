<div x-data="data()">
    @section('header')
        <x-page-title title="Mostrar REA"
            description="En esta sección podrás observar los detalles del REA"></x-page-title>
    @endsection

    <div class="row">
        <div class="col-12">
            <x-repositories.submenu :repository="$repository"/>
        </div>
    </div>

    <form id="publish-repository-form" action="{{ route('repositories.metadata.update', [$repository]) }}" method="POST"
        class="row" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        {{-- HEADER --}}

                        <div class="col-12 mb-2">
                            <div class="p-2 rounded mb-2" style="background: #fff098">
                                <i class="fas fa-lightbulb"
                                    style="background: #f5b120; border-radius:50%; padding: 0.3rem"></i>
                                Estamos trabajando en el módulo de "Publica tu REA". Esta
                                función estará habilitado el miércoles 15 de junio
                            </div>
                            <div class="p-2 rounded" style="background: rgb(240, 240, 240)">
                                <i class="fas fa-lightbulb"
                                    style="background: #c7c7c7; border-radius:50%; padding: 0.3rem"></i>
                                El REA que publiques tendrá un Identificador de Objeto Digital
                                (<a target="_blank" href="https://www.doi.org/" class="text-info">DOI</a>) y estará
                                relacionado
                                con tu Identificador Personal (<a target="_blank" href="https://orcid.org/"
                                    class="text-info">ORCID</a>), por
                                lo que el contenido es responsabilidad exclusiva de
                                tu autoría.
                            </div>
                            <hr>
                        </div>

                        {{-- LEFT SIDE --}}

                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-4 mb-2">
                                    <label for="" class="text-muted">Sube el archivo eXeLearning</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">subir</span>
                                        </div>
                                        <div class="custom-file">
                                            <input name="exelearning_file" type="file" class="custom-file-input"
                                                id="exeLearningInputFile">
                                            <label class="custom-file-label" for="exeLearningInputFile">seleccionar
                                                archivo</label>
                                        </div>
                                    </div>
                                    @if ($repository->files()->wherePivot('type', 'exelearning')->exists())
                                        <a
                                            href="{{ route('files.download', [
    $repository->files()->wherePivot('type', 'exelearning')->first(),
]) }}">
                                            {{ $repository->files()->wherePivot('type', 'exelearning')->first()->name ?? '' }}
                                        </a>
                                    @endif
                                </div>
                                <div class="col-12 col-md-4 mb-2">
                                    <label for="" class="text-muted">sube el archivo SCORM</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">subir</span>
                                        </div>
                                        <div class="custom-file">
                                            <input name="scorm_file" type="file" class="custom-file-input"
                                                id="scormInputFile">
                                            <label class="custom-file-label" for="scormInputFile">seleccionar
                                                archivo</label>
                                        </div>
                                    </div>
                                    @if ($repository->files()->wherePivot('type', 'scorm')->exists())
                                        <a
                                            href="{{ route('files.download', [
    $repository->files()->wherePivot('type', 'scorm')->first(),
]) }}">
                                            {{ $repository->files()->wherePivot('type', 'scorm')->first()->name ?? '' }}
                                        </a>
                                    @endif
                                </div>
                                <div class="col-12 col-md-4 mb-2">
                                    <label for="" class="text-muted">Sube el archivo de página web</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">subir</span>
                                        </div>
                                        <div class="custom-file">
                                            <input name="web_file" type="file" class="custom-file-input"
                                                id="webInputFile">
                                            <label class="custom-file-label" for="webInputFile">seleccionar
                                                archivo</label>
                                        </div>
                                    </div>
                                    @if ($repository->files()->wherePivot('type', 'web')->exists())
                                        <a
                                            href="{{ route('files.download', [
    $repository->files()->wherePivot('type', 'web')->first(),
]) }}">
                                            {{ $repository->files()->wherePivot('type', 'web')->first()->name ?? '' }}
                                        </a>
                                    @endif
                                </div>
                                <div class="col-12 mb-2">
                                    <hr>
                                    <label for="" class="text-muted">CONCEPTOS CLAVE</label>
                                </div>
                                <div class="col-12 col-md-3">
                                    <input name="concepts[]" type="text" class="form-control mb-1" maxlength="30"
                                        placeholder="concepto 1"
                                        value="{{ $repository->concepts->get(0)->description ?? '' }}">
                                </div>
                                <div class="col-12 col-md-3">
                                    <input name="concepts[]" type="text" class="form-control mb-1" maxlength="30"
                                        placeholder="concepto 2"
                                        value="{{ $repository->concepts->get(1)->description ?? '' }}">
                                </div>
                                <div class="col-12 col-md-3">
                                    <input name="concepts[]" type="text" class="form-control mb-1" maxlength="30"
                                        placeholder="concepto 3"
                                        value="{{ $repository->concepts->get(2)->description ?? '' }}">
                                </div>
                                <div class="col-12 col-md-3">
                                    <input name="concepts[]" type="text" class="form-control mb-1" maxlength="30"
                                        placeholder="concepto 4"
                                        value="{{ $repository->concepts->get(3)->description ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="row">
            <div class="col-12 mb-2">
                <button type="button" class="btn btn-sm btn-success btn-shadow" x-on:click="onPublish()">
                    <i class="fas fa-book-open"></i> guardar
                </button>
            </div>
        </div>

    </form>

</div>
