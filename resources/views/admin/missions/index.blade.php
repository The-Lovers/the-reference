@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ asset('css/mission.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.mission.list') }}"
        :items="[
            ['label' => __('dashboard.sidebar.mission.list')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.mission.list') }}
            </h2>
            <a class="btn btn-success" href="{{ route('missions.create') }}">
                <span>
                    {{ __('buttons.new') }}
                </span>
            </a>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
