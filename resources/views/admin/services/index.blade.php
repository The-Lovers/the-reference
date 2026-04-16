@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ sec_asset('css/service.css') }}">
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
    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.service.list') }}
            </h2>
            <a class="btn success page-action-button" href="{{ route('services.create') }}">
                <i class="fa-solid fa-plus"></i>
                <span>
                    {{ __('buttons.new') }}
                </span>
            </a>
            <div
                data-search-url="{{ route('services.index') }}"
                data-search-scope="listing"
            >
                @include('admin.services.partials.listing', ['services' => $services])
            </div>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
