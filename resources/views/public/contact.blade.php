@extends('layouts.app')

@section('title', __('index.contain.contact-page'))

@section('header')
    @include('layouts.guest.header')
@endsection

@section('content')
    <section class="container py-5 public-form-page">
        <div class="row g-4 align-items-start">
            <div class="col-lg-5">
                <div class="card shadow-sm border-0 h-100 public-form-page__aside">
                    <div class="card-body p-4">
                        <span class="public-form-page__eyebrow">{{ __('index.contain.contact-page') }}</span>
                        <h2 class="mb-3">{{ __('index.contain.form.title') }}</h2>
                        <p class="text-muted mb-4">{{ __('index.contain.form.subtitle') }}</p>
                        <div class="public-form-page__info">
                            <p><strong>{{ __('index.contain.contact-card.phone') }}</strong><br>653 476 952</p>
                            <p><strong>{{ __('index.contain.contact-card.address') }}</strong><br>{{ __('index.contain.contact-card.address-value') }}</p>
                            <p class="mb-0">
                                <a href="{{ route('public.testimonies.create', ['locale' => app()->getLocale()]) }}" class="btn btn-outline-dark rounded-pill">
                                    {{ __('index.contain.testimony-page') }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-lg-5">
                        <form method="POST" action="{{ route('public.contact.store', ['locale' => app()->getLocale()]) }}" class="public-contact-form">
                            @csrf

                            <input type="hidden" name="contactable_alias" value="{{ old('contactable_alias', $contactContext['alias'] ?? null) }}">
                            <input type="hidden" name="contactable_id" value="{{ old('contactable_id', $contactContext['model']?->getKey()) }}">

                            @if (!empty($contactContext['label']))
                                <div class="contact-context-banner mb-3">
                                    <span>{{ __('index.contain.form.context_hint') }} <strong>{{ $contactContext['label'] }}</strong></span>
                                </div>
                            @endif

                            <input type="text" name="full_name" placeholder="{{ __('index.contain.form.full_name') }}" value="{{ old('full_name') }}" required>
                            @error('full_name')<small class="text-danger d-block mb-2">{{ $message }}</small>@enderror

                            <input type="tel" name="phone" placeholder="{{ __('index.contain.form.phone') }}" value="{{ old('phone') }}" required>
                            @error('phone')<small class="text-danger d-block mb-2">{{ $message }}</small>@enderror

                            <input type="email" name="email" placeholder="{{ __('index.contain.form.email') }}" value="{{ old('email') }}">
                            @error('email')<small class="text-danger d-block mb-2">{{ $message }}</small>@enderror

                            <input type="text" name="subject" placeholder="{{ __('index.contain.form.subject') }}" value="{{ old('subject', $prefilledSubject) }}" required>
                            @error('subject')<small class="text-danger d-block mb-2">{{ $message }}</small>@enderror

                            <textarea name="message" rows="6" placeholder="{{ __('index.contain.form.message') }}" required>{{ old('message') }}</textarea>
                            @error('message')<small class="text-danger d-block mb-2">{{ $message }}</small>@enderror

                            <button type="submit">{{ __('index.contain.request-submit') }}</button>
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
        .public-form-page__aside {
            background: linear-gradient(155deg, #0b3c5d, #114e79);
            color: #fff;
            border-radius: 28px;
        }
        .public-form-page__eyebrow {
            display: inline-block;
            margin-bottom: 1rem;
            padding: .35rem .8rem;
            border-radius: 999px;
            background: rgba(255,255,255,.16);
            font-weight: 700;
        }
        .public-form-page__info p { margin-bottom: 1.25rem; }
        .public-contact-form { display: grid; gap: .9rem; }
        .public-contact-form input,
        .public-contact-form textarea {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 14px;
            padding: .95rem 1rem;
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease;
        }
        .public-contact-form input:focus,
        .public-contact-form textarea:focus {
            border-color: #0f766e;
            box-shadow: 0 0 0 4px rgba(15, 118, 110, .12);
        }
        .public-contact-form button {
            border: none;
            border-radius: 999px;
            padding: .95rem 1.2rem;
            background: #111827;
            color: #fff;
            font-weight: 700;
        }
        .contact-context-banner {
            padding: .85rem 1rem;
            border-radius: 12px;
            background: #ecfeff;
            color: #155e75;
        }
    </style>
@endsection
