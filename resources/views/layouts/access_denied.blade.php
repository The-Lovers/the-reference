@include('errors.partials.brand-error-page', [
    'title' => __('guest.access-denied.code') . ' - ' . __('guest.access-denied.label'),
    'icon' => 'fa-lock',
    'eyebrow' => __('guest.access-denied.eyebrow'),
    'code' => __('guest.access-denied.code'),
    'heading' => __('guest.access-denied.label'),
    'message' => __('guest.access-denied.message'),
    'buttonLabel' => __('guest.access-denied.cta'),
    'sideTitle' => __('guest.access-denied.label'),
    'sideMessage' => __('guest.access-denied.message'),
    'chipLabel' => __('guest.access-denied.code') . ' / ' . __('guest.access-denied.eyebrow'),
    'illustration' => 'access-denied',
])
