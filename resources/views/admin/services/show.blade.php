@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ sec_asset('css/service.css') }}">
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
                    @if ($service->cover)
                        <img src="{{ sec_asset($service->cover) }}" alt="{{ $service->title }}" class="img-fluid rounded">
                    @endif
                </div>
                <div class="col-md-12 mb-3">
                    <h5>{{ __('forms.service.title') }}</h5>
                    <h6>{{ $service->title }}</h6>
                </div>
                <div class="col-md-6 mb-3">
                    <h5>{{ __('forms.service.status.title') }}</h5>
                    <h6>{{ $service->is_active ? __('forms.service.status.active') : __('forms.service.status.inactive') }}</h6>
                </div>
                <div class="col-md-6 mb-3">
                    <h5>{{ __('forms.service.featured.title') }}</h5>
                    <h6>{{ $service->is_featured ? __('forms.service.featured.yes') : __('forms.service.featured.no') }}</h6>
                </div>
                <div class="col-md-12 mb-3">
                    <h5>{{ __('forms.service.description') }}</h5>
                    <div>{!! $service->description ?: '-' !!}</div>
                </div>
            </div>

            <div class="buttons">
                <a href="{{ route('services.index') }}" class="btn secondary">{{ __('dashboard.header.back') }}</a>
                <a href="{{ route('services.edit', $service->id) }}" class="btn third">{{ __('buttons.edit') }}</a>
            </div>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
