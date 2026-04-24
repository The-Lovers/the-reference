@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ sec_asset('css/user/edit.css') }}">
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
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" name="name" value="{{ $user->name }}" readonly>
                        <label for="floatingInput">{{ __('dashboard.register.name') }}</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" name="surname"  value="{{ $user->surname }}" readonly>
                        <label for="floatingInput">{{ __('dashboard.register.surname') }}</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" name="username"  value="{{ $user->username }}" readonly>
                        <label for="floatingInput">{{ __('dashboard.register.username') }}</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" name="email"  value="{{ $user->email }}" readonly>
                        <label for="floatingInput">{{ __('dashboard.register.email') }}</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="floatingSelect" aria-label="{{ __('dashboard.register.gender.title') }}" name="gender" required>
                            <option value="M" {{ strtolower(old('gender', $user->gender ?? '')) === 'm' ? 'selected' : '' }}>
                                {{ __('dashboard.register.gender.m') }}
                            </option>
                            <option value="F" {{ strtolower(old('gender', $user->gender ?? '')) === 'f' ? 'selected' : '' }}>
                                {{ __('dashboard.register.gender.f') }}
                            </option>
                        </select>
                        <label for="floatingSelect">{{ __('dashboard.register.gender.title') }}</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="floatingSelect" aria-label="{{ __('dashboard.register.gender.title') }}" name="role" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ (string) old('role', $user->roles->first()?->id) === (string) $role->id ? 'selected' : '' }}>
                                    {{ __("user.roles.{$role->name}") !== "user.roles.{$role->name}" ? __("user.roles.{$role->name}") : $role->name }}
                                </option>
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
                                    {{ old('code', $selectedCode) === $phoneCode['phone_code'] ? 'selected' : '' }}>
                                    {{ $phoneCode['code'] }} {{ $phoneCode['phone_code'] }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingInputGroup1" name="phone" value="{{ old('phone', $phoneNumber) }}">
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
                    <div class="buttons">
                        <a type="button" class="btn secondary" href="{{ route('users.index') }}">{{ __('buttons.cancel') }}</a>
                        {{-- <button type="reset" class="btn col-md-4 danger d-none">{{ __('buttons.reset') }}</button> --}}
                        <button type="submit" class="btn success" id="validate">{{ __('buttons.confirm') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
