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
            <div
                data-search-url="{{ route('domains.index') }}"
                data-search-scope="listing"
            >
                @include('admin.domains.partials.listing', ['domains' => $domains])
            </div>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
