@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ asset('css/service.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.service.new') }}"
        :items="[
            ['label' => __('dashboard.sidebar.service.create')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.service.create') }}
            </h2>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
