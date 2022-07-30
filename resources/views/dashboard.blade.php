<x-app-layout>

    @section('header')
    <x-page-title title="Tablero" description="¡Bienvenido! Debajo aparecen una serie de instrucciones para el uso adecuado de {{getenv('APP_NAME')}}"></x-page-title>
    @endsection

    @include('sweetalert::alert')

    <link rel="stylesheet" href="{{url('css/dashboard.css')}}?20220616">

    <div class="container-fluid">
        <!-- Carousel -->
        <div class="banner-section">
            <div id="carouselBanners" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselBanners" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselBanners" data-slide-to="1"></li>
                    <li data-target="#carouselBanners" data-slide-to="2"></li>
                    <li data-target="#carouselBanners" data-slide-to="3"></li>
                    <li data-target="#carouselBanners" data-slide-to="4"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ url('/images/dashboard/banners/1.jpg') }}?{{date('Ymdhms')}}" alt="" class="background-img">
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ url('/images/dashboard/banners/2.jpg') }}?{{date('Ymdhms')}}" alt="" class="background-img">
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ url('/images/dashboard/banners/3.jpg') }}?{{date('Ymdhms')}}" alt="" class="background-img">
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ url('/images/dashboard/banners/4.jpg') }}?{{date('Ymdhms')}}" alt="" class="background-img">
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ url('/images/dashboard/banners/5.jpg') }}?{{date('Ymdhms')}}" alt="" class="background-img">
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselBanners" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselBanners" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="row justify-content-center row-section">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card card-static card-1">
                    <div class="card-body">
                        <div class="background-container"></div>
                        <div class="card-content">
                            <h3>Continúa aprendiendo</h3>
                            <a href="{{ route('reas.iframe') }}" class="btn btn-secondary button_continuar_curso">Continuar curso <i class="fas fa-play"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <!-- REA -->
                <div class="row justify-content-center row-section">
                    <div class="col-12">
                        <h2 class="blue-text title-text">REA</h2>
                        <hr>
                    </div>
                    <div class="text-center col-12 col-md-3">
                        <a href="{{url('/reas')}}" class="btn-circle blue-background">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </a>
                        <strong class="blue-text">Curso REA</strong>
                    </div>
                    <div class="text-center col-12 col-md-3">
                        <a href="{{url('/repositories')}}" class="btn-circle blue-background">
                            <i class="fas fa-clipboard-list"></i>
                        </a>
                        <strong class="blue-text">Evalúa tu REA</strong>
                    </div>
                    <div class="text-center col-12 col-md-3">
                        <a href="#" class="btn-circle blue-background" title="Próximamente">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </a>
                        <strong class="blue-text">Publica tu REA</strong>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <!-- Asignaturas -->
                <div class="row justify-content-center row-section">
                    <div class="col-12">
                        <h2 class="blue-text title-text">Asignaturas</h2>
                        <hr>
                    </div>
                    <div class="text-center col-12 col-md-3">
                        <a href="https://asignatura.buap.mx/asignaturas" target="_BLANK" class="btn-circle light-blue-background">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <strong class="blue-text">Programa de asignaturas</strong>
                    </div>
                    <div class="text-center col-12 col-md-3">
                        <a href="https://asignatura.buap.mx/planeaciones" target="_BLANK" class="btn-circle light-blue-background">
                            <i class="fas fa-cogs"></i>
                        </a>
                        <strong class="blue-text">Planeaciones didácticas</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <!-- Noticias -->
        <!-- <div class="row justify-content-center row-section">
            <div class="col-12 text-center">
                <h2 class="title-text text-dark">Noticias</h2>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <img src="https://via.placeholder.com/1920x1080" alt="" class="card-img-top">
                    <div class="card-footer text-center bg-white">
                        <a href="#" class="btn btn-primary">Noticia 1</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <img src="https://via.placeholder.com/1920x1080" alt="" class="card-img-top">
                    <div class="card-footer text-center bg-white">
                        <a href="#" class="btn btn-primary">Noticia 2</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <img src="https://via.placeholder.com/1920x1080" alt="" class="card-img-top">
                    <div class="card-footer text-center bg-white">
                        <a href="#" class="btn btn-primary">Noticia 3</a>
                    </div>
                </div>
            </div>
        </div> -->
    </div>   
</x-app-layout>