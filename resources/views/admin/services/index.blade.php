@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ asset('css/service.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.service.list') }}"
        :items="[
            ['label' => __('dashboard.sidebar.service.list')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.service.list') }}
            </h2>
            <a class="btn btn-success" href="{{ route('services.create') }}">
                <span>
                    {{ __('buttons.new') }}
                </span>
            </a>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
