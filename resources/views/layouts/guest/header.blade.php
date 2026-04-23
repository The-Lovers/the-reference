<header style="--guest-header-bg: url('{{ sec_asset('images/background.jpeg') }}');">
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent position-absolute w-100">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('index') }}">
                <img src="{{ sec_asset('images/logo.png') }}" class="img-fluid" style="height:40px; width:auto;" alt="Logo">

                <!-- Caché en mobile -->
                <span class="title d-none d-lg-inline ms-2 text-white">
                    {{ __('index.title') }}
                </span>
            </a>

            <!-- Hamburger blanc -->
            <button class="navbar-toggler border-0 ms-auto"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#mobileMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Desktop -->
            <div class="collapse navbar-collapse justify-content-end d-none d-lg-flex">
                <ul class="navbar-nav align-items-center">
                    @include('partials.nav-links')
                </ul>
            </div>

        </div>
    </nav>
    <div class="offcanvas offcanvas-end text-bg-dark mobile-menu" tabindex="-1" id="mobileMenu">

        <div class="offcanvas-header">
            <h5 class="offcanvas-title text-white">
                {{ __('index.title') }}
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body d-flex flex-column text-end">

            <ul class="navbar-nav ms-auto align-items-end">
                @include('partials.nav-links')
            </ul>

        </div>
    </div>
    <div class="container-fluid header-content">
        <h1 class="first">{{ mb_strtoupper(__('index.title'), 'UTF-8') }}</h1>
        <p><strong>{{ __('index.slogan') }}</strong><br>
            {{ __('index.description') }}
        </p>
        <a href="{{ route('public.contact.create', ['locale' => app()->getLocale()]) }}" class="btn">
            {{ __('index.contain.btn') }}
        </a>
    </div>
</header>
<style>
    header {
        background:
            linear-gradient(rgba(11,60,93,.75), rgba(11,60,93,.75)),
            var(--guest-header-bg) center / cover no-repeat;
    }

    .navbar-toggler {
        border-color: rgba(255,255,255,0.5);
    }

    .navbar-toggler-icon {
        filter: invert(1);
    }
    .mobile-menu {
        width: 280px; /* largeur fixe propre */
        max-width: 85%;
    }

    .offcanvas-body {
        padding-right: 2rem;
    }
</style>
