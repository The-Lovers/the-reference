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
    <link rel="stylesheet" href="{{ sec_asset('lib/bootstrap-5.3.8/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ sec_asset('lib/font-awesome-6.5.0/css/all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ sec_asset('lib/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ sec_asset('lib/swiper-12.1.0/package/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{ sec_asset('css/style.css') }}">
    <link rel="shortcut icon" href="{{ sec_asset('images/logo.png') }}" type="image/x-icon">
    @yield('favicon')
    @yield('css')
</head>
<body>
    <main>
        @yield('header')
        <x-popUp.popup />
        {{-- Flash messages global --}}
        @php
            $flashTypes = ['success','error','warning','info'];
        @endphp

        @if(collect($flashTypes)->contains(fn($type) => session()->has($type)))
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            @foreach($flashTypes as $type)
                @if(session($type))
                    showPopup('{{ $type }}', @json(session($type)));
                @endif
            @endforeach
        });
        </script>
        @endif

        @yield('content')
        @yield('footer')

        <script>
            function confirmDelete(id, message) {
                if (typeof showPopup === 'function') {
                    showPopup('confirm', message, {
                        theme: 'dark',
                        onConfirm: function () {
                            document.getElementById('deleteForm-' + id).submit();
                        }
                    });
                } else if (confirm(message)) {
                    document.getElementById('deleteForm-' + id).submit();
                }
            }

            function confirmToggle(formId, message) {
                if (typeof showPopup === 'function') {
                    showPopup('confirm', message, {
                        theme: 'dark',
                        onConfirm: function () {
                            document.getElementById(formId).submit();
                        }
                    });
                } else if (confirm(message)) {
                    document.getElementById(formId).submit();
                }
            }
        </script>

    </main>

    <script src="{{ sec_asset('lib/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ sec_asset('lib/tilt/tilt.jquery.min.js') }}"></script>
    <script src="{{ sec_asset('lib/select2/select2.min.js') }}"></script>
    <script src="{{ sec_asset('lib/font-awesome-6.5.0/js/all.js') }}"></script>
    <script src="{{ sec_asset('lib/bootstrap-5.3.8/dist/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ sec_asset('lib/swiper-12.1.0/package/swiper-bundle.min.js') }}"></script>
    <script>
        function openBox(){ document.getElementById('lightbox').style.display='flex'; }
        function closeBox(){ document.getElementById('lightbox').style.display='none'; }
    </script>
    @yield('js')
</body>
</html>
