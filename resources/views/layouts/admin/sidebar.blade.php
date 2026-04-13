<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('index') }}" class="b-brand">
                <span class="title">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo logo-lg log"/>
                    {{ __('index.title') }}
                </span>
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo logo-sm" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="nxl-navbar">
                <li class="nxl-item nxl-caption">
                    <a href="{{ route('dashboard') }}">
                        <span class="nxl-mtext">
                            {{ __('dashboard.sidebar.dashboard') }}
                        </span>
                    </a>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="fa-solid fa-airplay"></i></span>
                        <span class="nxl-mtext">{{ __('dashboard.sidebar.dashboard') }}</span>
                        <span class="nxl-arrow"><i class="fa-solid fa-chevron-right"></i></span>
                    </a>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="fa-solid fa-users"></i></span>
                        <span class="nxl-mtext">{{ __('dashboard.sidebar.users') }}</span>
                        <span class="nxl-arrow"><i class="fa-solid fa-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('users.index') }}">
                                <i class="fa-solid fa-list"></i>
                                {{ __('dashboard.sidebar.user.list') }}
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('users.create') }}">
                                <i class="fa-solid fa-plus"></i>
                                {{ __('dashboard.sidebar.user.new') }}
                            </a>
                        </li>
                        {{-- <li class="nxl-item">
                            <a class="nxl-link" href="#">
                                <i class="fa-solid fa-lock"></i>
                                {{ __('dashboard.sidebar.user.role') }}
                            </a>
                        </li> --}}
                    </ul>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="fa-solid fa-tasks"></i></span>
                        <span class="nxl-mtext">{{ __('dashboard.sidebar.missions') }}</span>
                        <span class="nxl-arrow"><i class="fa-solid fa-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('missions.index') }}">
                                <i class="fa-solid fa-list"></i>
                                {{ __('dashboard.sidebar.mission.list') }}
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('missions.create') }}">
                                <i class="fa-solid fa-plus"></i>
                                {{ __('dashboard.sidebar.mission.new') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="fa-solid fa-server"></i></span>
                        <span class="nxl-mtext">{{ __('dashboard.sidebar.domains') }}</span>
                        <span class="nxl-arrow"><i class="fa-solid fa-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('domains.index') }}">
                                <i class="fa-solid fa-list"></i>
                                {{ __('dashboard.sidebar.domain.list') }}
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('domains.create') }}">
                                <i class="fa-solid fa-plus"></i>
                                {{ __('dashboard.sidebar.domain.new') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="fa-solid fa-business-time"></i></span>
                        <span class="nxl-mtext">{{ __('dashboard.sidebar.services') }}</span>
                        <span class="nxl-arrow"><i class="fa-solid fa-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('services.index') }}">
                                <i class="fa-solid fa-list"></i>
                                {{ __('dashboard.sidebar.service.list') }}
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('services.create') }}">
                                <i class="fa-solid fa-plus"></i>
                                {{ __('dashboard.sidebar.service.new') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="fa-solid fa-business-time"></i></span>
                        <span class="nxl-mtext">{{ __('dashboard.sidebar.testimonies') }}</span>
                        <span class="nxl-arrow"><i class="fa-solid fa-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('services.index') }}">
                                <i class="fa-solid fa-list"></i>
                                {{ __('dashboard.sidebar.testimony.list') }}
                            </a>
                        </li>
                    </ul>
                </li>
                 <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="fa-solid fa-location-dot"></i></span>
                        <span class="nxl-mtext">{{ __('dashboard.sidebar.destinations') }}</span>
                        <span class="nxl-arrow"><i class="fa-solid fa-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('destinations.index') }}">
                                <i class="fa-solid fa-list"></i>
                                {{ __('dashboard.sidebar.destination.list') }}
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('destinations.create') }}">
                                <i class="fa-solid fa-plus"></i>
                                {{ __('dashboard.sidebar.destination.new') }}
                            </a>
                        </li>
                    </ul>
            </ul>
        </div>
    </div>
</nav>
