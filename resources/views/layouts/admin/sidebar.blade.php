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
                            <a class="nxl-link" href="#">
                                <i class="fa-solid fa-list"></i>
                                {{ __('dashboard.sidebar.user.list') }}
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="{{ route('register') }}">
                                <i class="fa-solid fa-plus"></i>
                                {{ __('dashboard.sidebar.user.new') }}
                            </a>
                        </li>
                        <li class="nxl-item">
                            <a class="nxl-link" href="#">
                                <i class="fa-solid fa-lock"></i>
                                {{ __('dashboard.sidebar.user.role') }}
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="fa-solid fa-tasks"></i></span>
                        <span class="nxl-mtext">{{ __('dashboard.sidebar.missions') }}</span>
                        <span class="nxl-arrow"><i class="fa-solid fa-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a class="nxl-link" href="apps-chat.html">Chat</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="apps-email.html">Email</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="apps-tasks.html">Tasks</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="apps-notes.html">Notes</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="apps-storage.html">Storage</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="apps-calendar.html">Calendar</a></li>
                    </ul>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="fa-solid fa-server"></i></span>
                        <span class="nxl-mtext">{{ __('dashboard.sidebar.domains') }}</span>
                        <span class="nxl-arrow"><i class="fa-solid fa-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a class="nxl-link" href="proposal.html">Proposal</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="proposal-view.html">Proposal View</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="proposal-edit.html">Proposal Edit</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="proposal-create.html">Proposal Create</a></li>
                    </ul>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="fa-solid fa-business-time"></i></span>
                        <span class="nxl-mtext">{{ __('dashboard.sidebar.services') }}</span>
                        <span class="nxl-arrow"><i class="fa-solid fa-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item"><a class="nxl-link" href="payment.html">Payment</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="invoice-view.html">Invoice View</a></li>
                        <li class="nxl-item"><a class="nxl-link" href="invoice-create.html">Invoice Create</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
