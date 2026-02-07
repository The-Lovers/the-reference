@extends('layouts.admin.app')

@section('css_2')
    <style>
        :root{
            --blue:#0b3c5d;
            --orange:#f57c00;
            --light:#f9f9f9;
            --dark:#1c1c1c;
        }
        .form-control, .form-select, .input-group-text{
            border: none !important;
            border-bottom: 1px solid var(--orange) !important;
            border-radius: 0 !important;
        }
        .no-arrow {
            background: white !important;
            appearance: none;          /* Standard */
            -webkit-appearance: none;  /* Chrome / Safari */
            -moz-appearance: none;     /* Firefox */
            background-image: none;
            border-right: 1px solid var(--blue) !important;
        }
        .no-arrow::-ms-expand {
            display: none; /* Edge / IE */
        }
        .btn{
            border: 1px solid black !important;
            width: 32% !important;
        }
        .myBtn{
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: wrap !important;
            column-gap: 1% !important;
            justify-content: space-between !important;
            padding-left: 1% !important;
            padding-right: 1% !important;
        }
    </style>
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.user.new') }}
            </h2>
            <form action="{{ route('register') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="">
                            <label for="floatingInput">{{ __('dashboard.register.name') }}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="">
                            <label for="floatingInput">{{ __('dashboard.register.surname') }}</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="">
                            <label for="floatingInput">{{ __('dashboard.register.username') }}</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" placeholder="">
                            <label for="floatingInput">{{ __('dashboard.register.email') }}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" aria-label="{{ __('dashboard.register.gender.title') }}">
                                <option value="" selected>{{ __('dashboard.register.gender.placeholder') }}</option>
                                <option value="M">{{ __('dashboard.register.gender.m') }}</option>
                                <option value="F">{{ __('dashboard.register.gender.f') }}</option>
                            </select>
                            <label for="floatingSelect">{{ __('dashboard.register.gender.title') }}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" aria-label="{{ __('dashboard.register.gender.title') }}">
                                <option value="" selected>{{ __('dashboard.register.role.placeholder') }}</option>
                                <option value=""></option>
                            </select>
                            <label for="floatingSelect">{{ __('dashboard.register.role.title') }}</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <select class="input-group-text no-arrow" name="code" id="code">
                                <option value="">{{ __('dashboard.register.phone.placeholder') }}</option>
                            </select>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInputGroup1" placeholder="">
                                <label for="floatingInputGroup1">{{ __('dashboard.register.phone.title') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="">
                            <label for="floatingPassword">{{ __('dashboard.register.password') }}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="">
                            <label for="floatingPassword">{{ __('dashboard.register.confirm-pass') }}</label>
                        </div>
                    </div>
                    <div class="col-md-12 my-5">
                        <div class="row myBtn">
                            <button type="button" class="btn col-md-4">{{ __('dashboard.register.btn.cancel') }}</button>
                            <button type="reset" class="btn col-md-4">{{ __('dashboard.register.btn.reset') }}</button>
                            <button type="submit" class="btn col-md-4">{{ __('dashboard.register.btn.confirm') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js_2')
    <script>
        $(document).ready(function(){
            $('#code').select2({
                placeholder: "{{ __('dashboard.register.phone.placeholder') }}",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection

