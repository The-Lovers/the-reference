@extends('layouts.admin.app')

@section('css_2')
    <style>
        .main-content{
            background: white !important;
        }
        h5, h6{
            line-height: 2.5rem !important;
        }
        h5{
            font-weight: bold !important;
            font-size: 1.5rem !important;
        }
        h6{
            font-weight: 400 !important;
            font-size: 1.2rem !important;
            position: relative;
            left: 1.2rem;
        }
        .col-md-12 a{
            width: 15% !important;
            border-radius: 20px;
            text-align: center !important;
            font-size: 1.2rem;
            margin: 2.5% auto;
        }
        .nxl-container{
            background: white !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.user.detail') }}"
        :items="[
            ['label' => __('dashboard.sidebar.user.detail')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.user.detail') }}
            </h2>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <h5>{{ __('user.index.name') }}</h5>
                        <h6>{{ $user->name }}</h6>
                    </div>
                    <div class="col-md-6">
                        <h5>{{ __('user.index.surname') }}</h5>
                        <h6>{{ $user->surname }}</h6>
                    </div>
                    <div class="col-md-12">
                        <h5>{{ __('user.index.email') }}</h5>
                        <h6>{{ $user->email }}</h6>
                    </div>
                    <div class="col-md-6">
                        <h5>{{ __('login.username') }}</h5>
                        <h6>{{ $user->username }}</h6>
                    </div>
                    <div class="col-md-6">
                        <h5>{{ __('dashboard.register.role.title') }}</h5>
                        <h6>{{ $user->roles->first()->name }}</h6>
                    </div>
                    <div class="col-md-6">
                        <h5>{{ __('user.index.phone') }}</h5>
                        <h6>{{ $user->phone }}</h6>
                    </div>
                    <div class="col-md-6">
                        <h5>{{ __('user.index.gender') }}</h5>
                        <h6>{{ $user->gender_label }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    {{ __('dashboard.header.back') }}
                </a>
            </div>
        </div>
    </div>
@endsection
