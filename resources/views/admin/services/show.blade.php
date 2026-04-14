@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ asset('css/service.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.service.detail') }}"
        :items="[
            ['label' => __('dashboard.sidebar.service.detail')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">{{ __('dashboard.sidebar.service.detail') }}</h2>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <h5>Title</h5>
                    <h6>{{ $service->title }}</h6>
                </div>
                <div class="col-md-6 mb-3">
                    <h5>Status</h5>
                    <h6>{{ $service->is_active ? 'Active' : 'Inactive' }}</h6>
                </div>
                <div class="col-md-6 mb-3">
                    <h5>Featured</h5>
                    <h6>{{ $service->is_featured ? 'Yes' : 'No' }}</h6>
                </div>
                <div class="col-md-12 mb-3">
                    <h5>Description</h5>
                    <div>{!! $service->description ?: '-' !!}</div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('services.index') }}" class="btn secondary">{{ __('dashboard.header.back') }}</a>
                <a href="{{ route('services.edit', $service->id) }}" class="btn third">{{ __('buttons.edit') }}</a>
            </div>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
