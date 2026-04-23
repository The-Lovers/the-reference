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
    <a class="nav-link text-white" href="{{ route('public.contact.create', ['locale' => app()->getLocale()]) }}">
        {{ __('index.nav.contact') }}
    </a>
</li>

<li class="nav-item">
    <a class="nav-link text-white" href="#">
        {{ __('index.nav.about') }}
    </a>
</li>
<li class="nav-item">
    @include('partials.language-dropdown', [
        'wrapperClass' => 'dropdown',
        'toggleClass' => 'nav-link dropdown-toggle text-white d-flex align-items-center justify-content-end p-0 border-0 bg-transparent',
        'menuClass' => 'dropdown-menu dropdown-menu-end',
        'itemClass' => 'dropdown-item d-flex align-items-center gap-2',
    ])
</li>
