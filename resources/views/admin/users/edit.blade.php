@extends('layouts.admin.app')

@section('css_2')
    <style>
        .nxl-container{
            background: white !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.user.edit') }}"
        :items="[
            ['label' => __('dashboard.sidebar.user.edit')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.user.edit') }}
            </h2>
        </div>
    </div>
@endsection
