@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ sec_asset('css/destination.css') }}">
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
                    @if ($destination->cover)
                        <img src="{{ sec_asset($destination->cover) }}" alt="{{ $destination->label }}" class="img-fluid rounded">
                    @endif
                </div>
                <div class="col-md-12 mb-3">
                    <h5>{{ __('forms.destination.label') }}</h5>
                    <h6>{{ $destination->label }}</h6>
                </div>
                <div class="col-md-12 mb-3">
                    <h5>{{ __('forms.destination.country') }}</h5>
                    <h6>{{ data_get($destination, 'pays.label_fr') ?? data_get($destination, 'pays.label_en') ?? '-' }}</h6>
                </div>
                <div class="col-md-6 mb-3">
                    <h5>{{ __('forms.destination.availability.title') }}</h5>
                    <h6>{{ $destination->is_available ? __('forms.destination.availability.available') : __('forms.destination.availability.unavailable') }}</h6>
                </div>
                <div class="col-md-12 mb-3">
                    <h5>{{ __('forms.destination.description') }}</h5>
                    <div>{!! $destination->description ?: '-' !!}</div>
                </div>
            </div>

            <div class="buttons">
                <a href="{{ route('destinations.index') }}" class="btn secondary">{{ __('dashboard.header.back') }}</a>
                <a href="{{ route('destinations.edit', $destination->id) }}" class="btn third">{{ __('buttons.edit') }}</a>
            </div>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
