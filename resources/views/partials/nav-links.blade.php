<li class="nav-item">
    <a class="nav-link text-white" href="{{ route('index') }}">
        {{ __('index.nav.home') }}
    </a>
</li>

@guest
<li class="nav-item">
    <a class="nav-link text-white" href="{{ route('login') }}">
        {{ __('index.nav.login') }}
    </a>
</li>
@else
<li class="nav-item">
    <a class="nav-link text-white" href="{{ route('dashboard') }}">
        {{ __('index.nav.dashboard') }}
    </a>
</li>
@endguest

<li class="nav-item">
    <a class="nav-link text-white" href="#">
        {{ __('index.nav.contact') }}
    </a>
</li>

<li class="nav-item">
    <a class="nav-link text-white" href="#">
        {{ __('index.nav.about') }}
    </a>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-white d-flex align-items-center justify-content-end"
       href="#"
       role="button"
       data-bs-toggle="dropdown">

        @if(app()->getLocale() === 'fr')
            <img src="{{ sec_asset('images/fr.png') }}" width="20" class="me-2">
        @else
            <img src="{{ sec_asset('images/us.png') }}" width="20" class="me-2">
        @endif
    </a>

    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <a class="dropdown-item"
               href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'fr'])) }}">
                🇫🇷
            </a>
        </li>
        <li>
            <a class="dropdown-item"
               href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'en'])) }}">
                🇺🇸
            </a>
        </li>
    </ul>
</li>
