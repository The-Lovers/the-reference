@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ asset('css/testimony.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.testimony.new') }}"
        :items="[
            ['label' => __('dashboard.sidebar.testimony.create')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.testimony.create') }}
            </h2>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
