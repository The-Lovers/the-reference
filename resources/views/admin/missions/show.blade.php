@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ asset('css/mission.css') }}">
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
            <h2 class="title">
                {{ __('dashboard.sidebar.mission.detail') }}
            </h2>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
