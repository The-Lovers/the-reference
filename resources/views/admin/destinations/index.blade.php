@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ asset('css/destination.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.destination.list') }}"
        :items="[
            ['label' => __('dashboard.sidebar.destination.list')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.destination.list') }}
            </h2>
            <a class="btn" href="{{ route('destinations.create') }}">
                <span>
                    {{ __('user.index.add-user') }}
                </span>
            </a>
        </div>
    </div>
@endsection

@section('js_2')

@endsection
