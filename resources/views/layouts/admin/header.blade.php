<header class="nxl-header">
    <div class="header-wrapper">
        <!--! [Start] Header Left !-->
        <div class="header-left d-flex align-items-center gap-4">
            <!--! [Start] nxl-head-mobile-toggler !-->
            <a href="javascript:void(0);" class="nxl-head-mobile-toggler" id="mobile-collapse">
                <div class="hamburger hamburger--arrowturn">
                    <div class="hamburger-box">
                        <div class="hamburger-inner"></div>
                    </div>
                </div>
            </a>
            <!--! [Start] nxl-head-mobile-toggler !-->
            <!--! [Start] nxl-navigation-toggle !-->
            <div class="nxl-navigation-toggle">
                <a href="javascript:void(0);" id="menu-mini-button">
                    <i class="fa-solid fa-align-left"></i>
                </a>
                <a href="javascript:void(0);" id="menu-expend-button" style="display: none">
                    <i class="fa-solid fa-align-right"></i>
                </a>
            </div>
            <!--! [End] nxl-navigation-toggle !-->
        </div>
        <!--! [End] Header Left !-->
        <!--! [Start] Header Right !-->
        <div class="header-right ms-auto">
            <div class="d-flex align-items-center">
                <div class="dropdown nxl-h-item nxl-header-search">
                    <a href="javascript:void(0);" class="nxl-head-link me-0" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-search-dropdown">
                        <div class="input-group search-form">
                            <span class="input-group-text">
                                <i class="fa-solid fa-magnifying-glass fs-6 text-muted"></i>
                            </span>
                            <input type="text" class="form-control search-input-field" placeholder="Search...." />
                            <span class="input-group-text">
                                <button type="button" class="btn-close"></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="dropdown nxl-h-item nxl-header-language d-none d-sm-flex">
                    <a href="javascript:void(0);" class="nxl-head-link me-0 nxl-language-link" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                        @if(app()->getLocale() === 'fr')
                            <a class="dropdown-item d-flex align-items-center" href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'fr'])) }}">
                                <img src="{{ asset('images/flags/fr.svg') }}" class="me-1" alt="Fr">
                            </a>
                        @else
                            <a class="dropdown-item d-flex align-items-center" href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'en'])) }}">
                                <img src="{{ asset('images/flags/us.svg') }}" class="me-1" alt="En">
                            </a>
                        @endif
                        @php
                            $active = 'active';
                        @endphp
                    </a>
                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-language-dropdown">
                        <div class="language-items-wrapper">
                            <div class="row px-4 pt-3">
                                <div class="col-sm-4 col-6 language_select @if(app()->getLocale() === 'fr') {{ $active }} @endif">
                                    <a href="javascript:void(0);" class="d-flex align-items-center gap-2">
                                        <div class="avatar-image avatar-sm"><img src="{{ asset('images/fr.png') }}" alt="" class="img-fluid" /></div>
                                        <span>{{ __('dashboard.header.fr') }}</span>
                                    </a>
                                </div>
                                <div class="col-sm-4 col-6 language_select @if(app()->getLocale() === 'en') {{ $active }} @endif">
                                    <a href="javascript:void(0);" class="d-flex align-items-center gap-2">
                                        <div class="avatar-image avatar-sm"><img src="{{ asset('images/us.png') }}" alt="" class="img-fluid" /></div>
                                        <span>{{ __('dashboard.header.en') }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nxl-h-item dark-light-theme">
                    <a href="javascript:void(0);" class="nxl-head-link me-0 dark-button">
                        <i class="fa-solid fa-moon"></i>
                    </a>
                    <a href="javascript:void(0);" class="nxl-head-link me-0 light-button" style="display: none">
                        <i class="fa-solid fa-sun"></i>
                    </a>
                </div>
                <div class="dropdown nxl-h-item">
                    <a href="javascript:void(0);" class="nxl-head-link me-0" data-bs-toggle="dropdown" role="button" data-bs-auto-close="outside">
                        <i class="fa-regular fa-clock"></i>
                        <span class="badge bg-success nxl-h-badge">2</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-timesheets-menu">
                        <div class="d-flex justify-content-between align-items-center timesheets-head">
                            <h6 class="fw-bold text-dark mb-0">Timesheets</h6>
                            <a href="javascript:void(0);" class="fs-11 text-success text-end ms-auto" data-bs-toggle="tooltip" title="Upcomming Timers">
                                <i class="fa-regular fa-clock"></i>
                                <span>3 Upcomming</span>
                            </a>
                        </div>
                        <div class="d-flex justify-content-between align-items-center flex-column timesheets-body">
                            <i class="fa-solid fa-clock fs-1 mb-4"></i>
                            <p class="text-muted">No started timers found yes!</p>
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary">Started Timer</a>
                        </div>
                        <div class="text-center timesheets-footer">
                            <a href="javascript:void(0);" class="fs-13 fw-semibold text-dark">Alls Timesheets</a>
                        </div>
                    </div>
                </div>
                <div class="dropdown nxl-h-item">
                    <a class="nxl-head-link me-3" data-bs-toggle="dropdown" href="#" role="button" data-bs-auto-close="outside">
                        <i class="fa-regular fa-bell"></i>
                        <span class="badge bg-danger nxl-h-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-notifications-menu">
                        <div class="d-flex justify-content-between align-items-center notifications-head">
                            <h6 class="fw-bold text-dark mb-0">Notifications</h6>
                            <a href="javascript:void(0);" class="fs-11 text-success text-end ms-auto" data-bs-toggle="tooltip" title="Make as Read">
                                <i class="fa-solid fa-check"></i>
                                <span>Make as Read</span>
                            </a>
                        </div>
                        <div class="notifications-item">
                            <img src="assets/images/avatar/2.png" alt="" class="rounded me-3 border" />
                            <div class="notifications-desc">
                                <a href="javascript:void(0);" class="font-body text-truncate-2-line"> <span class="fw-semibold text-dark">Malanie Hanvey</span> We should talk about that at lunch!</a>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="notifications-date text-muted border-bottom border-bottom-dashed">2 minutes ago</div>
                                    <div class="d-flex align-items-center float-end gap-2">
                                        <a href="javascript:void(0);" class="d-block wd-8 ht-8 rounded-circle bg-gray-300" data-bs-toggle="tooltip" title="Make as Read"></a>
                                        <a href="javascript:void(0);" class="text-danger" data-bs-toggle="tooltip" title="Remove">
                                            <i class="fa-solid fa-x fs-12"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="notifications-item">
                            <img src="assets/images/avatar/3.png" alt="" class="rounded me-3 border" />
                            <div class="notifications-desc">
                                <a href="javascript:void(0);" class="font-body text-truncate-2-line"> <span class="fw-semibold text-dark">Valentine Maton</span> You can download the latest invoices now.</a>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="notifications-date text-muted border-bottom border-bottom-dashed">36 minutes ago</div>
                                    <div class="d-flex align-items-center float-end gap-2">
                                        <a href="javascript:void(0);" class="d-block wd-8 ht-8 rounded-circle bg-gray-300" data-bs-toggle="tooltip" title="Make as Read"></a>
                                        <a href="javascript:void(0);" class="text-danger" data-bs-toggle="tooltip" title="Remove">
                                            <i class="fa-solid fa-x fs-12"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="notifications-item">
                            <img src="assets/images/avatar/4.png" alt="" class="rounded me-3 border" />
                            <div class="notifications-desc">
                                <a href="javascript:void(0);" class="font-body text-truncate-2-line"> <span class="fw-semibold text-dark">Archie Cantones</span> Don't forget to pickup Jeremy after school!</a>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="notifications-date text-muted border-bottom border-bottom-dashed">53 minutes ago</div>
                                    <div class="d-flex align-items-center float-end gap-2">
                                        <a href="javascript:void(0);" class="d-block wd-8 ht-8 rounded-circle bg-gray-300" data-bs-toggle="tooltip" title="Make as Read"></a>
                                        <a href="javascript:void(0);" class="text-danger" data-bs-toggle="tooltip" title="Remove">
                                            <i class="fa-solid fa-x fs-12"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center notifications-footer">
                            <a href="javascript:void(0);" class="fs-13 fw-semibold text-dark">Alls Notifications</a>
                        </div>
                    </div>
                </div>
                <div class="dropdown nxl-h-item">
                    <a href="javascript:void(0);" data-bs-toggle="dropdown" role="button" data-bs-auto-close="outside">
                        <img src="assets/images/avatar/1.png" alt="user-image" class="img-fluid user-avtar me-0" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-user-dropdown">
                        <div class="dropdown-header">
                            <div class="d-flex align-items-center">
                                <img src="assets/images/avatar/1.png" alt="user-image" class="img-fluid user-avtar" />
                                <div>
                                    <h6 class="text-dark mb-0">Alexandra Della <span class="badge bg-soft-success text-success ms-1">PRO</span></h6>
                                    <span class="fs-12 fw-medium text-muted">alex@example.com</span>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:void(0);" class="dropdown-item prof">
                            <i class="fa-solid fa-user"></i>
                            <span>{{ __('dashboard.header.profile') }}</span>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item prof">
                            <i class="fa-solid fa-gear"></i>
                            <span>{{ __('dashboard.header.setting') }}</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="dropdown-item prof" style="border: none; background: none; cursor: pointer; width: 100%; text-align: left;">
                                <i class="fa-solid fa-power-off"></i>
                                <span>{{ __('dashboard.header.logout') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--! [End] Header Right !-->
    </div>
</header>
<style>
    .prof{
        display: flex;
        align-items: center;
        flex-direction: row;
        justify-content: flex-start;
        column-gap: 1rem;
    }
</style>
