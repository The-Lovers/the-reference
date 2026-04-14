@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ sec_asset('css/destination.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.destination.list') }}"
        :items="[
            ['label' => __('dashboard.sidebar.destination.list')]
        ]"
    />
@endsection

@section('content_2')
    @php
        $columns = [
            [
                'label' => '#',
                'value' => fn ($destination, $loop) => $loop->iteration,
                'show_in_accordion' => false,
            ],
            [
                'label' => 'Label',
                'field' => 'label',
            ],
            [
                'label' => 'Description',
                'value' => fn ($destination) => \Illuminate\Support\Str::limit($destination->description, 125, '...'),
            ],
            [
                'label' => 'Country',
                'value' => fn ($destination) => data_get($destination, 'pays.label_fr')
                    ?? data_get($destination, 'pays.label_en')
                    ?? '-',
            ],
            [
                'label' => 'Price',
                'value' => fn ($destination) => $destination->price ?? '-',
            ],
            [
                'label' => 'Available',
                'value' => fn ($destination) => $destination->is_available ? 'Yes' : 'No',
            ],
        ];

        $actions = [
            [
                'icon' => 'fa-solid fa-eye',
                'tooltip' => __('buttons.show'),
                'class' => 'btn btn-sm listing-action listing-action--view',
                'url' => fn ($destination) => route('destinations.show', $destination->id),
            ],
            [
                'icon' => 'fa-solid fa-pen',
                'tooltip' => __('buttons.edit'),
                'class' => 'btn btn-sm listing-action listing-action--edit',
                'url' => fn ($destination) => route('destinations.edit', $destination->id),
            ],
            [
                'icon' => 'fa-solid fa-trash',
                'tooltip' => __('buttons.delete'),
                'class' => 'btn btn-sm listing-action listing-action--delete',
                'onclick' => fn ($destination) => "confirmDelete({$destination->id}, "
                    . \Illuminate\Support\Js::from('Voulez-vous vraiment supprimer cet élément ?')
                    . ")",
                'form' => [
                    'id' => fn ($destination) => 'deleteForm-' . $destination->id,
                    'action' => fn ($destination) => route('destinations.destroy', $destination->id),
                    'method' => 'DELETE',
                ],
            ],
        ];
    @endphp

    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.destination.list') }}
            </h2>
            <a class="btn success page-action-button" href="{{ route('destinations.create') }}">
                <i class="fa-solid fa-plus"></i>
                <span>
                    {{ __('buttons.new') }}
                </span>
            </a>
            <x-admin.listing
                :items="$destinations"
                :columns="$columns"
                :actions="$actions"
                :accordion-title="fn ($destination) => $destination->label"
                :empty-message="'No destination found.'"
                :actions-label="'Actions'"
                table-head-id="destinationsTableHead"
                table-body-id="destinationsTableBody"
                mobile-container-id="destinationsMobile"
                accordion-parent-id="destinationsAccordion"
                id="destinations-listing"
            />
        </div>
    </div>
@endsection

@section('js_2')

@endsection
