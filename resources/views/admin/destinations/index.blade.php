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
            <div
                data-search-url="{{ route('destinations.index') }}"
                data-search-scope="listing"
            >
                @include('admin.destinations.partials.listing', ['destinations' => $destinations])
            </div>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
