<div class="mb-4">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.5/pdfobject.min.js" integrity="sha512-K4UtqDEi6MR5oZo0YJieEqqsPMsrWa9rGDWMK2ygySdRQ+DtwmuBXAllehaopjKpbxrmXmeBo77vjA2ylTYhRA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <div class="row d-flex justify-content-center">

        @section('header')
            <x-page-title title="Edición de constancias"
                description="En este módulo puedes editar las constancias emitidas"></x-page-title>
        @endsection

        <div class="col-4">
            <div class="card shadow border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label text-uppercase text-muted" for="flexCheckDefault">
                                    ¿Emitir constancias cuando un REA es aprobado?
                                </label>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label text-uppercase text-muted" for="flexCheckDefault">
                                    ¿Incluye nombre del REA?
                                </label>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label text-uppercase text-muted" for="flexCheckDefault">
                                    ¿Incluye fecha de emisión?
                                </label>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <label for="" class="text-muted text-uppercase">Título de cabecera</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-12 mt-3">
                            <label for="" class="text-muted text-uppercase">Cuerpo del texto</label>
                            <textarea name="" id="" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-success btn-wide rounded-0 btn-shadow float-right mt-3">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>

        <div class="col-8">
            <div class="card" style="height: 100%">
                <p class="ml-4 mt-4">
                    A continuación se muestra un ejemplo de la constancia actual
                </p>
                <div class="card-body" id="pdf-viewer">
                    <iframe width="90%" src="{{asset('files/nombreDeTuPdf.pdf')}}" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script>
        PDFObject.embed("{{ route('constancies.pdf') }}", "#pdf-viewer");
    </script>
</div>
