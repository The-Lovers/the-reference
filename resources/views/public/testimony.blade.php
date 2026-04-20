@extends('layouts.app')

@section('title', __('index.contain.testimony-page'))

@section('header')
    @include('layouts.guest.header')
@endsection

@section('content')
    <section class="container py-5 public-form-page">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-lg-5">
                        <span class="public-form-page__eyebrow">{{ __('index.contain.testimony-page') }}</span>
                        <h2 class="mb-2">{{ __('index.contain.testimony-form.title') }}</h2>
                        <p class="text-muted mb-4">{{ __('index.contain.testimony-form.subtitle') }}</p>

                        <form method="POST" action="{{ route('public.testimonies.store', ['locale' => app()->getLocale()]) }}" class="public-contact-form" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" name="name" placeholder="{{ __('forms.testimony.name') }}" value="{{ old('name') }}" required>
                                    @error('name')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="surname" placeholder="{{ __('forms.testimony.surname') }}" value="{{ old('surname') }}" required>
                                    @error('surname')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="number" min="1" max="5" name="note" placeholder="{{ __('forms.testimony.note') }}" value="{{ old('note') }}">
                                    @error('note')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="avatar" accept="image/png,image/jpeg,image/webp">
                                    @error('avatar')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-12">
                                    <input type="text" name="description" placeholder="{{ __('forms.testimony.description') }}" value="{{ old('description') }}">
                                    @error('description')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-12">
                                    <textarea name="message" rows="6" placeholder="{{ __('forms.testimony.message') }}" required>{{ old('message') }}</textarea>
                                    @error('message')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
                                    <a href="{{ route('public.contact.create', ['locale' => app()->getLocale()]) }}" class="btn btn-outline-dark rounded-pill">
                                        {{ __('index.contain.contact-page') }}
                                    </a>
                                    <button type="submit" class="btn rounded-pill px-4">{{ __('index.contain.testimony-form.submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    @include('layouts.guest.footer')
@endsection

@section('css')
    <style>
        a.btn{
            display: none !important;
        }
        header {
            max-height: 28rem !important;
        }
        .public-form-page__eyebrow {
            display: inline-block;
            margin-bottom: 1rem;
            padding: .35rem .8rem;
            border-radius: 999px;
            background: rgba(11,60,93,.08);
            color: #0b3c5d;
            font-weight: 700;
        }
        .public-contact-form input,
        .public-contact-form textarea,
        .public-contact-form button {
            width: 100%;
            border-radius: 14px;
            padding: .95rem 1rem;
        }
        .public-contact-form input,
        .public-contact-form textarea {
            border: 1px solid #d1d5db;
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease;
        }
        .public-contact-form input:focus,
        .public-contact-form textarea:focus {
            border-color: #0f766e;
            box-shadow: 0 0 0 4px rgba(15, 118, 110, .12);
        }
        .public-contact-form button {
            width: auto;
            border: none;
            background: #111827;
            color: #fff;
            font-weight: 700;
        }
    </style>
@endsection
