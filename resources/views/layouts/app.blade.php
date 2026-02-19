<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="keyword" content="" />
    <meta name="author" content="Jango" />
    <title>@yield('title', 'La Référence')</title>
    <link rel="stylesheet" href="{{ asset('lib/bootstrap-5.3.8/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/font-awesome-6.5.0/css/all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/swiper-12.1.0/package/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    @yield('favicon')
    @yield('css')
</head>
<body>
    <main>
        @yield('header')
        @yield('content')
        @yield('footer')
    </main>

    <script src="{{ asset('lib/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('lib/tilt/tilt.jquery.min.js') }}"></script>
    <script src="{{ asset('lib/select2/select2.min.js') }}"></script>
    <script src="{{ asset('lib/font-awesome-6.5.0/js/all.js') }}"></script>
    <script src="{{ asset('lib/bootstrap-5.3.8/dist/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('lib/swiper-12.1.0/package/swiper-bundle.min.js') }}"></script>
    <script>
        function openBox(){ document.getElementById('lightbox').style.display='flex'; }
        function closeBox(){ document.getElementById('lightbox').style.display='none'; }
    </script>
    @yield('js')
</body>
</html>
