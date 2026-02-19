@extends('layouts.admin.app')

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.dashboard') }}"
        :items="[
            ['label' => __('dashboard.sidebar.dashboard')]
        ]"
    />
@endsection

@section('content_2')
    @include('layouts.admin.card-report')
@endsection
