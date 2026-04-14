@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ sec_asset('css/domain/index.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.domain.list') }}"
        :items="[
            ['label' => __('dashboard.sidebar.domain.list')]
        ]"
    />
@endsection

@section('content_2')
    @php
        $columns = [
            [
                'label' => '#',
                'value' => fn ($domain, $loop) => $loop->iteration,
                'show_in_accordion' => false,
            ],
            [
                'label' => __('domains.index.title'),
                'field' => 'title',
            ],
            [
                'label' => __('domains.index.description'),
                'value' => fn ($domain) => \Illuminate\Support\Str::limit($domain->description, 125, '...'),
                'td_class' => 'text-wrap action',
            ],
            [
                'label' => __('domains.index.status.title'),
                'value' => fn ($domain) => $domain->status ? __('domains.index.status.1') : __('domains.index.status.0'),
                'td_class' => 'action',
            ],
            [
                'label' => __('domains.index.featured.title'),
                'value' => fn ($domain) => $domain->is_featured ? __('domains.index.featured.1') : __('domains.index.featured.0'),
                'td_class' => 'action',
            ],
            [
                'label' => __('domains.index.created-by'),
                'value' => fn ($domain) => $domain->creator->name ?? __('Unknown'),
                'td_class' => 'action',
            ],
        ];

        $actions = [
            [
                'icon' => 'fa-solid fa-eye',
                'tooltip' => __('buttons.show'),
                'class' => 'btn btn-sm listing-action listing-action--view',
                'url' => fn ($domain) => route('domains.show', $domain->id),
            ],
            [
                'icon' => 'fa-solid fa-pen',
                'tooltip' => __('buttons.edit'),
                'class' => 'btn btn-sm listing-action listing-action--edit',
                'url' => fn ($domain) => route('domains.edit', $domain->id),
            ],
            [
                'icon' => fn ($domain) => 'fa-solid ' . ($domain->status ? 'fa-download' : 'fa-upload'),
                'tooltip' => __('domains.index.status.title'),
                'class' => fn ($domain) => 'btn btn-sm listing-action ' . ($domain->status ? 'listing-action--muted' : 'listing-action--accent'),
                'onclick' => fn ($domain) => "confirmToggle('statusForm-{$domain->id}', "
                    . \Illuminate\Support\Js::from(__('domains.index.status.confirm'))
                    . ")",
                'form' => [
                    'id' => fn ($domain) => 'statusForm-' . $domain->id,
                    'action' => fn ($domain) => route('domains.status', [$domain->id, $domain->status ? 0 : 1]),
                    'method' => 'PATCH',
                ],
            ],
            [
                'icon' => fn ($domain) => 'fa-regular ' . ($domain->is_featured ? 'fa-thumbs-down' : 'fa-thumbs-up'),
                'tooltip' => __('domains.index.featured.title'),
                'class' => fn ($domain) => 'btn btn-sm listing-action ' . ($domain->is_featured ? 'listing-action--info' : 'listing-action--muted'),
                'onclick' => fn ($domain) => "confirmToggle('featuredForm-{$domain->id}', "
                    . \Illuminate\Support\Js::from(__('domains.index.featured.confirm'))
                    . ")",
                'form' => [
                    'id' => fn ($domain) => 'featuredForm-' . $domain->id,
                    'action' => fn ($domain) => route('domains.featured', [$domain->id, $domain->is_featured ? 0 : 1]),
                    'method' => 'PATCH',
                ],
            ],
            [
                'icon' => 'fa-solid fa-trash',
                'tooltip' => __('buttons.delete'),
                'class' => 'btn btn-sm listing-action listing-action--delete',
                'onclick' => fn ($domain) => "confirmDelete({$domain->id}, "
                    . \Illuminate\Support\Js::from(__('domains.delete.confirm'))
                    . ")",
                'form' => [
                    'id' => fn ($domain) => 'deleteForm-' . $domain->id,
                    'action' => fn ($domain) => route('domains.destroy', $domain->id),
                    'method' => 'DELETE',
                ],
            ],
        ];
    @endphp

    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.domain.list') }}
            </h2>
            <a class="btn success page-action-button" href="{{ route('domains.create') }}">
                <i class="fa-solid fa-plus"></i>
                <span>
                    {{ __('buttons.new') }}
                </span>
            </a>
            <x-admin.listing
                :items="$domains"
                :columns="$columns"
                :actions="$actions"
                :accordion-title="fn ($domain) => $domain->title"
                :empty-message="__('domains.index.not-found')"
                :actions-label="__('domains.index.action')"
                table-head-id="domainsTableHead"
                table-body-id="domainsTableBody"
                mobile-container-id="domainsMobile"
                accordion-parent-id="domainsAccordion"
                id="domains-listing"
            />
        </div>
    </div>
@endsection

@section('js_2')

@endsection
