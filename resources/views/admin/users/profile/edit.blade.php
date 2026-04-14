@extends('layouts.admin.app')

@section('css_2')
    <link rel="stylesheet" href="{{ asset('css/user/edit.css') }}">
@endsection

@section('breadcrumb')
    <x-breadcrumb
        title="{{ __('dashboard.header.setting') }}"
        :items="[
            ['label' => __('dashboard.header.setting')]
        ]"
    />
@endsection

@section('content_2')
    <div class="main-content">
        <div class="container">
            <h2 class="title">
                {{ __('dashboard.header.setting') }}
            </h2>
        </div>
        <form action="{{ route('profile.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-4 text-center">
                        <img
                            id="avatarPreview"
                            src="{{ $user->avatar ? asset($user->avatar) : asset('images/logo.png') }}"
                            alt="{{ $user->name }}"
                            class="img-fluid rounded-circle border"
                            style="width: 140px; height: 140px; object-fit: cover;"
                        >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        <label for="name">{{ __('dashboard.register.name') }}</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="surname" name="surname" value="{{ old('surname', $user->surname) }}" required>
                        <label for="surname">{{ __('dashboard.register.surname') }}</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                        <label for="username">{{ __('dashboard.register.username') }}</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        <label for="email">{{ __('dashboard.register.email') }}</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="gender" aria-label="{{ __('dashboard.register.gender.title') }}" name="gender" required>
                            <option value="M" {{ strtolower(old('gender', $user->gender ?? '')) === 'm' ? 'selected' : '' }}>
                                {{ __('dashboard.register.gender.m') }}
                            </option>
                            <option value="F" {{ strtolower(old('gender', $user->gender ?? '')) === 'f' ? 'selected' : '' }}>
                                {{ __('dashboard.register.gender.f') }}
                            </option>
                        </select>
                        <label for="gender">{{ __('dashboard.register.gender.title') }}</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="role" value="{{ optional($user->roles->first())->name ?? '-' }}" readonly>
                        <label for="role">{{ __('dashboard.register.role.title') }}</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Avatar</label>
                        <input type="file" class="form-control" id="avatar" name="avatar" accept="image/png,image/jpeg,image/webp">
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
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $phoneNumber) }}" required>
                            <label for="phone">{{ __('dashboard.register.phone.title') }}</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 my-5">
                    <div class="row myBtn">
                        <a type="button" class="btn col-md-4 secondary" href="{{ route('profile.show', $user) }}">{{ __('buttons.cancel') }}</a>
                        <button type="submit" class="btn col-md-4 success" id="validate">{{ __('buttons.confirm') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('js_2')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const avatarInput = document.getElementById('avatar');
            const avatarPreview = document.getElementById('avatarPreview');

            avatarInput?.addEventListener('change', function (event) {
                const [file] = event.target.files || [];

                if (!file) {
                    return;
                }

                avatarPreview.src = URL.createObjectURL(file);
            });
        });
    </script>
@endsection
