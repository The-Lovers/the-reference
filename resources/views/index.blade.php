@extends('layouts.app')

@section('title', 'La Référence | Vous servir, une obligation')

@section('header')
    @include('layouts.guest.header')
@endsection

@section('content')

<div id="lightbox" style="display:none">
    <div class="modal">
        <span onclick="closeBox()">&times;</span>

        <h3>Demande d'information</h3>

        @if(session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{ route('contact') }}">
            @csrf

            <input type="text" name="nom" placeholder="Nom complet" required>
            <input type="tel" name="telephone" placeholder="Téléphone / WhatsApp" required>
            <input type="email" name="email" placeholder="Adresse email">

            <select name="demande">
                <option>Études à l'étranger</option>
                <option>Bourses internationales</option>
                <option>Visa / Voyage</option>
                <option>Services administratifs</option>
                <option>Autre demande</option>
            </select>

            <button type="submit">Envoyer la demande</button>
        </form>
    </div>
</div>
    <section class="container-fluid" >
        <div id="missions" class="container">
            <h2>{{ __('index.contain.missions') }}</h2>
            <div class="swiper-container-wrapper">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper grid">

                        <div class="swiper-slide">
                            <div class="card image-card">
                                <img src="{{ asset('images/content/01.jpeg') }}" alt="Étudiants africains à l'international">
                                <span class="second">
                                    <i class="fa-solid fa-graduation-cap icon"></i>
                                </span>
                                <p>Depuis près de <span class="highlight">4 ans</span>, La Référence accompagne la jeunesse africaine vers des <strong>opportunités académiques, professionnelles et internationales sûres</strong>.</p>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="card image-card">
                                <img src="{{ asset('images/content/02.jpeg') }}" alt="Étudiants africains à l'international">
                                <span class="second">
                                    <i class="fa-solid fa-plane-departure icon"></i>
                                </span>
                                <ul>
                                    <li>✔ Orientation stratégique et réaliste</li>
                                    <li>✔ Constitution de dossiers solides</li>
                                    <li>✔ Suivi administratif et visa</li>
                                    <li>✔ Sécurisation des démarches</li>
                                </ul>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="card image-card">
                                <img src="{{ asset('images/content/03.jpeg') }}" alt="Étudiants africains à l'international">
                                <span class="second">
                                    <i class="fa-solid fa-earth-africa icon"></i>
                                </span>
                                <p>France, Belgique, Russie, Biélorussie, Chine, Sénégal et bien d'autres destinations accessibles avec un accompagnement professionnel.</p>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="card image-card">
                                <img src="{{ asset('images/content/01.jpeg') }}" alt="Étudiants africains à l'international">
                                <span class="second">
                                    <i class="fa-solid fa-computer icon"></i>
                                </span>
                                <p>Depuis près de <span class="highlight">4 ans</span>, La Référence accompagne la jeunesse africaine vers des <strong>opportunités académiques, professionnelles et internationales sûres</strong>.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Flèches -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
        <div id="domains" class="container">
            <h2>{{ __('index.contain.domains') }}</h2>
            <div class="gride">
                <div class="card image-card">
                    <img src="{{ asset('images/content/11.jpeg') }}" alt="Solutions numériques">
                    <span class="second">
                        <i class="fa-solid fa-laptop-code icon"></i>
                        <strong>Solutions numériques & TIC</strong><br>
                    </span>
                    Sites web professionnels, applications, vidéos institutionnelles, infographie et publicité digitale.
                </div>
                <div class="card image-card">
                    <img src="{{ asset('images/content/12.jpeg') }}" alt="Services administratifs">
                    <span class="second">
                        <i class="fa-solid fa-file-signature icon"></i>
                        <strong>Services administratifs</strong><br>
                    </span>
                    CV professionnels, passeport, NIU, CNPS, certificats, accompagnement administratif complet.
                </div>
                <div class="card image-card">
                    <img src="{{ asset('images/content/13.jpeg') }}" alt="Bourses et études">
                    <span class="second">
                        <i class="fa-solid fa-user-graduate icon"></i>
                        <strong>Études, bourses & tests</strong><br>
                    </span>
                    Campus France, équivalence Belgique, TCF, TEF, bourses internationales.
                </div>
                <div class="card image-card">
                    <img src="{{ asset('images/content/11.jpeg') }}" alt="Maintenance informatique">
                    <span class="second">
                        <i class="fa-solid fa-screwdriver-wrench icon"></i>
                        <strong>Maintenance</strong><br>
                    </span>
                    Maintenance logicielle et matérielle PC, Android et iOS.
                </div>
            </div>
        </div>
        <div id="avis">
            <h2>{{ __('index.contain.testimonies') }}</h2>
            <div class="gride">
                <div class="card">
                    <img src="{{ asset('images/content/pp01.jpeg') }}" alt="Étudiant africain">
                    ⭐⭐⭐⭐⭐<br>
                    <strong>Junior N.</strong><br>
                    <em>Admission – Belgique</em>
                    <p>Grâce à La Référence, mon dossier a été accepté rapidement. J’ai été accompagné jusqu’à l’obtention de mon admission.</p>
                </div>
                <div class="card">
                    <img src="{{ asset('images/content/pp02.jpeg') }}" alt="Étudiante africaine">
                    ⭐⭐⭐⭐⭐<br>
                    <strong>Aïcha M.</strong><br>
                    <em>Visa étudiant – France</em>
                    <p>Un accompagnement sérieux et rassurant. Chaque étape m’a été expliquée clairement jusqu’à mon départ.</p>
                </div>
                <div class="card">
                    <img src="{{ asset('images/content/pp03.jpeg') }}" alt="Jeune professionnel africain">
                    ⭐⭐⭐⭐⭐<br>
                    <strong>Samuel K.</strong><br>
                    <em>Bourse & études – Russie</em>
                    <p>Structure professionnelle et transparente. Je recommande La Référence à tous ceux qui veulent étudier à l’étranger.</p>
                </div>
            </div>
        </div>

        <div id="contact" class="container">
            <h2>Contact & Localisation</h2>
            <div class="gride">
                <div class="card">
                    📞 <strong>Téléphone / WhatsApp</strong><br>653 476 952<br><br>
                    📍 <strong>Adresse</strong><br>Efoulan – Sous-préfecture
                </div>
                <div class="card">
                    <h3>🔥 Offres promotionnelles</h3>
                    <p>Étude de dossier voyage à tarif réduit<br>Création de sites web événementiels<br>Vidéos promotionnelles</p>
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
        new Swiper('.mySwiper', {
            loop: true,

            slidesPerView: 3,
            spaceBetween: 30,
            roundLengths: true,

            speed: 900,

            autoplay: {
                delay: 2500,
                disableOnInteraction: false, // 🔥 clé
                pauseOnMouseEnter: true     // 🔥 clé
            },

            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            breakpoints: {
                0: { slidesPerView: 1, spaceBetween: 0 },
                768: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 3, spaceBetween: 30 }
            }
        });
    </script>
@endsection
