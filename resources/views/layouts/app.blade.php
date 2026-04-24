<!DOCTYPE html>
@php
    $siteName = __('index.title');
    $defaultDescription = __('index.description');
    $defaultKeywords = __('index.seo.defaults.keywords');
    $route = request()->route();
    $routeName = $route?->getName();
    $normalizeRouteParameters = function (array $parameters): array {
        return collect($parameters)
            ->except('locale')
            ->map(function ($value) {
                if ($value instanceof \Illuminate\Contracts\Routing\UrlRoutable) {
                    return $value->getRouteKey();
                }

                if ($value instanceof \BackedEnum) {
                    return $value->value;
                }

                if ($value instanceof \UnitEnum) {
                    return $value->name;
                }

                if (is_array($value)) {
                    return collect($value)
                        ->flatten()
                        ->first(fn ($item) => is_scalar($item) || $item instanceof \Stringable);
                }

                return $value;
            })
            ->filter(fn ($value) => !is_null($value) && !is_array($value))
            ->toArray();
    };
    $routeParameters = $route ? $normalizeRouteParameters($route->parameters()) : [];
    $canonicalUrl = trim($__env->yieldContent('meta_canonical')) ?: url()->current();
    $seoTitle = trim($__env->yieldContent('meta_title', $__env->yieldContent('title', $siteName)));
    $seoDescription = trim(strip_tags($__env->yieldContent('meta_description', $defaultDescription)));
    $seoKeywords = trim(strip_tags($__env->yieldContent('meta_keywords', $defaultKeywords)));
    $seoImage = trim($__env->yieldContent('meta_image', sec_asset('images/logo.png')));
    $seoRobots = trim($__env->yieldContent('meta_robots', 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1'));
    $seoType = trim($__env->yieldContent('meta_type', __('index.seo.defaults.og_type')));
    $currentLocale = app()->getLocale();
    $ogLocale = $currentLocale === 'fr' ? 'fr_FR' : 'en_US';
    $alternateLocales = collect(['fr', 'en'])->map(function ($locale) use ($routeName, $routeParameters) {
        if (!$routeName) {
            return null;
        }

        return [
            'locale' => $locale,
            'href' => rescue(
                fn () => route($routeName, array_merge($routeParameters, ['locale' => $locale])),
                url()->current(),
                report: false
            ),
        ];
    })->filter()->values();
    $structuredData = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => __('index.seo.schema.type'),
                '@id' => rtrim(config('app.url'), '/') . '#organization',
                'name' => $siteName,
                'url' => rtrim(config('app.url'), '/'),
                'logo' => sec_asset('images/logo.png'),
                'description' => __('index.seo.schema.description'),
                'telephone' => '+237653476952',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Yaounde',
                    'addressCountry' => 'CM',
                    'streetAddress' => __('index.contain.contact-card.address-value'),
                ],
            ],
            [
                '@type' => 'WebSite',
                '@id' => rtrim(config('app.url'), '/') . '#website',
                'name' => $siteName,
                'url' => rtrim(config('app.url'), '/'),
                'inLanguage' => ['fr', 'en'],
            ],
            [
                '@type' => 'WebPage',
                'name' => $seoTitle,
                'description' => $seoDescription,
                'url' => $canonicalUrl,
                'inLanguage' => $currentLocale,
                'isPartOf' => [
                    '@id' => rtrim(config('app.url'), '/') . '#website',
                ],
            ],
        ],
    ];
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="{{ $seoDescription }}" />
    <meta name="keywords" content="{{ $seoKeywords }}" />
    <meta name="author" content="Jango" />
    <meta name="robots" content="{{ $seoRobots }}" />
    <meta name="theme-color" content="#0b3c5d" />
    <link rel="canonical" href="{{ $canonicalUrl }}">
    @foreach ($alternateLocales as $alternateLocale)
        <link rel="alternate" hreflang="{{ $alternateLocale['locale'] }}" href="{{ $alternateLocale['href'] }}">
    @endforeach
    @if ($routeName)
        <link rel="alternate" hreflang="x-default" href="{{ rescue(fn () => route($routeName, array_merge($routeParameters, ['locale' => 'fr'])), url()->current(), report: false) }}">
    @endif
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:type" content="{{ $seoType }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:locale" content="{{ $ogLocale }}">
    @foreach ($alternateLocales->where('locale', '!=', $currentLocale) as $alternateLocale)
        <meta property="og:locale:alternate" content="{{ $alternateLocale['locale'] === 'fr' ? 'fr_FR' : 'en_US' }}">
    @endforeach
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">
    <title>{{ $seoTitle }}</title>
    <link rel="stylesheet" href="{{ sec_asset('lib/bootstrap-5.3.8/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ sec_asset('lib/font-awesome-6.5.0/css/all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ sec_asset('lib/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ sec_asset('lib/swiper-12.1.0/package/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{ sec_asset('css/style.css') }}">
    <link rel="shortcut icon" href="{{ sec_asset('images/logo.png') }}" type="image/x-icon">
    <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
    @yield('structured_data')
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
