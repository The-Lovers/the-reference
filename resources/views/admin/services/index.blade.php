@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ asset('css/service.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.service.list') }}"
        :items="[
            ['label' => __('dashboard.sidebar.service.list')]
        ]"
    />
@endsection

@section('content_2')
    @php
        $columns = [
            [
                'label' => '#',
                'value' => fn ($service, $loop) => $loop->iteration,
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
                'value' => fn ($service) => $service->is_active ? 'Yes' : 'No',
            ],
            [
                'label' => 'Featured',
                'value' => fn ($service) => $service->is_featured ? 'Yes' : 'No',
            ],
        ];

        $actions = [
            [
                'icon' => 'fa-solid fa-eye',
                'tooltip' => __('buttons.show'),
                'class' => 'btn btn-sm btn-primary',
                'url' => fn ($service) => route('services.show', $service->id),
            ],
            [
                'icon' => 'fa-solid fa-pen',
                'tooltip' => __('buttons.edit'),
                'class' => 'btn btn-sm btn-warning',
                'url' => fn ($service) => route('services.edit', $service->id),
            ],
            [
                'icon' => 'fa-solid fa-trash',
                'tooltip' => __('buttons.delete'),
                'class' => 'btn btn-sm btn-danger',
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

    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.service.list') }}
            </h2>
            <a class="btn btn-success" href="{{ route('services.create') }}">
                <span>
                    {{ __('buttons.new') }}
                </span>
            </a>
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
    </div>
@endsection

@section('js_2')

@endsection
