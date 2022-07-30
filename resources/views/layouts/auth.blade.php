<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>dPyx BUAP</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="dPyx">
    <meta name="msapplication-tap-highlight" content="no">

    <script src="{{ asset('/js/manifest.js') }}"></script>
    <script src="{{ asset('/js/vendor.js') }}" defer></script>
    <script src="{{ asset('/js/jquery.js') }}"></script>
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->

    <link href="{{asset('/css/aos.css')}}" rel="stylesheet">
    <script src="{{asset('/js/aos.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kero.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @livewireStyles
</head>

<body class="blue-background">
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-{{ str_contains(URL::current(),'login') ? '10' : '7'}} col-lg-12 col-md-9">
                    <div class="card o-hidden-border-0 shadow-lg my-5" data-aos="zoom-in-up" data-aos-duration="500">
                        @if (isset($slot))
                            {{$slot}}
                        @else
                            @yield('content')
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </main>
    
    <script>
        window.onload = function() {
            AOS.init()
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    @include('sweetalert::alert')
    @livewireScripts
    @stack('script')

</body>

</html>
