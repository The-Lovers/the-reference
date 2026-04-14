@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ asset('css/testimony.css') }}">
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
                        <img src="{{ asset($testimony->avatar) }}" alt="Avatar" class="img-fluid rounded">
                    @else
                        <div class="border rounded p-4 text-center">No avatar</div>
                    @endif
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h5>Name</h5>
                            <h6>{{ $testimony->name }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5>Surname</h5>
                            <h6>{{ $testimony->surname }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5>Note</h5>
                            <h6>{{ $testimony->note ?? '-' }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5>Status</h5>
                            <h6>{{ $testimony->status ? 'Published' : 'Draft' }}</h6>
                        </div>
                        <div class="col-md-12 mb-3">
                            <h5>Message</h5>
                            <div>{!! nl2br(e($testimony->message)) !!}</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <h5>Description</h5>
                            <div>{!! $testimony->description ? nl2br(e($testimony->description)) : '-' !!}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('testimonies.index') }}" class="btn secondary">{{ __('dashboard.header.back') }}</a>
                <a href="{{ route('testimonies.edit', $testimony->id) }}" class="btn third">{{ __('buttons.edit') }}</a>
            </div>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
