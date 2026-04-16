@php
    $columns = [
        [
            'label' => '#',
            'value' => fn ($user, $loop) => $loop->iteration,
            'show_in_accordion' => false,
        ],
        [
            'label' => __('user.index.name'),
            'field' => 'name',
            'show_in_accordion' => false,
        ],
        [
            'label' => __('user.index.surname'),
            'field' => 'surname',
            'show_in_accordion' => false,
        ],
        [
            'label' => __('user.index.email'),
            'field' => 'email',
        ],
        [
            'label' => __('user.index.phone'),
            'field' => 'phone',
            'value' => fn ($user) => $user->full_phone ?: '-',
        ],
        [
            'label' => __('user.index.gender'),
            'value' => fn ($user) => $user->gender_label ?: '-',
        ],
    ];

    $actions = [
        [
            'icon' => 'fa-solid fa-eye',
            'tooltip' => __('buttons.show'),
            'class' => 'btn btn-sm listing-action listing-action--view',
            'url' => fn ($user) => route('users.show', $user->id),
        ],
        [
            'icon' => 'fa-solid fa-pen',
            'tooltip' => __('buttons.edit'),
            'class' => 'btn btn-sm listing-action listing-action--edit',
            'visible' => fn ($user) => auth()->user()->can('update', $user),
            'url' => fn ($user) => route('users.edit', $user->id),
        ],
        [
            'icon' => 'fa-solid fa-trash',
            'tooltip' => __('buttons.delete'),
            'class' => 'btn btn-sm listing-action listing-action--delete',
            'visible' => fn ($user) => auth()->user()->can('delete', $user),
            'onclick' => fn () => "if(typeof showPopup==='function'){showPopup('confirm', "
                . \Illuminate\Support\Js::from(__('user.delete.confirm'))
                . ", {theme:'dark', onConfirm: () => this.closest('form').submit()});}else if(confirm("
                . \Illuminate\Support\Js::from(__('user.delete.confirm'))
                . ")){this.closest('form').submit();}",
            'form' => [
                'action' => fn ($user) => route('users.destroy', $user->id),
                'method' => 'DELETE',
            ],
        ],
    ];
@endphp

<div
    id="users-search-results"
    data-search-target="true"
>
    <x-admin.listing
        :items="$users"
        :columns="$columns"
        :actions="$actions"
        :accordion-title="fn ($user) => $user->name . ' ' . $user->surname"
        :empty-message="__('user.index.not-found')"
        :actions-label="__('user.index.action')"
        table-head-id="myTableHead"
        table-body-id="desktopTableBody"
        mobile-container-id="mobileUsers"
        accordion-parent-id="userAccordion"
        id="users-listing"
    />
</div>
