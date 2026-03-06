@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ asset('css/domain.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.domain.list') }}"
        :items="[
            ['label' => __('dashboard.sidebar.domain.list')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.domain.list') }}
            </h2>
            <a class="btn btn-success" href="{{ route('domains.create') }}">
                <span>
                    {{ __('buttons.new') }}
                </span>
            </a>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
