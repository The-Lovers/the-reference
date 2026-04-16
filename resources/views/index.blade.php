@extends('layouts.app')

@section('title', 'La Référence | Vous servir, une obligation')

@section('header')
    @include('layouts.guest.header')
@endsection

@section('content')
    <section class="container-fluid" >
        @if ($services->isNotEmpty() || $destinations->isNotEmpty())
            <div id="services-destinations" class="container">
                <h2>{{ __('index.contain.services-destinations') }}</h2>
                <div class="gride">
                    @foreach ($services as $service)
                        <div class="card image-card service-destination-card">
                            @if ($service->is_featured)
                                <span class="featured-badge">{{ __('index.contain.featured') }}</span>
                            @endif
                            <span class="second">
                                <i class="fa-solid fa-briefcase icon"></i>
                                <strong>{{ $service->title }}</strong>
                            </span>
                            <p>{!! $service->description !!}</p>
                            <button
                                type="button"
                                class="contact-trigger-btn"
                                data-contact-alias="service"
                                data-contact-id="{{ $service->id }}"
                                data-contact-subject="{{ $service->title }}"
                            >
                                {{ __('index.contain.form.contact_us') }}
                            </button>
                        </div>
                    @endforeach
                    @foreach ($destinations as $destination)
                        <div class="card image-card service-destination-card">
                            <span class="second">
                                <i class="fa-solid fa-location-dot icon"></i>
                                <strong>{{ $destination->label }}</strong>
                            </span>
                            @if (data_get($destination, 'pays.label_fr') || data_get($destination, 'pays.label_en'))
                                <p class="service-destination-meta">
                                    {{ data_get($destination, 'pays.label_fr') ?? data_get($destination, 'pays.label_en') }}
                                </p>
                            @endif
                            <p>{!! $destination->description !!}</p>
                            <button
                                type="button"
                                class="contact-trigger-btn"
                                data-contact-alias="destination"
                                data-contact-id="{{ $destination->id }}"
                                data-contact-subject="{{ $destination->label }}"
                            >
                                {{ __('index.contain.form.contact_us') }}
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($missions->isNotEmpty())
        <div id="missions" class="container">
            <h2>{{ __('index.contain.missions') }}</h2>
            <div class="swiper-container-wrapper">
                <div class="swiper mySwiperMissions">
                    <div class="swiper-wrapper grid">
                        @forelse ($missions as $mission)
                            <div class="swiper-slide">
                                <div class="card image-card">
                                    @if ($mission->is_featured)
                                        <span class="featured-badge">{{ __('index.contain.featured') }}</span>
                                    @endif
                                    <img src="{{ sec_asset($mission->cover) }}" alt="Étudiants africains à l'international">
                                    <span class="second">
                                        <i class="{{ $mission->icon }} icon"></i>
                                    </span>
                                    <p>{!! $mission->description !!}</p>
                                    <button
                                        type="button"
                                        class="contact-trigger-btn"
                                        data-contact-alias="mission"
                                        data-contact-id="{{ $mission->id }}"
                                        data-contact-subject="{{ $mission->title }}"
                                    >
                                        {{ __('index.contain.form.contact_us') }}
                                    </button>
                                </div>
                            </div>
                        @empty
                            <p class="text-center"></p>
                        @endforelse
                    </div>
                </div>
                <div class="swiper-button-next missions-next"></div>
                <div class="swiper-button-prev missions-prev"></div>
            </div>
        </div>
        @endif

        @if ($domains->isNotEmpty())
        <div id="domains" class="container">
            <h2>{{ __('index.contain.domains') }}</h2>
            <div class="swiper-container-wrapper">
                <div class="swiper mySwiperDomains">
                    <div class="swiper-wrapper grid">
                        @forelse ($domains as $domain)
                            <div class="swiper-slide">
                                <div class="card image-card">
                                    @if ($domain->is_featured)
                                        <span class="featured-badge">{{ __('index.contain.featured') }}</span>
                                    @endif
                                    <img src="{{ sec_asset($domain->cover) }}" alt="{{ $domain->title }}">
                                    <span class="second">
                                        <i class="{{ $domain->icon }} icon"></i>
                                        <strong>{{ $domain->title }}</strong>
                                    </span>
                                    <p>{!! $domain->description !!}</p>
                                    <button
                                        type="button"
                                        class="contact-trigger-btn"
                                        data-contact-alias="domain"
                                        data-contact-id="{{ $domain->id }}"
                                        data-contact-subject="{{ $domain->title }}"
                                    >
                                        {{ __('index.contain.form.contact_us') }}
                                    </button>
                                </div>
                            </div>
                        @empty
                            <p class="text-center"></p>
                        @endforelse
                    </div>
                </div>
                <div class="swiper-button-next domains-next"></div>
                <div class="swiper-button-prev domains-prev"></div>
            </div>
        </div>
        @endif

        @if ($testimonies->isNotEmpty())
        <div id="avis">
            <h2>{{ __('index.contain.testimonies') }}</h2>
            <div class="swiper-container-wrapper">
                <div class="swiper mySwiperTestimonies">
                    <div class="swiper-wrapper grid">
                        @forelse ($testimonies as $testimony)
                            <div class="swiper-slide">
                                <div class="card testimony-card">
                                    <img
                                        src="{{ $testimony->avatar ? sec_asset($testimony->avatar) : sec_asset('images/content/pp01.jpeg') }}"
                                        alt="{{ trim($testimony->name . ' ' . $testimony->surname) }}"
                                    >
                                    <span class="testimony-stars">
                                        {{ str_repeat('⭐', max(1, min(5, (int) ($testimony->note ?? 5)))) }}
                                    </span>
                                    <strong>{{ trim($testimony->name . ' ' . $testimony->surname) }}</strong><br>
                                    @if ($testimony->description)
                                        <em>{!! $testimony->description !!}</em>
                                    @endif
                                    <p>{{ $testimony->message }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center"></p>
                        @endforelse
                    </div>
                </div>
                <div class="swiper-button-next testimonies-next"></div>
                <div class="swiper-button-prev testimonies-prev"></div>
            </div>
        </div>
        @endif

        <div id="contact" class="container">
            <h2>{{ __('index.contain.contact') }}</h2>
            <div class="gride">
                <div class="card">
                    📞 <strong>{{ __('index.contain.contact-card.phone') }}</strong><br>653 476 952<br><br>
                    📍 <strong>{{ __('index.contain.contact-card.address') }}</strong><br>{{ __('index.contain.contact-card.address-value') }}
                </div>
                <div class="card contact-form-card" id="contact-form">
                    <h3>{{ __('index.contain.request-title') }}</h3>
                    <p class="contact-form-intro">{{ __('index.contain.form.subtitle') }}</p>

                    <form method="POST" action="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="public-contact-form">
                        @csrf

                        <input type="hidden" name="contactable_alias" id="contactable_alias" value="{{ old('contactable_alias') }}">
                        <input type="hidden" name="contactable_id" id="contactable_id" value="{{ old('contactable_id') }}">

                        <input
                            type="text"
                            name="full_name"
                            placeholder="{{ __('index.contain.form.full_name') }}"
                            value="{{ old('full_name') }}"
                            required
                        >
                        @error('full_name')
                            <small class="text-danger d-block mb-2">{{ $message }}</small>
                        @enderror

                        <input
                            type="tel"
                            name="phone"
                            placeholder="{{ __('index.contain.form.phone') }}"
                            value="{{ old('phone') }}"
                            required
                        >
                        @error('phone')
                            <small class="text-danger d-block mb-2">{{ $message }}</small>
                        @enderror

                        <input
                            type="email"
                            name="email"
                            placeholder="{{ __('index.contain.form.email') }}"
                            value="{{ old('email') }}"
                        >
                        @error('email')
                            <small class="text-danger d-block mb-2">{{ $message }}</small>
                        @enderror

                        <div id="contact-context-banner" class="contact-context-banner d-none">
                            <span>{{ __('index.contain.form.context_hint') }}</span>
                            <button type="button" id="contact-context-reset" class="contact-context-reset">
                                {{ __('index.contain.form.reset_context') }}
                            </button>
                        </div>

                        <input
                            type="text"
                            name="subject"
                            id="contact-subject"
                            placeholder="{{ __('index.contain.form.subject') }}"
                            value="{{ old('subject') }}"
                            required
                        >
                        @error('subject')
                            <small class="text-danger d-block mb-2">{{ $message }}</small>
                        @enderror

                        <textarea
                            name="message"
                            rows="5"
                            placeholder="{{ __('index.contain.form.message') }}"
                            required
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <small class="text-danger d-block mb-2">{{ $message }}</small>
                        @enderror

                        <button type="submit">{{ __('index.contain.request-submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('footer')
    @include('layouts.guest.footer')
@endsection

@section('js')
    <script>
        const missionLikeOptions = {
            loop: true,
            slidesPerView: 3,
            spaceBetween: 30,
            roundLengths: true,
            speed: 900,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },
            breakpoints: {
                0: { slidesPerView: 1, spaceBetween: 0 },
                768: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 3, spaceBetween: 30 }
            }
        };

        new Swiper('.mySwiperMissions', {
            ...missionLikeOptions,
            navigation: {
                nextEl: '#missions .missions-next',
                prevEl: '#missions .missions-prev',
            }
        });

        new Swiper('.mySwiperDomains', {
            loop: true,
            slidesPerView: 4,
            spaceBetween: 24,
            roundLengths: true,
            speed: 900,
            autoplay: {
                delay: 2600,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },
            navigation: {
                nextEl: '#domains .domains-next',
                prevEl: '#domains .domains-prev',
            },
            breakpoints: {
                0: { slidesPerView: 1, spaceBetween: 0 },
                768: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 4, spaceBetween: 24 }
            }
        });

        new Swiper('.mySwiperTestimonies', {
            ...missionLikeOptions,
            navigation: {
                nextEl: '#avis .testimonies-next',
                prevEl: '#avis .testimonies-prev',
            }
        });

        document.querySelectorAll('.contact-trigger-btn').forEach((button) => {
            button.addEventListener('click', function () {
                const subject = this.dataset.contactSubject || '';
                const alias = this.dataset.contactAlias || '';
                const id = this.dataset.contactId || '';
                const formCard = document.getElementById('contact-form');
                applyContactContext({ subject, alias, id });

                formCard?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                formCard?.classList.add('contact-form-highlight');

                setTimeout(() => {
                    formCard?.classList.remove('contact-form-highlight');
                }, 1800);
            });
        });

        const subjectInput = document.getElementById('contact-subject');
        const aliasInput = document.getElementById('contactable_alias');
        const idInput = document.getElementById('contactable_id');
        const contextBanner = document.getElementById('contact-context-banner');
        const contextReset = document.getElementById('contact-context-reset');

        function updateContactContextUI() {
            const hasContext = Boolean(aliasInput?.value && idInput?.value);

            if (subjectInput) {
                subjectInput.readOnly = hasContext;
            }

            contextBanner?.classList.toggle('d-none', !hasContext);
        }

        function applyContactContext({ subject = '', alias = '', id = '' }) {
            if (subjectInput) {
                subjectInput.value = subject;
            }

            if (aliasInput) {
                aliasInput.value = alias;
            }

            if (idInput) {
                idInput.value = id;
            }

            updateContactContextUI();
        }

        contextReset?.addEventListener('click', function () {
            applyContactContext({ subject: '', alias: '', id: '' });
            subjectInput?.focus();
        });

        updateContactContextUI();

        @if ($errors->any())
            document.getElementById('contact-form')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        @endif
    </script>

    <style>
        .contact-trigger-btn {
            position: fixed;
            bottom: 0;
            margin-left: -35px;
            width: 100%;
            height: 15%;
            border: none;
            border-radius: 0 0 20px 20px;
            padding: 0.85rem 1rem;
            background: rgba(245, 124, 0, 0.35);
            backdrop-filter: blur(18px) saturate(160%) brightness(1.1);
            -webkit-backdrop-filter: blur(18px) saturate(160%) brightness(1.1);
            color: #fff;
            font-weight: bold;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .contact-trigger-btn:hover {
            background: #0b3c5d;
            color: #f57c00;
        }

        .contact-form-card {
            width: 100%;
        }

        .contact-form-intro {
            margin-bottom: 1rem;
        }

        .public-contact-form {
            display: grid;
            gap: 0.9rem;
        }

        .contact-context-banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.85rem 1rem;
            border-radius: 12px;
            background: #ecfeff;
            color: #155e75;
            font-size: 0.95rem;
        }

        .contact-context-reset {
            border: none;
            background: transparent;
            color: #0f766e;
            font-weight: 700;
            padding: 0;
        }

        .public-contact-form input,
        .public-contact-form textarea {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 14px;
            padding: 0.95rem 1rem;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .public-contact-form input:focus,
        .public-contact-form textarea:focus {
            border-color: #0f766e;
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.12);
        }

        .public-contact-form button {
            border: none;
            border-radius: 999px;
            padding: 0.95rem 1.2rem;
            background: #111827;
            color: #fff;
            font-weight: 700;
        }

        .contact-form-highlight {
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.18);
        }
    </style>
@endsection
