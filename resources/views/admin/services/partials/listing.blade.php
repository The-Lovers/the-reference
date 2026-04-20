@php
    $columns = [
        [
            'label' => '#',
            'value' => fn ($service, $loop) => $loop->iteration,
            'show_in_accordion' => false,
        ],
        [
            'label' => 'Cover',
            'value' => fn ($service) => $service->cover
                ? '<img src="' . e(sec_asset($service->cover)) . '" alt="' . e($service->title) . '" class="listing-cover-thumb">'
                : '-',
            'show_in_accordion' => false,
        ],
        [
            'label' => 'Title',
            'field' => 'title',
        ],
        [
            'label' => 'Description',
            'value' => fn ($service) => \Illuminate\Support\Str::limit($service->description, 125, '...'),
        ],
        [
            'label' => 'Active',
            'value' => fn ($service) => $service->is_active
                ? '<span class="listing-badge listing-badge--success">Yes</span>'
                : '<span class="listing-badge listing-badge--danger">No</span>',
        ],
        [
            'label' => 'Featured',
            'value' => fn ($service) => $service->is_featured
                ? '<span class="listing-badge listing-badge--info">Yes</span>'
                : '<span class="listing-badge listing-badge--muted">No</span>',
        ],
    ];

    $actions = [
        [
            'icon' => 'fa-solid fa-eye',
            'tooltip' => __('buttons.show'),
            'class' => 'btn btn-sm listing-action listing-action--view',
            'url' => fn ($service) => route('services.show', $service->id),
        ],
        [
            'icon' => 'fa-solid fa-pen',
            'tooltip' => __('buttons.edit'),
            'class' => 'btn btn-sm listing-action listing-action--edit',
            'url' => fn ($service) => route('services.edit', $service->id),
        ],
        [
            'icon' => 'fa-solid fa-trash',
            'tooltip' => __('buttons.delete'),
            'class' => 'btn btn-sm listing-action listing-action--delete',
            'onclick' => fn ($service) => "confirmDelete({$service->id}, "
                . \Illuminate\Support\Js::from('Voulez-vous vraiment supprimer cet élément ?')
                . ")",
            'form' => [
                'id' => fn ($service) => 'deleteForm-' . $service->id,
                'action' => fn ($service) => route('services.destroy', $service->id),
                'method' => 'DELETE',
            ],
        ],
    ];
@endphp

<div id="services-search-results" data-search-target="true">
    <x-admin.listing
        :items="$services"
        :columns="$columns"
        :actions="$actions"
        :accordion-title="fn ($service) => $service->title"
        :empty-message="'No service found.'"
        :actions-label="'Actions'"
        table-head-id="servicesTableHead"
        table-body-id="servicesTableBody"
        mobile-container-id="servicesMobile"
        accordion-parent-id="servicesAccordion"
        id="services-listing"
    />
</div>
