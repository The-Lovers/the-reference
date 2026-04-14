@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ sec_asset('css/mission/create.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.mission.detail') }}"
        :items="[
            ['label' => __('dashboard.sidebar.mission.detail')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">{{ __('dashboard.sidebar.mission.detail') }}</h2>

            <div class="row">
                <div class="col-md-4 mb-3">
                    @if ($mission->cover)
                        <img src="{{ sec_asset($mission->cover) }}" alt="{{ $mission->title }}" class="img-fluid rounded">
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <h5>{{ __('missions.index.title') }}</h5>
                            <h6>{{ $mission->title }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5>{{ __('missions.index.status.title') }}</h5>
                            <h6>{{ $mission->status ? __('missions.index.status.1') : __('missions.index.status.0') }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5>{{ __('missions.index.featured.title') }}</h5>
                            <h6>{{ $mission->is_featured ? __('missions.index.featured.1') : __('missions.index.featured.0') }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5>{{ __('forms.mission.icon') }}</h5>
                            <h6><i class="{{ $mission->icon }}"></i> {{ $mission->icon }}</h6>
                        </div>
                        <div class="col-md-12 mb-3">
                            <h5>{{ __('missions.index.description') }}</h5>
                            <div>{!! $mission->description !!}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="buttons">
                <a href="{{ route('missions.index') }}" class="btn secondary">{{ __('dashboard.header.back') }}</a>
                <a href="{{ route('missions.edit', $mission->id) }}" class="btn third">{{ __('buttons.edit') }}</a>
            </div>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
