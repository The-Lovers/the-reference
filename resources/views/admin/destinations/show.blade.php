@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ asset('css/destination.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.destination.detail') }}"
        :items="[
            ['label' => __('dashboard.sidebar.destination.detail')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">{{ __('dashboard.sidebar.destination.detail') }}</h2>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <h5>Label</h5>
                    <h6>{{ $destination->label }}</h6>
                </div>
                <div class="col-md-12 mb-3">
                    <h5>Country</h5>
                    <h6>{{ data_get($destination, 'pays.label_fr') ?? data_get($destination, 'pays.label_en') ?? '-' }}</h6>
                </div>
                <div class="col-md-6 mb-3">
                    <h5>Availability</h5>
                    <h6>{{ $destination->is_available ? 'Available' : 'Unavailable' }}</h6>
                </div>
                <div class="col-md-12 mb-3">
                    <h5>Description</h5>
                    <div>{!! $destination->description ?: '-' !!}</div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('destinations.index') }}" class="btn secondary">{{ __('dashboard.header.back') }}</a>
                <a href="{{ route('destinations.edit', $destination->id) }}" class="btn third">{{ __('buttons.edit') }}</a>
            </div>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
