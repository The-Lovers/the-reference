@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ sec_asset('css/mission/index.css') }}">
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
            <a class="btn success page-action-button" href="{{ route('missions.create') }}">
                <i class="fa-solid fa-plus"></i>
                <span>
                    {{ __('buttons.new') }}
                </span>
            </a>
            <div
                data-search-url="{{ route('missions.index') }}"
                data-search-scope="listing"
            >
                @include('admin.missions.partials.listing', ['missions' => $missions])
            </div>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
