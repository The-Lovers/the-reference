@php
    $currentLocale = app()->getLocale();
    $wrapperClass = $wrapperClass ?? 'dropdown';
    $toggleClass = $toggleClass ?? 'dropdown-toggle';
    $menuClass = $menuClass ?? 'dropdown-menu dropdown-menu-end';
    $itemClass = $itemClass ?? 'dropdown-item d-flex align-items-center gap-2';
    $showChevron = $showChevron ?? false;
    $languageOptions = [
        'fr' => [
            'label' => __('dashboard.header.fr'),
            'flag' => sec_asset('images/fr.png'),
            'alt' => 'Français',
        ],
        'en' => [
            'label' => __('dashboard.header.en'),
            'flag' => sec_asset('images/us.png'),
            'alt' => 'English',
        ],
    ];
    $activeLanguage = $languageOptions[$currentLocale] ?? $languageOptions['en'];
    $routeName = Route::currentRouteName();
    $routeParameters = Route::current()?->parameters() ?? [];
@endphp

<div class="{{ $wrapperClass }}">
    <a
        href="#"
        class="{{ $toggleClass }}"
        role="button"
        data-bs-toggle="dropdown"
        aria-expanded="false"
    >
        <img src="{{ $activeLanguage['flag'] }}" width="20" class="rounded-1" alt="{{ $activeLanguage['alt'] }}">
        @if ($showChevron)
            <i class="fa-solid fa-chevron-down fs-12 opacity-75"></i>
        @endif
    </a>

    <ul class="{{ $menuClass }}">
        @foreach ($languageOptions as $locale => $option)
            <li>
                <a
                    class="{{ $itemClass }} {{ $currentLocale === $locale ? 'active' : '' }}"
                    href="{{ $routeName ? route($routeName, array_merge($routeParameters, ['locale' => $locale])) : route('lang.switch', ['lang' => $locale]) }}"
                    style="color: var(--blue);"
                >
                    <img src="{{ $option['flag'] }}" width="20" class="rounded-1" alt="{{ $option['alt'] }}">
                    <span>{{ $option['label'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</div>
