@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ sec_asset('css/mission/index.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.mission.list') }}"
        :items="[
            ['label' => __('dashboard.sidebar.mission.list')]
        ]"
    />
@endsection

@section('content_2')
    @php
        $columns = [
            [
                'label' => '#',
                'value' => fn ($mission, $loop) => $loop->iteration,
                'show_in_accordion' => false,
            ],
            [
                'label' => __('missions.index.title'),
                'field' => 'title',
            ],
            [
                'label' => __('missions.index.description'),
                'value' => fn ($mission) => \Illuminate\Support\Str::limit($mission->description, 125, '...'),
                'td_class' => 'text-wrap action',
            ],
            [
                'label' => __('missions.index.status.title'),
                'value' => fn ($mission) => $mission->status ? __('missions.index.status.1') : __('missions.index.status.0'),
                'td_class' => 'action',
            ],
            [
                'label' => __('missions.index.featured.title'),
                'value' => fn ($mission) => $mission->is_featured ? __('missions.index.featured.1') : __('missions.index.featured.0'),
                'td_class' => 'action',
            ],
            [
                'label' => __('missions.index.created-by'),
                'value' => fn ($mission) => $mission->creator->name ?? __('Unknown'),
                'td_class' => 'action',
            ],
        ];

        $actions = [
            [
                'icon' => 'fa-solid fa-eye',
                'tooltip' => __('buttons.show'),
                'class' => 'btn btn-sm listing-action listing-action--view',
                'url' => fn ($mission) => route('missions.show', $mission->id),
            ],
            [
                'icon' => 'fa-solid fa-pen',
                'tooltip' => __('buttons.edit'),
                'class' => 'btn btn-sm listing-action listing-action--edit',
                'url' => fn ($mission) => route('missions.edit', $mission->id),
            ],
            [
                'icon' => fn ($mission) => 'fa-solid ' . ($mission->status ? 'fa-download' : 'fa-upload'),
                'tooltip' => __('missions.index.status.title'),
                'class' => fn ($mission) => 'btn btn-sm listing-action ' . ($mission->status ? 'listing-action--muted' : 'listing-action--accent'),
                'onclick' => fn ($mission) => "confirmToggle('statusForm-{$mission->id}', "
                    . \Illuminate\Support\Js::from(__('missions.index.status.confirm'))
                    . ")",
                'form' => [
                    'id' => fn ($mission) => 'statusForm-' . $mission->id,
                    'action' => fn ($mission) => route('missions.status', [$mission->id, $mission->status ? 0 : 1]),
                    'method' => 'PATCH',
                ],
            ],
            [
                'icon' => fn ($mission) => 'fa-regular ' . ($mission->is_featured ? 'fa-thumbs-down' : 'fa-thumbs-up'),
                'tooltip' => __('missions.index.featured.title'),
                'class' => fn ($mission) => 'btn btn-sm listing-action ' . ($mission->is_featured ? 'listing-action--info' : 'listing-action--muted'),
                'onclick' => fn ($mission) => "confirmToggle('featuredForm-{$mission->id}', "
                    . \Illuminate\Support\Js::from(__('missions.index.featured.confirm'))
                    . ")",
                'form' => [
                    'id' => fn ($mission) => 'featuredForm-' . $mission->id,
                    'action' => fn ($mission) => route('missions.featured', [$mission->id, $mission->is_featured ? 0 : 1]),
                    'method' => 'PATCH',
                ],
            ],
            [
                'icon' => 'fa-solid fa-trash',
                'tooltip' => __('buttons.delete'),
                'class' => 'btn btn-sm listing-action listing-action--delete',
                'onclick' => fn ($mission) => "confirmDelete({$mission->id}, "
                    . \Illuminate\Support\Js::from(__('missions.delete.confirm'))
                    . ")",
                'form' => [
                    'id' => fn ($mission) => 'deleteForm-' . $mission->id,
                    'action' => fn ($mission) => route('missions.destroy', $mission->id),
                    'method' => 'DELETE',
                ],
            ],
        ];
    @endphp

    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.mission.list') }}
            </h2>
            <a class="btn success page-action-button" href="{{ route('missions.create') }}">
                <i class="fa-solid fa-plus"></i>
                <span>
                    {{ __('buttons.new') }}
                </span>
            </a>
            <x-admin.listing
                :items="$missions"
                :columns="$columns"
                :actions="$actions"
                :accordion-title="fn ($mission) => $mission->title"
                :empty-message="__('missions.index.not-found')"
                :actions-label="__('missions.index.action')"
                table-head-id="missionsTableHead"
                table-body-id="missionsTableBody"
                mobile-container-id="missionsMobile"
                accordion-parent-id="missionsAccordion"
                id="missions-listing"
            />
        </div>
    </div>
@endsection

@section('js_2')

@endsection
