<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="navbrand">
            <a class="navbar-brand" href="{{ route('index') }}">
                <img src="{{ asset('storage/app/public/logo/logo.png') }}" alt="Logo" class="d-inline-block align-text-top img-fluid">
                <span class="title">{{ __('index.title') }}</span>
            </a>
        </div>
        <div class="navlinks">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('index') }}">{{ __('index.nav.home') }}</a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('index.nav.login') }}</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">{{ __('index.nav.dashboard') }}</a>
                    </li>
                @endguest
                <li class="nav-item">
                    <a class="nav-link" href="#">{{ __('index.nav.contact') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">{{ __('index.nav.about') }}</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center lang" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(app()->getLocale() === 'fr')
                            <img src="{{ asset('images/fr.png') }}" class="me-1" alt="Fr">
                        @else
                            <img src="{{ asset('images/us.png') }}" class="me-1" alt="En">
                        @endif
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end lang-content">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'fr'])) }}">
                                <img src="{{ asset('images/flags/fr.svg') }}" class="me-2">
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'en'])) }}">
                                <img src="{{ asset('images/flags/us.svg') }}" class="me-2">
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid header-content">
        <h1 class="first">{{ mb_strtoupper(__('index.title'), 'UTF-8') }}</h1>
        <p><strong>{{ __('index.slogan') }}</strong><br>
            {{ __('index.description') }}
        </p>
        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
            {{ __('index.contain.btn') }}
        </button>
    </div>
</header>
