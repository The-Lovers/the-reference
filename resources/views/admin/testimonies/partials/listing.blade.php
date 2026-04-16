@php
    $columns = [
        [
            'label' => '#',
            'value' => fn ($testimony, $loop) => $loop->iteration,
            'show_in_accordion' => false,
        ],
        [
            'label' => 'Name',
            'value' => fn ($testimony) => trim(($testimony->name ?? '') . ' ' . ($testimony->surname ?? '')),
        ],
        [
            'label' => 'Note',
            'value' => fn ($testimony) => $testimony->note ?? '-',
        ],
        [
            'label' => 'Message',
            'value' => fn ($testimony) => \Illuminate\Support\Str::limit($testimony->message ?? $testimony->description, 125, '...'),
        ],
        [
            'label' => 'Status',
            'value' => fn ($testimony) => $testimony->status ? 'Published' : 'Draft',
        ],
    ];

    $actions = [
        [
            'icon' => 'fa-solid fa-eye',
            'tooltip' => __('buttons.show'),
            'class' => 'btn btn-sm listing-action listing-action--view',
            'url' => fn ($testimony) => route('testimonies.show', $testimony->id),
        ],
        [
            'icon' => 'fa-solid fa-pen',
            'tooltip' => __('buttons.edit'),
            'class' => 'btn btn-sm listing-action listing-action--edit',
            'url' => fn ($testimony) => route('testimonies.edit', $testimony->id),
        ],
        [
            'icon' => 'fa-solid fa-trash',
            'tooltip' => __('buttons.delete'),
            'class' => 'btn btn-sm listing-action listing-action--delete',
            'onclick' => fn ($testimony) => "confirmDelete({$testimony->id}, "
                . \Illuminate\Support\Js::from('Voulez-vous vraiment supprimer cet élément ?')
                . ")",
            'form' => [
                'id' => fn ($testimony) => 'deleteForm-' . $testimony->id,
                'action' => fn ($testimony) => route('testimonies.destroy', $testimony->id),
                'method' => 'DELETE',
            ],
        ],
    ];
@endphp

<div id="testimonies-search-results" data-search-target="true">
    <x-admin.listing
        :items="$testimonies"
        :columns="$columns"
        :actions="$actions"
        :accordion-title="fn ($testimony) => trim(($testimony->name ?? '') . ' ' . ($testimony->surname ?? ''))"
        :empty-message="'No testimony found.'"
        :actions-label="'Actions'"
        table-head-id="testimoniesTableHead"
        table-body-id="testimoniesTableBody"
        mobile-container-id="testimoniesMobile"
        accordion-parent-id="testimoniesAccordion"
        id="testimonies-listing"
    />
</div>
