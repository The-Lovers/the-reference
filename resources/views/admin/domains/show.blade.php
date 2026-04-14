@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ sec_asset('css/domain/create.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.domain.detail') }}"
        :items="[
            ['label' => __('dashboard.sidebar.domain.detail')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">{{ __('dashboard.sidebar.domain.detail') }}</h2>

            <div class="row">
                <div class="col-md-4 mb-3">
                    @if ($domain->cover)
                        <img src="{{ sec_asset($domain->cover) }}" alt="{{ $domain->title }}" class="img-fluid rounded">
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <h5>{{ __('domains.index.title') }}</h5>
                            <h6>{{ $domain->title }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5>{{ __('domains.index.status.title') }}</h5>
                            <h6>{{ $domain->status ? __('domains.index.status.1') : __('domains.index.status.0') }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5>{{ __('domains.index.featured.title') }}</h5>
                            <h6>{{ $domain->is_featured ? __('domains.index.featured.1') : __('domains.index.featured.0') }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5>{{ __('forms.domain.icon') }}</h5>
                            <h6><i class="{{ $domain->icon }}"></i> {{ $domain->icon }}</h6>
                        </div>
                        <div class="col-md-12 mb-3">
                            <h5>{{ __('domains.index.description') }}</h5>
                            <div>{!! $domain->description !!}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="buttons">
                <a href="{{ route('domains.index') }}" class="btn secondary">{{ __('dashboard.header.back') }}</a>
                <a href="{{ route('domains.edit', $domain->id) }}" class="btn third">{{ __('buttons.edit') }}</a>
            </div>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
