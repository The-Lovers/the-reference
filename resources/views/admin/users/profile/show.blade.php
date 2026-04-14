@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ asset('css/user/show.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.header.profile') }}"
        :items="[
            ['label' => __('dashboard.header.profile')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.header.profile') }}
            </h2>
        </div>
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <img
                    src="{{ $user->avatar ? asset($user->avatar) : asset('images/logo.png') }}"
                    alt="{{ $user->name }}"
                    class="img-fluid rounded-circle border"
                    style="width: 180px; height: 180px; object-fit: cover;"
                >
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <h5>{{ __('dashboard.register.name') }}</h5>
                        <h6>{{ $user->name }}</h6>
                    </div>
                    <div class="col-md-6">
                        <h5>{{ __('dashboard.register.surname') }}</h5>
                        <h6>{{ $user->surname }}</h6>
                    </div>
                    <div class="col-md-12">
                        <h5>{{ __('dashboard.register.email') }}</h5>
                        <h6>{{ $user->email }}</h6>
                    </div>
                    <div class="col-md-6">
                        <h5>{{ __('dashboard.register.username') }}</h5>
                        <h6>{{ $user->username }}</h6>
                    </div>
                    <div class="col-md-6">
                        <h5>{{ __('dashboard.register.role.title') }}</h5>
                        <h6>{{ optional($user->roles->first())->name ?? '-' }}</h6>
                    </div>
                    <div class="col-md-6">
                        <h5>{{ __('dashboard.register.phone.title') }}</h5>
                        <h6>{{ $user->phone }}</h6>
                    </div>
                    <div class="col-md-6">
                        <h5>{{ __('dashboard.register.gender.title') }}</h5>
                        <h6>{{ $user->gender_label }}</h6>
                    </div>
                    <div class="col-md-6">
                        <h5>Status</h5>
                        <h6>{{ $user->status ? 'Actif' : 'Inactif' }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-12 d-flex gap-2 justify-content-center flex-wrap">
                <a href="{{ route('dashboard') }}" class="btn secondary">
                    {{ __('dashboard.header.back') }}
                </a>
                <a href="{{ route('profile.edit', $user) }}" class="btn third">
                    {{ __('buttons.edit') }}
                </a>
            </div>
        </div>
    </div>
@endsection
