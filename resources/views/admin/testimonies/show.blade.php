@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ sec_asset('css/testimony.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.testimony.detail') }}"
        :items="[
            ['label' => __('dashboard.sidebar.testimony.detail')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">{{ __('dashboard.sidebar.testimony.detail') }}</h2>

            <div class="row">
                <div class="col-md-3 mb-3">
                    @if ($testimony->avatar)
                        <img src="{{ sec_asset($testimony->avatar) }}" alt="{{ __('forms.testimony.avatar') }}" class="img-fluid rounded">
                    @else
                        <div class="border rounded p-4 text-center">{{ __('forms.testimony.empty-avatar') }}</div>
                    @endif
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h5>{{ __('forms.testimony.name') }}</h5>
                            <h6>{{ $testimony->name }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5>{{ __('forms.testimony.surname') }}</h5>
                            <h6>{{ $testimony->surname }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5>{{ __('forms.testimony.note') }}</h5>
                            <h6>{{ $testimony->note ?? '-' }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5>{{ __('forms.testimony.status.title') }}</h5>
                            <h6>{{ $testimony->status ? __('forms.testimony.status.published') : __('forms.testimony.status.draft') }}</h6>
                        </div>
                        <div class="col-md-12 mb-3">
                            <h5>{{ __('forms.testimony.message') }}</h5>
                            <div>{!! nl2br(e($testimony->message)) !!}</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <h5>{{ __('forms.testimony.description') }}</h5>
                            <div>{!! $testimony->description ? nl2br(e($testimony->description)) : '-' !!}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="buttons">
                <a href="{{ route('testimonies.index') }}" class="btn secondary">{{ __('dashboard.header.back') }}</a>
                <a href="{{ route('testimonies.edit', $testimony->id) }}" class="btn third">{{ __('buttons.edit') }}</a>
            </div>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
