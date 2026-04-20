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
    <div id="globalPageLoader" class="global-page-loader is-visible" aria-live="polite" aria-busy="true">
        <div class="global-page-loader__box">
            <span class="global-page-loader__spinner"></span>
            <span class="global-page-loader__text">Chargement...</span>
        </div>
    </div>
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

            window.showPageLoader = function () {
                document.getElementById('globalPageLoader')?.classList.add('is-visible');
            };

            window.hidePageLoader = function () {
                document.getElementById('globalPageLoader')?.classList.remove('is-visible');
            };
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

        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(() => window.hidePageLoader?.(), 350);

            document.querySelectorAll('a[href]').forEach((link) => {
                link.addEventListener('click', function () {
                    const href = this.getAttribute('href');

                    if (!href || href.startsWith('#') || this.target === '_blank' || this.hasAttribute('download')) {
                        return;
                    }

                    if (href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) {
                        return;
                    }

                    window.showPageLoader?.();
                });
            });

            document.querySelectorAll('form').forEach((form) => {
                form.addEventListener('submit', function () {
                    window.showPageLoader?.();
                });
            });
        });
    </script>
    <style>
        .global-page-loader {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, .82);
            backdrop-filter: blur(8px);
            opacity: 0;
            visibility: hidden;
            transition: opacity .25s ease, visibility .25s ease;
        }
        .global-page-loader.is-visible {
            opacity: 1;
            visibility: visible;
        }
        .global-page-loader__box {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .9rem;
            padding: 1.5rem 1.8rem;
            border-radius: 24px;
            background: linear-gradient(145deg, #ffffff, #f5f7fb);
            box-shadow: 0 20px 50px rgba(11, 60, 93, .16);
        }
        .global-page-loader__spinner {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            border: 4px solid rgba(11, 60, 93, .14);
            border-top-color: #0b3c5d;
            animation: globalPageLoaderSpin .8s linear infinite;
        }
        .global-page-loader__text {
            font-weight: 700;
            color: #0b3c5d;
            letter-spacing: .02em;
        }
        @keyframes globalPageLoaderSpin {
            to { transform: rotate(360deg); }
        }
    </style>
    @yield('js')
</body>
</html>
