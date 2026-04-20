@php
    $currentUser = Auth::user();
    $notifications = $currentUser->notifications()->latest()->limit(10)->get();
    $unreadNotificationsCount = $currentUser->unreadNotifications()->count();
    $chatConversations = $currentUser->chatConversationSummaries(8);
    $chatUnreadCount = $currentUser->chatUnreadCount();
@endphp

<header class="nxl-header">
    <div class="header-wrapper">
        <div class="header-left d-flex align-items-center gap-4">
            <a href="javascript:void(0);" class="nxl-head-mobile-toggler" id="mobile-collapse">
                <div class="hamburger hamburger--arrowturn">
                    <div class="hamburger-box">
                        <div class="hamburger-inner"></div>
                    </div>
                </div>
            </a>
            <div class="nxl-navigation-toggle">
                <a href="javascript:void(0);" id="menu-mini-button">
                    <i class="fa-solid fa-align-left"></i>
                </a>
                <a href="javascript:void(0);" id="menu-expend-button" style="display: none">
                    <i class="fa-solid fa-align-right"></i>
                </a>
            </div>
        </div>
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
                            <input type="text" id="searchInput" class="form-control search-input-field" placeholder="Search...." />
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
                                <img src="{{ sec_asset('images/flags/fr.svg') }}" class="me-1" alt="Fr">
                            </a>
                        @else
                            <a class="dropdown-item d-flex align-items-center" href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'en'])) }}">
                                <img src="{{ sec_asset('images/flags/us.svg') }}" class="me-1" alt="En">
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
                                        <div class="avatar-image avatar-sm"><img src="{{ sec_asset('images/fr.png') }}" alt="" class="img-fluid" /></div>
                                        <span>{{ __('dashboard.header.fr') }}</span>
                                    </a>
                                </div>
                                <div class="col-sm-4 col-6 language_select @if(app()->getLocale() === 'en') {{ $active }} @endif">
                                    <a href="javascript:void(0);" class="d-flex align-items-center gap-2">
                                        <div class="avatar-image avatar-sm"><img src="{{ sec_asset('images/us.png') }}" alt="" class="img-fluid" /></div>
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
                    <a class="nxl-head-link me-3" data-bs-toggle="dropdown" href="#" role="button" data-bs-auto-close="outside">
                        <i class="fa-regular fa-bell"></i>
                        @if($unreadNotificationsCount > 0)
                            <span class="badge bg-danger nxl-h-badge">{{ $unreadNotificationsCount }}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-notifications-menu">
                        <div class="d-flex justify-content-between align-items-center notifications-head">
                            <h6 class="fw-bold text-dark mb-0">{{ __('dashboard.header.notifications.title') }}</h6>
                            <button
                                type="button"
                                class="fs-11 text-success text-end ms-auto notification-read-all"
                                style="border: none; background: transparent;"
                                data-url="{{ route('notifications.read-all') }}"
                            >
                                <i class="fa-solid fa-check"></i>
                                <span>{{ __('dashboard.header.notifications.read-all') }}</span>
                            </button>
                        </div>
                        @forelse($notifications as $notification)
                            @php
                                $data = $notification->data;
                            @endphp
                            <div class="notifications-item {{ is_null($notification->read_at) ? 'notification-unread' : '' }}">
                                <div class="notifications-desc w-100">
                                    <a
                                        href="javascript:void(0);"
                                        class="font-body text-truncate-2-line notification-open"
                                        data-url="{{ route('notifications.read', $notification->id) }}"
                                        data-title="{{ $data['title'] ?? __('dashboard.header.notifications.item') }}"
                                        data-message="{{ $data['message'] ?? '' }}"
                                    >
                                        <span class="fw-semibold text-dark">{{ $data['title'] ?? __('dashboard.header.notifications.item') }}</span>
                                        {{ $data['subject_label'] ?? '' }}
                                    </a>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="notifications-date text-muted border-bottom border-bottom-dashed">
                                            {{ $notification->created_at?->diffForHumans() }}
                                        </div>
                                        @if(is_null($notification->read_at))
                                            <span class="d-block wd-8 ht-8 rounded-circle bg-primary"></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="notifications-item">
                                <div class="notifications-desc w-100">
                                    <span class="font-body text-muted">{{ __('dashboard.header.notifications.empty') }}</span>
                                </div>
                            </div>
                        @endforelse
                        <div class="text-center notifications-footer">
                            <span class="fs-13 fw-semibold text-dark">{{ __('dashboard.header.notifications.latest') }}</span>
                        </div>
                    </div>
                </div>
                <div class="dropdown nxl-h-item">
                    <a class="nxl-head-link me-3" data-bs-toggle="dropdown" href="#" role="button" data-bs-auto-close="outside">
                        <i class="fa-regular fa-envelope"></i>
                        <span
                            id="chatHeaderBadge"
                            class="badge bg-danger nxl-h-badge {{ $chatUnreadCount > 0 ? '' : 'd-none' }}"
                        >{{ $chatUnreadCount }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-notifications-menu">
                        <div class="d-flex justify-content-between align-items-center notifications-head">
                            <h6 class="fw-bold text-dark mb-0">{{ __('dashboard.header.messages.title') }}</h6>
                            <button
                                type="button"
                                class="fs-11 text-success text-end ms-auto chat-open-panel-trigger"
                                style="border: none; background: transparent;"
                            >
                                <i class="fa-regular fa-comments"></i>
                                <span>{{ __('dashboard.header.messages.open-chat') }}</span>
                            </button>
                        </div>
                        <div id="chatDropdownList">
                            @forelse($chatConversations as $conversation)
                                <button
                                    type="button"
                                    class="notifications-item w-100 text-start chat-dropdown-item {{ $conversation['unread_count'] > 0 ? 'notification-unread' : '' }}"
                                    data-chat-user-id="{{ $conversation['user']['id'] }}"
                                >
                                    <div class="notifications-desc w-100">
                                        <span class="fw-semibold text-dark">{{ $conversation['user']['name'] }}</span>
                                        <div class="font-body text-muted text-truncate">{{ $conversation['last_message'] }}</div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="notifications-date text-muted border-bottom border-bottom-dashed">
                                                {{ $conversation['last_message_at'] }}
                                            </div>
                                            @if($conversation['unread_count'] > 0)
                                                <span class="internal-chat-inline-badge">{{ $conversation['unread_count'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </button>
                            @empty
                                <div class="notifications-item">
                                    <div class="notifications-desc w-100">
                                        <span class="font-body text-muted">{{ __('dashboard.header.messages.empty') }}</span>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        <div class="text-center notifications-footer">
                            <span class="fs-13 fw-semibold text-dark">{{ __('dashboard.header.messages.latest') }}</span>
                        </div>
                    </div>
                </div>
                <div class="dropdown nxl-h-item">
                    <a href="javascript:void(0);" data-bs-toggle="dropdown" role="button" data-bs-auto-close="outside">
                        <img
                            src="{{ $currentUser->avatar_url }}"
                            alt="{{ $currentUser->name }}"
                            class="img-fluid user-avtar me-0"
                        />
                    </a>
                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-user-dropdown">
                        <div class="dropdown-header">
                            <div class="d-flex align-items-center">
                                <img
                                    src="{{ $currentUser->avatar_url }}"
                                    alt="{{ $currentUser->name }}"
                                    class="img-fluid user-avtar"
                                />
                                <div>
                                    <h6 class="text-dark mb-0">
                                        {{ $currentUser->name }}
                                        <span class="badge bg-soft-success text-success ms-1">{{ $currentUser->primary_role_label }}</span>
                                    </h6>
                                    <span class="fs-12 fw-medium text-muted">{{ $currentUser->email }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('profile.show', $currentUser) }}" class="dropdown-item prof">
                            <i class="fa-solid fa-user"></i>
                            <span>{{ __('dashboard.header.profile') }}</span>
                        </a>
                        <a href="{{ route('profile.edit', $currentUser) }}" class="dropdown-item prof">
                            <i class="fa-solid fa-gear"></i>
                            <span>{{ __('dashboard.header.setting') }}</span>
                        </a>
                        @if($currentUser->hasRole('super-admin'))
                            <div class="dropdown-divider"></div>
                            <a href="{{ url('/telescope') }}" class="dropdown-item prof">
                                <i class="fa-solid fa-bug"></i>
                                <span>{{ __('dashboard.header.telescope') }}</span>
                            </a>
                            <a href="{{ route('log-viewer::logs.list') }}" class="dropdown-item prof">
                                <i class="fa-solid fa-bug-slash"></i>
                                <span>{{ __('dashboard.header.log-viewer') }}</span>
                            </a>
                        @endif
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
    .notification-unread{
        background: rgba(11,60,93,.05);
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const miniButton = document.getElementById('menu-mini-button');
        const expendButton = document.getElementById('menu-expend-button');

        miniButton?.addEventListener('click', function () {
            document.querySelectorAll('.b-brand .title, .b-brand .nxl-mtext').forEach((element) => {
                element.classList.add('d-none');
            });
        });

        expendButton?.addEventListener('click', function () {
            document.querySelectorAll('.b-brand .title, .b-brand .nxl-mtext').forEach((element) => {
                element.classList.remove('d-none');
            });
        });

        document.querySelectorAll('.notification-open').forEach((button) => {
            button.addEventListener('click', async function () {
                const title = this.dataset.title;
                const message = this.dataset.message;
                const url = this.dataset.url;

                showPopup('info', `<strong>${title}</strong><br>${message}`, {
                    theme: 'dark',
                    timeout: 7000
                });

                if (url) {
                    await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                    });
                    window.location.reload();
                }
            });
        });

        document.querySelector('.notification-read-all')?.addEventListener('click', async function () {
            const url = this.dataset.url;

            await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            });

            window.location.reload();
        });

        document.querySelectorAll('.chat-dropdown-item').forEach((button) => {
            button.addEventListener('click', function () {
                window.InternalChat?.openConversation(this.dataset.chatUserId);
            });
        });

        const searchInput = document.getElementById('searchInput');
        const searchCloseButton = document.querySelector('.nxl-search-dropdown .btn-close');
        const searchScope = document.querySelector('[data-search-scope="listing"]');
        let searchTimeout = null;
        let searchController = null;

        const syncSearchInputState = function () {
            if (!searchInput) {
                return;
            }

            const currentUrl = new URL(window.location.href);
            searchInput.value = currentUrl.searchParams.get('search') ?? '';
            searchInput.disabled = !searchScope;
        };

        const applyListingSearch = async function (term) {
            if (!searchScope) {
                return;
            }

            const searchUrl = searchScope.dataset.searchUrl;
            const currentTarget = searchScope.querySelector('[data-search-target="true"]');
            const previousThead = currentTarget?.querySelector('thead');
            const wasDarkTable = previousThead?.classList.contains('table-dark');

            if (!searchUrl || !currentTarget) {
                return;
            }

            if (searchController) {
                searchController.abort();
            }

            searchController = new AbortController();

            const url = new URL(searchUrl, window.location.origin);
            if (term.trim() !== '') {
                url.searchParams.set('search', term.trim());
            }

            try {
                window.showPageLoader?.();

                const response = await fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    signal: searchController.signal,
                });

                if (!response.ok) {
                    throw new Error('Search request failed');
                }

                const data = await response.json();
                searchScope.innerHTML = data.html;

                const newTarget = searchScope.querySelector('[data-search-target="true"]');
                const newThead = newTarget?.querySelector('thead');

                if (wasDarkTable && newThead) {
                    newThead.classList.remove('table-light');
                    newThead.classList.add('table-dark');
                }

                window.initializeReusableListings?.(searchScope);

                const browserUrl = new URL(window.location.href);
                if (term.trim() !== '') {
                    browserUrl.searchParams.set('search', term.trim());
                } else {
                    browserUrl.searchParams.delete('search');
                }
                window.history.replaceState({}, '', browserUrl);
            } catch (error) {
                if (error.name !== 'AbortError') {
                    console.error(error);
                }
            } finally {
                window.hidePageLoader?.();
            }
        };

        syncSearchInputState();

        searchInput?.addEventListener('input', function () {
            clearTimeout(searchTimeout);

            const term = this.value;

            searchTimeout = setTimeout(() => {
                applyListingSearch(term);
            }, 300);
        });

        searchCloseButton?.addEventListener('click', function () {
            if (!searchInput) {
                return;
            }

            searchInput.value = '';
            clearTimeout(searchTimeout);
            applyListingSearch('');
        });
    });
</script>
