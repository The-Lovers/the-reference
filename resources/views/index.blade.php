@extends('layouts.app')

@section('title', 'La Référence | Vous servir, une obligation')

@section('header')
    @include('layouts.guest.header')
@endsection

@section('content')

<div id="lightbox" style="display:none">
    <div class="modal">
        <span onclick="closeBox()">&times;</span>

        <h3>{{ __('index.contain.request-title') }}</h3>

        @if(session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{ route('contact') }}">
            @csrf

            <input type="text" name="nom" placeholder="Nom complet" required>
            <input type="tel" name="telephone" placeholder="Téléphone / WhatsApp" required>
            <input type="email" name="email" placeholder="Adresse email">

            <select name="demande">
                <option>{{ __('index.contain.requests.study-abroad') }}</option>
                <option>{{ __('index.contain.requests.scholarships') }}</option>
                <option>{{ __('index.contain.requests.visa-travel') }}</option>
                <option>{{ __('index.contain.requests.admin-services') }}</option>
                <option>{{ __('index.contain.requests.other') }}</option>
            </select>

            <button type="submit">{{ __('index.contain.request-submit') }}</button>
        </form>
    </div>
</div>
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
                <div class="card">
                    <h3>🔥 {{ __('index.contain.promotions.title') }}</h3>
                    <p>{{ __('index.contain.promotions.line-1') }}<br>{{ __('index.contain.promotions.line-2') }}<br>{{ __('index.contain.promotions.line-3') }}</p>
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
    </script>
@endsection
