@include('errors.partials.brand-error-page', [
    'title' => __('guest.not-found.code') . ' - ' . __('guest.not-found.label'),
    'icon' => 'fa-compass',
    'eyebrow' => __('guest.not-found.eyebrow'),
    'code' => __('guest.not-found.code'),
    'heading' => __('guest.not-found.label'),
    'message' => __('guest.not-found.message'),
    'buttonLabel' => __('guest.not-found.cta'),
    'sideTitle' => __('guest.not-found.label'),
    'sideMessage' => __('guest.not-found.message'),
    'chipLabel' => __('guest.not-found.code') . ' / ' . __('guest.not-found.eyebrow'),
    'illustration' => 'not-found',
])
