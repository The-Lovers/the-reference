@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ asset('css/domain.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.domain.edit') }}"
        :items="[
            ['label' => __('dashboard.sidebar.domain.edit')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.domain.edit') }}
            </h2>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
