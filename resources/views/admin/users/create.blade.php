@extends('layouts.admin.app')

@section('css_2')
    <style>
        :root{
            --blue:#0b3c5d;
            --orange:#f57c00;
            --light:#f9f9f9;
            --dark:#1c1c1c;
            --danger: #d9534f;
            --sencondary: #6C757D;
            --info: #5bc0de;
        }
        .success{
            background-color: var(--blue);
            color: var(--light);
        }
        .success:hover{
            background-color: var(--light);
            color: var(--blue) !important;
            border: 1px solid var(--blue)
        }
        .danger{
            background-color: var(--danger);
            color: var(--light);
        }
        .danger:hover{
            background-color: var(--light);
            color: var(--danger) !important;
            border: 1px solid var(--danger)
        }
        .secondary{
            background-color: var(--sencondary);
            color: var(--light) !important;
        }
        .secondary:hover{
            background-color: var(--light);
            color: var(--dark) !important;
            border: 1px solid var(--dark);
        }
        .form-control, .form-select, .input-group-text{
            border: none !important;
            border-bottom: 1px solid var(--orange) !important;
            border-radius: 0 !important;
        }
         .form-control:hover, .form-select:hover, .input-group-text:hover{
            border-bottom: 1px solid var(--orange) !important;
            label{

            }
         }
        .no-arrow {
            background: white !important;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: none;
            border-right: 1px solid var(--blue) !important;
        }
        .no-arrow::-ms-expand {
            display: none; /* Edge / IE */
        }
        .btn{
            border: none;
            width: 32% !important;
            font-size: 1rem;
            border-radius: 1rem;
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
        .select2-container--default.select2-container {
            width: 10rem !important;
            border: none !important;
            border-bottom: 1px solid var(--orange) !important;
            border-radius: 0 !important;
            background-color: white !important;
        }
        .select2-container--default .select2-selection--single {
            background-color: white !important;
            border: none !important;
            border-radius: 0 !important;
        }
        .select2-container .select2-selection--single {
            height: inherit !important;
        }
        .select2-selection__arrow {
            display: none !important;
        }

    </style>
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.sidebar.user.new') }}"
        :items="[
            ['label' => __('dashboard.sidebar.user.create')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.sidebar.user.create') }}
            </h2>
            <form action="{{ route('users.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" name="name" required>
                            <label for="floatingInput">{{ __('dashboard.register.name') }}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" name="surname" required>
                            <label for="floatingInput">{{ __('dashboard.register.surname') }}</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" name="username" required>
                            <label for="floatingInput">{{ __('dashboard.register.username') }}</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" name="email" required>
                            <label for="floatingInput">{{ __('dashboard.register.email') }}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" aria-label="{{ __('dashboard.register.gender.title') }}" name="gender" required>
                                <option value="" selected>{{ __('dashboard.register.gender.placeholder') }}</option>
                                <option value="M">{{ __('dashboard.register.gender.m') }}</option>
                                <option value="F">{{ __('dashboard.register.gender.f') }}</option>
                            </select>
                            <label for="floatingSelect">{{ __('dashboard.register.gender.title') }}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" aria-label="{{ __('dashboard.register.gender.title') }}" name="role" required>
                                <option value="" selected>{{ __('dashboard.register.role.placeholder') }}</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">{{ __('dashboard.register.role.title') }}</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <select id="phone_code" name="code" class="w-full input-group-text no-arrow">
                                @foreach($phoneCodes as $phoneCode)
                                    <option value="{{ $phoneCode['phone_code'] }}"
                                            data-code="{{ $phoneCode['code'] }}"
                                            data-phone="{{ $phoneCode['phone_code'] }}"
                                            data-label="{{ ($phoneCode['label_fr'] ?? $phoneCode['label_en'] ?? '') }} {{ $phoneCode['code'] }} {{ $phoneCode['phone_code'] }}">
                                        {{ $phoneCode['code'] }} {{ $phoneCode['phone_code'] }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInputGroup1" name="phone" required>
                                <label for="floatingInputGroup1">{{ __('dashboard.register.phone.title') }}</label>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-6">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="floatingPassword" name="password" required>
                            <label for="floatingPassword">{{ __('dashboard.register.password') }}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="floatingPassword" name="password_confirmation" required>
                            <label for="floatingPassword">{{ __('dashboard.register.confirm-pass') }}</label>
                        </div>
                    </div> --}}
                    <div class="col-md-12 my-5">
                        <div class="row myBtn">
                            <a type="button" class="btn col-md-4 secondary" href="{{ route('users.index') }}">{{ __('dashboard.register.btn.cancel') }}</a>
                            <button type="reset" class="btn col-md-4 danger">{{ __('dashboard.register.btn.reset') }}</button>
                            <button type="submit" class="btn col-md-4 success" id="validate">{{ __('dashboard.register.btn.confirm') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js_2')
    <script src="{{ asset('lib/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('lib/select2/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            function formatPhoneCode(option) {
                if (!option.id) return option.text; // placeholder

                const code = $(option.element).data('code') || '';
                const phone = $(option.element).data('phone') || '';
                const flag = $(option.element).data('flag') || '';

                return $(`
                    <div style="text-align: center;">
                        <div>
                            <span style="font-weight: bold; margin-right: 5px;">${code}</span>
                            <span style="font-size: 0.9em; color: #555;">${phone}</span>
                        </div>
                    </div>
                `);
            }
            function customMatcher(params, data) {
                if ($.trim(params.term) === '') return data;

                const term = params.term.toLowerCase();
                const label = $(data.element).data('label')?.toLowerCase() || '';

                if (label.indexOf(term) > -1) return data;
                return null;
            }

            $('#phone_code').select2({
                templateResult: formatPhoneCode,
                templateSelection: formatPhoneCode,
                escapeMarkup: m => m,
                matcher: customMatcher,
                minimumResultsForSearch: 0,
            });
        });
    </script>
@endsection

