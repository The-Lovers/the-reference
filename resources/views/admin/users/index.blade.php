@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ sec_asset('css/user/index.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.user.list') }}"
        :items="[
            ['label' => __('dashboard.sidebar.user.list')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.user.list') }}
            </h2>
            <a class="btn success page-action-button" href="{{ route('users.create') }}">
                <i class="fa-solid fa-plus"></i>
                <span>
                    {{ __('buttons.new') }}
                </span>
            </a>
            <div
                data-search-url="{{ route('users.index') }}"
                data-search-scope="listing"
            >
                @include('admin.users.partials.listing', ['users' => $users])
            </div>
        </div>
    </div>
@endsection

@section('js_2')
    <style>
        .listing-inline-actions{
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .45rem;
            flex-wrap: wrap;
        }
    </style>
@endsection
