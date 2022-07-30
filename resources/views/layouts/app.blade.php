<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- Meta --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="This is a project about repositories.">
    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">
    {{-- <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}"> --}}
    <link rel="shortcut icon" href="{{ asset('images/default/logo.png?2022') }}" type='image/png' />

    {{-- Title --}}
    <title>{{ config('app.name', 'Laravel') }}</title>

    <base href="{{url('')}}">

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>


    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset('css/app.css?2022-07-08') }}">
    <link rel="stylesheet" href="{{ asset('css/kero.css?2022-07-08') }}">
    <link href="{{asset('css/quill.snow.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('vendor/OwlCarousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/OwlCarousel/assets/owl.theme.default.min.css') }}">

    <style>
        .app-sidebar {
            background: {{ config('dpyx.menu_color') }} !important;
        }

        .bg-info {
            background: {{ config('dpyx.dropdown_menu_header_background_color') }} !important;
        }

        .img-responsive{width: 80%;}

        .d-border-top {
            border-top: 5px solid {{ config('dpyx.border_top_color') }};
        }

        body {}

        .container.app-main__outer {
            margin: 0px !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        .container.app-main__inner {
            width: 100% !important;
            max-width: 100% !important;
        }

        .blue-text {
            color: #003b5c;
        }

        .header-section {
            width: 100%;
            padding: 5px !important;
            margin: 0px;
        }

        .header-section .logotipo-container,
        .header-section .text-container,
        .header-section .options-container {
            display: flex;
        }

        .header-section .text-container>h3 {
            margin: auto;
        }

        .header-section .logotipo-container>img {
            height: 80px;
            width: auto;
            margin: auto;
            margin-left: 0px;
        }

        .header-section .options-container>.btn-group {
            margin: auto;
            margin-right: 0px;
        }

        .card-header,
        .card-title {
            text-transform: none !important;
        }

        .ql-editor {
            font-size: 0.95rem;
        }

        .ql-editor .ql-video {
            display: block;
            margin: auto;
            min-width: 80%;
            min-height: 400px;
            max-width: 100%;
        }
        .ql-tooltip.ql-hidden{
            display: none;
        }
    </style>

    @livewireStyles

</head>

<body>
    <div class="app-container app-theme-gray app-sidebar-full {{ Cookie::get('expandNavbar') == 'true' ? 'header-mobile-open' : '' }}" id="app-container">
        <div class="app-main">
            <div class="app-sidebar-wrapper">
                <div class="app-sidebar sidebar-text-light" style="background-color: #003b5c !important;">
                    <div class="app-header__logo d-flex justify-content-between" x-data="navbar()" x-init="mounted()">
                        <a href="{{ route('dashboard') }}" data-toggle="tooltip" data-placement="bottom" title="BUAP {{ env('APP_NAME', '') }}" class="">
                            <img src="{{ url('images/dashboard/others/logo.png?202205311022') }}" width="200px" class="img-responsive" alt="">
                        </a>
                        <button type="button" class="float-right hamburger hamburger--elastic mobile-toggle-nav" id="navbarButton" x-on:click="changeState()">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>

                        <script>
                            function navbar() {
                                return {
                                    errors: @json($errors->all()),
                                    expandNavbar: JSON.parse(localStorage.getItem('expandNavbar')) ? true : false,
                                    appContainer: document.getElementById('app-container'),
                                    navbarButton: document.getElementById('navbarButton'),
                    
                                    /**
                                     *
                                     *
                                     *
                                     */
                    
                                    mounted() {
                                        document.cookie = `expandNavbar=${this.expandNavbar}`;
                    
                                        if (this.errors.length > 0) {
                                            this.showErrors();
                                        }
                                    },
                    
                                    /**
                                     *
                                     *
                                     *
                                     */
                    
                                    changeState() {
                                        this.expandNavbar = !this.expandNavbar;
                                        localStorage.setItem('expandNavbar', this.expandNavbar);
                                        document.cookie = `expandNavbar=${this.expandNavbar}`;
                                    },
                    
                    
                                    showErrors() {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: this.errors[0],
                                        })
                                    },
                    
                                }
                            }
                        </script>
                    </div>
                    <div class="scrollbar-sidebar scrollbar-container">
                        <div class="app-sidebar__inner">
                            <ul class="vertical-nav-menu">
                                <li>
                                    <a href="https://asignatura.buap.mx/docentes/dashboard">
                                        <i class="metismenu-icon fas fa-home"></i>
                                        Inicio
                                    </a>
                                </li>
                                <li class="app-sidebar__heading">Prepara tu REA</li>
                                @can('index categories')
                                <li>
                                    <a href="{{ route('course.manage') }}">
                                        <i class="metismenu-icon fas fa-cogs"></i>
                                        </i>Administrador curso
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('course.board.home') }}">
                                        <i class="metismenu-icon fas fa-chart-line"></i>
                                        </i>Progreso del curso
                                    </a>
                                </li>
                                @endcan
                                <li>
                                    <!-- <a href="{{ route('reas.iframe') }}"> -->
                                    <a href="{{ route('course.panel.home') }}">
                                        <i class="metismenu-icon fas fa-book-open"></i>
                                        </i>1. Curso REA
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('xlearning.iframe')}}">
                                        <i class="metismenu-icon fas fa-layer-group">
                                        </i>Guía para el uso de eXe
                                    </a>
                                </li>
                                {{-- <li class="app-sidebar__heading">Evalúa tu REA</li> --}}
                                @can('index categories')
                                <li>
                                    <a href="{{ route('categories.index') }}">
                                        <i class="metismenu-icon fas fa-layer-group">
                                        </i>Categorías
                                    </a>
                                </li>
                                @endcan
                                @can('index subcategories')
                                <li>
                                    <a href="{{ route('subcategories.index') }}">
                                        <i class="metismenu-icon fas fa-cubes">
                                        </i>Subcategorías
                                    </a>
                                </li>
                                @endcan
                                @can('index users')
                                <li>
                                    <a href="{{ route('users.index') }}">
                                        <i class="metismenu-icon fas fa-users">
                                        </i>Usuarios
                                    </a>
                                </li>
                                @endcan
                                @can('index questions')
                                <li>
                                    <a href="{{ route('questions.index') }}">
                                        <i class="metismenu-icon fas fa-question-circle">
                                        </i>Preguntas
                                    </a>
                                </li>
                                @endcan
                                <li>
                                    <a href="{{ route('repositories.index') }}">
                                        <i class="metismenu-icon fas fa-box-open"></i>
                                        2. Evalúa tu REA
                                    </a>
                                </li>

                                @if ( auth()->user()->is_admin || auth()->user()->is_evaluator )
                                <li>
                                    <a href="{{ route('announcements.index') }}">
                                        <i class="metismenu-icon fas fa-calendar-check">
                                        </i>Convocatorias
                                    </a>
                                </li>
                                @endif
                                {{-- <li class="app-sidebar__heading">Publica tu REA</li> --}}
                                {{-- <li class="mt-5 text-center" style="border: 1px solid #c3c6d4 !important;">
                                    <a href="mailto:servicios@escire.net" target="_blank" title="Email de contacto: servicios@escire.net">
                                        ¿Necesitas ayuda?
                                    </a>
                                </li> --}}
                                {{-- <li class="mt-5 text-center" style="border: 1px solid #c3c6d4 !important;">
                                    <a href="https://dpyx.site/preguntas-frecuentes/" target="_blank">
                                        Más información y FAQ
                                    </a>
                                </li> --}}
                                {{-- @if (auth()->user()->is_admin)
                                <li class="mt-1 text-center" style="border: 1px solid #c3c6d4 !important;">
                                    <a href="https://dpyx.site/administrador/" target="_blank">
                                        Manual de administrador
                                    </a>
                                </li>
                                @elseif(auth()->user()->is_evaluator)
                                <li class="mt-1 text-center" style="border: 1px solid #c3c6d4 !important;">
                                    <a href="https://dpyx.site/evaluador/" target="_blank">
                                        Manual de evaluador
                                    </a>
                                </li>
                                @else
                                <li class="mt-1 text-center" style="border: 1px solid #c3c6d4 !important;">
                                    <a href="https://dpyx.site/usuario/" target="_blank">
                                        Manual de usuario
                                    </a>
                                </li>
                                @endif --}}
                                {{-- <li class="mt-5 text-center" style="border: 1px solid #c3c6d4 !important;">
                                    <a href="https://asignatura.buap.mx/" class="px-1">
                                        <small>asignaturas y planeaciones didacticas</small>
                                    </a>
                                </li> --}}
                                <li class="app-sidebar__heading" style="opacity: 0">a</li>
                                <li class="app-sidebar__heading" style="opacity: 0">a</li>
                                <li class="app-sidebar__heading" style="opacity: 0">a</li>
                                <li class="app-sidebar__heading" style="opacity: 0">a</li>
                                <li class="app-sidebar__heading" style="opacity: 0">a</li>
                                <li class="app-sidebar__heading" style="opacity: 0">a</li>
                                <li class="app-sidebar__heading" style="opacity: 0">a</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-sidebar-overlay d-none animated fadeIn"></div>

            <div class="container app-main__outer">
                <div class="container app-main__inner">
                    <div class="header-mobile-wrapper" style="background-color: #e1e6ff;">
                        <div class="app-header__logo">
                            <img src="{{ url('images/dashboard/others/logo.png?20220531') }}" width="120px" class="img-responsive" alt="">
                            <button type="button" class="hamburger hamburger--elastic mobile-toggle-sidebar-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                            <div class="app-header__menu">
                                <span>
                                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav" style="background: #b6bad2; border: 1px solid #9da4ca;">
                                        <span class="btn-icon-wrapper">
                                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                                        </span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row header-section bg-white">
                        <div class="col-6 col-md-2 logotipo-container">
                            <img src="{{ asset('/images/dashboard/others/dashboard-logo.png') }}" alt="">
                        </div>
                        <div class="col-md-8 d-none d-md-block text-container">
                            <h3 class="text-center blue-text">
                                Bienvenida/o a los Recursos Educativos Abiertos (REA) del Ecosistema de Aprendizaje Abierto
                            </h3>
                        </div>
                        <div class="col-6 col-md-2 options-container">
                            <div class="btn-group float-right">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-1 btn">

                                    <img width="50" class="rounded" src="{{ auth()->user()->profile_photo_path ? asset('storage/' . auth()->user()->profile_photo_path) : asset('/images/default/avatars/profile.jpg') }}" alt="" style="display: inline-block;">
                                    <i class="ml-2 fa fa-angle-down opacity-8"></i>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-menu-header">
                                        <div class="dropdown-menu-header-inner bg-info">
                                            {{-- <div class="menu-header-image opacity-2" style="background-image: url('/images/dropdown-header/city1.jpg');">
                                            </div> --}}
                                            <div class="text-left menu-header-content">
                                                <div class="p-0 widget-content">
                                                    <div class="widget-content-wrapper">
                                                        <div class="mr-3 widget-content-left">
                                                            <img width="80" class="rounded-circle" src="{{ auth()->user()->profile_photo_path ? asset('storage/' . auth()->user()->profile_photo_path) : asset('/images/default/avatars/profile.jpg') }}" alt="">
                                                        </div>
                                                        <div class="widget-content-left">
                                                            <div class="widget-heading">
                                                                {{ auth()->user()->name }}
                                                            </div>
                                                        </div>
                                                        <div class="mr-2 widget-content-right">
                                                            <form method="POST" action="{{ route('logout') }}">
                                                                @csrf
                                                                <button class="btn-pill btn-shadow btn-shine btn btn-focus">Cerrar
                                                                    sesión
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="scroll-area-xs" style="height: 150px;">
                                        <div class="scrollbar-container ps">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link float"><span class="text-muted">
                                                            <i class="fas fa-envelope"></i>
                                                            {{ auth()->user()->email }}
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="nav-item-header nav-item">Mi cuenta
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route('users.account.edit') }}" class="nav-link">
                                                        <i class="mr-1 fas fa-tools"></i>
                                                        Configuración
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-md-none text-container">
                            <h5 class="text-center blue-text">
                                {{-- @yield('header') --}}
                                Bienvenida/o a los Recursos Educativos Abiertos (REA) en el marco de la Ciencia Abierta
                            </h5>
                        </div>
                    </div>
                    @if(!str_contains(Request::url(),'dashboard') && !str_contains(Request::url(),'course/panel'))
                    <div class="bg-white shadow-sm app-header">
                        @yield('header')
                        <div class="app-header-overlay d-none animated fadeIn"></div>
                    </div>
                    @endif
                    <div class="app-inner-layout app-inner-layout-page">
                        <div class="app-inner-layout__wrapper">
                            <div class="container app-inner-layout__content">
                                <div class="tab-content">
                                    <div class="container">
                                        {{ $slot }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Footer -->
                <div class="app-wrapper-footer mb-5">
                    <div class="app-footer">
                        <div class="">
                            <div class="app-footer__inner">
                                <div class="app-footer-left">
                                    <img src="{{ asset('images/default/footer-left.png') }}" width="100px">
                                </div>
                                <div class="app-footer-right">
                                    <span class="text-muted">Consultoría Tecnologías y Gestión del Conocimiento S.A. de C.V.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
    <script type="text/javascript" src="{{ asset('js/app.js?2022-07-08-13-28') }}"></script>

    

    @include('sweetalert::alert')

    @stack('modals')
    @stack('scripts')

    <script type="text/javascript">
        (function(global){
        global.$_Tawk_AccountKey='6193e7d26885f60a50bc1574';
        global.$_Tawk_WidgetId='1fkks33nr';
        global.$_Tawk_Unstable=false;
        global.$_Tawk = global.$_Tawk || {};
        (function (w){
            function l() {
                if (window.$_Tawk.init !== undefined) {
                    return;
                }

                window.$_Tawk.init = true;

                var files = [
                    'https://embed.tawk.to/_s/v4/app/62835fee0eb/js/twk-main.js',
                    'https://embed.tawk.to/_s/v4/app/62835fee0eb/js/twk-vendor.js',
                    'https://embed.tawk.to/_s/v4/app/62835fee0eb/js/twk-chunk-vendors.js',
                    'https://embed.tawk.to/_s/v4/app/62835fee0eb/js/twk-chunk-common.js',
                    'https://embed.tawk.to/_s/v4/app/62835fee0eb/js/twk-runtime.js',
                    'https://embed.tawk.to/_s/v4/app/62835fee0eb/js/twk-app.js'
                ];

                if (typeof Promise === 'undefined') {
                    files.unshift('https://embed.tawk.to/_s/v4/app/62835fee0eb/js/twk-promise-polyfill.js');
                }

                if (typeof Symbol === 'undefined' || typeof Symbol.iterator === 'undefined') {
                    files.unshift('https://embed.tawk.to/_s/v4/app/62835fee0eb/js/twk-iterator-polyfill.js');
                }

                if (typeof Object.entries === 'undefined') {
                    files.unshift('https://embed.tawk.to/_s/v4/app/62835fee0eb/js/twk-entries-polyfill.js');
                }

                if (!window.crypto) {
                    window.crypto = window.msCrypto;
                }

                if (typeof Event !== 'function') {
                    files.unshift('https://embed.tawk.to/_s/v4/app/62835fee0eb/js/twk-event-polyfill.js');
                }

                if (!Object.values) {
                    files.unshift('https://embed.tawk.to/_s/v4/app/62835fee0eb/js/twk-object-values-polyfill.js');
                }

                if (typeof Array.prototype.find === 'undefined') {
                    files.unshift('https://embed.tawk.to/_s/v4/app/62835fee0eb/js/twk-arr-find-polyfill.js');
                }

                var s0=document.getElementsByTagName('script')[0];

                for (var i = 0; i < files.length; i++) {
                    var s1 = document.createElement('script');
                    s1.src= files[i];
                    s1.charset='UTF-8';
                    s1.setAttribute('crossorigin','*');
                    s0.parentNode.insertBefore(s1,s0);
                }
            }
            if (document.readyState === 'complete') {
                l();
            } else if (w.attachEvent) {
                w.attachEvent('onload', l);
            } else {
                w.addEventListener('load', l, false);
            }
        })(window);

        })(window);
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="{{ asset('vendor/OwlCarousel/owl.carousel.js') }}"></script>
</body>

</html>
