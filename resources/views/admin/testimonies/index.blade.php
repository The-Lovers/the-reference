@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ sec_asset('css/testimony.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.testimony.list') }}"
        :items="[
            ['label' => __('dashboard.sidebar.testimony.list')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.testimony.list') }}
            </h2>
            <a class="btn success page-action-button" href="{{ route('testimonies.create') }}">
                <i class="fa-solid fa-plus"></i>
                <span>
                    {{ __('buttons.new') }}
                </span>
            </a>
            <div
                data-search-url="{{ route('testimonies.index') }}"
                data-search-scope="listing"
            >
                @include('admin.testimonies.partials.listing', ['testimonies' => $testimonies])
            </div>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
