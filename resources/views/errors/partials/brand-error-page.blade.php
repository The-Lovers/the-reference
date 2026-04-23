<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <link rel="shortcut icon" href="{{ sec_asset('images/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ sec_asset('lib/font-awesome-6.5.0/css/all.css') }}">
    <style>
        :root {
            --brand-navy: #072b3b;
            --brand-cyan: #08a4c9;
            --brand-sand: #f3efe7;
            --brand-ink: #14323e;
            --brand-soft: rgba(255, 255, 255, 0.78);
            --card-shadow: 0 30px 80px rgba(5, 21, 32, 0.24);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--brand-ink);
            background:
                radial-gradient(circle at top left, rgba(8, 164, 201, 0.32), transparent 35%),
                radial-gradient(circle at bottom right, rgba(7, 43, 59, 0.22), transparent 40%),
                linear-gradient(135deg, #f8faf7 0%, #eef5f3 44%, #dfeff2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 18px;
        }

        .shell {
            width: min(1080px, 100%);
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(280px, 0.8fr);
            background: rgba(255, 255, 255, 0.84);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(7, 43, 59, 0.08);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
        }

        .content {
            padding: 48px;
        }

        .hero {
            padding: 48px 40px;
            background: linear-gradient(180deg, rgba(7, 43, 59, 0.96) 0%, rgba(4, 79, 105, 0.94) 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .hero::before,
        .hero::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
        }

        .hero::before {
            width: 220px;
            height: 220px;
            top: -80px;
            right: -60px;
        }

        .hero::after {
            width: 160px;
            height: 160px;
            bottom: -50px;
            left: -35px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 30px;
            text-decoration: none;
            color: inherit;
        }

        .brand img {
            width: 58px;
            height: 58px;
            object-fit: contain;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.14);
            padding: 8px;
        }

        .brand span {
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(8, 164, 201, 0.12);
            color: var(--brand-cyan);
            font-size: 0.86rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .code {
            margin: 22px 0 6px;
            font-size: clamp(4.4rem, 11vw, 8rem);
            line-height: 0.95;
            font-weight: 800;
            color: var(--brand-navy);
        }

        .title {
            margin: 0;
            font-size: clamp(1.8rem, 4vw, 3rem);
            line-height: 1.08;
        }

        .message {
            margin: 18px 0 30px;
            max-width: 40rem;
            font-size: 1.05rem;
            line-height: 1.75;
            color: rgba(20, 50, 62, 0.85);
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .btn-primary,
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border-radius: 999px;
            padding: 14px 22px;
            font-weight: 700;
            text-decoration: none;
            transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
        }

        .btn-primary {
            color: white;
            background: linear-gradient(135deg, #0a7797 0%, #08a4c9 100%);
            box-shadow: 0 16px 35px rgba(8, 164, 201, 0.24);
        }

        .btn-secondary {
            color: var(--brand-ink);
            background: rgba(7, 43, 59, 0.06);
        }

        .btn-primary:hover,
        .btn-secondary:hover {
            transform: translateY(-2px);
        }

        .panel-label {
            margin: 0 0 18px;
            font-size: 0.85rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--brand-soft);
        }

        .panel-title {
            position: relative;
            margin: 0 0 16px;
            font-size: 2rem;
            line-height: 1.15;
        }

        .panel-copy {
            position: relative;
            margin: 0;
            color: rgba(255, 255, 255, 0.82);
            line-height: 1.8;
        }

        .panel-chip {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 28px;
            padding: 12px 16px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.08);
            color: white;
            font-weight: 600;
        }

        .hero-art {
            position: relative;
            z-index: 1;
            margin: 18px 0 30px;
        }

        .hero-art svg {
            width: 100%;
            max-width: 320px;
            height: auto;
            display: block;
            filter: drop-shadow(0 18px 26px rgba(2, 13, 20, 0.28));
        }

        @media (max-width: 880px) {
            .shell {
                grid-template-columns: 1fr;
            }

            .content,
            .hero {
                padding: 34px 24px;
            }

            .hero {
                min-height: 260px;
            }
        }
    </style>
</head>
<body>
    <main class="shell">
        <section class="content">
            <a class="brand" href="{{ route('index', ['locale' => app()->getLocale()]) }}">
                <img src="{{ sec_asset('images/logo.png') }}" alt="Logo">
                <span>{{ __('index.title') }}</span>
            </a>

            <div class="eyebrow">
                <i class="fa-solid {{ $icon }}"></i>
                <span>{{ $eyebrow }}</span>
            </div>

            <div class="code">{{ $code }}</div>
            <h1 class="title">{{ $heading }}</h1>
            <p class="message">{{ $message }}</p>

            <div class="actions">
                <a class="btn-primary" href="{{ route('index', ['locale' => app()->getLocale()]) }}">
                    <i class="fa-solid fa-house"></i>
                    <span>{{ $buttonLabel }}</span>
                </a>
                <a class="btn-secondary" href="{{ url()->previous() !== url()->current() ? url()->previous() : route('index', ['locale' => app()->getLocale()]) }}">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>{{ __('dashboard.header.back') }}</span>
                </a>
            </div>
        </section>

        <aside class="hero">
            <div>
                <p class="panel-label">{{ __('index.title') }}</p>
                <h2 class="panel-title">{{ $sideTitle }}</h2>
                <p class="panel-copy">{{ $sideMessage }}</p>
            </div>

            <div class="hero-art" aria-hidden="true">
                @if (($illustration ?? null) === 'access-denied')
                    <svg viewBox="0 0 320 300" xmlns="http://www.w3.org/2000/svg" role="img">
                        <circle cx="252" cy="52" r="18" fill="#ffcc7a"/>
                        <rect x="236" y="72" width="32" height="60" rx="14" fill="#ffd89a"/>
                        <path d="M214 122c10-18 22-27 38-27s28 9 38 27v70h-76z" fill="#0a8fb1"/>
                        <rect x="225" y="130" width="54" height="68" rx="18" fill="#0d6b88"/>
                        <path d="M228 84l24-16 24 16-8 14h-32z" fill="#163847"/>
                        <rect x="236" y="82" width="32" height="10" rx="5" fill="#0f2530"/>
                        <path d="M210 136c-12 10-23 23-31 40" fill="none" stroke="#ffd89a" stroke-width="16" stroke-linecap="round"/>
                        <path d="M176 175c-12-5-23-4-34 5" fill="none" stroke="#ffd89a" stroke-width="16" stroke-linecap="round"/>
                        <path d="M289 140c12 12 20 27 24 45" fill="none" stroke="#ffd89a" stroke-width="16" stroke-linecap="round"/>
                        <path d="M138 166c7-8 15-10 24-7 8 2 15 9 18 19-11 5-22 5-31 1-8-4-12-8-11-13z" fill="#ffd89a"/>
                        <circle cx="246" cy="56" r="3.5" fill="#183542"/>
                        <circle cx="259" cy="56" r="3.5" fill="#183542"/>
                        <path d="M246 66c5 4 10 4 15 0" fill="none" stroke="#b6654f" stroke-width="3" stroke-linecap="round"/>
                        <path d="M118 76c14-14 30-21 48-21 24 0 44 12 60 35" fill="none" stroke="rgba(255,255,255,0.16)" stroke-width="10" stroke-linecap="round"/>
                        <circle cx="100" cy="92" r="30" fill="#ff7f66"/>
                        <path d="M88 80l24 24M112 80l-24 24" stroke="#fff5f0" stroke-width="10" stroke-linecap="round"/>
                        <rect x="58" y="214" width="204" height="16" rx="8" fill="rgba(255,255,255,0.18)"/>
                        <path d="M235 198l-8 58" stroke="#163847" stroke-width="16" stroke-linecap="round"/>
                        <path d="M258 198l8 58" stroke="#163847" stroke-width="16" stroke-linecap="round"/>
                    </svg>
                @else
                    <svg viewBox="0 0 320 300" xmlns="http://www.w3.org/2000/svg" role="img">
                        <rect x="36" y="220" width="248" height="16" rx="8" fill="rgba(255,255,255,0.18)"/>
                        <path d="M76 216V92" stroke="#d8ecf2" stroke-width="10" stroke-linecap="round"/>
                        <path d="M76 102h52l-18 22 18 22H76" fill="#ffb048"/>
                        <path d="M76 156h64l-20 22 20 22H76" fill="#7ce0ff"/>
                        <path d="M210 84c18 0 33 15 33 33 0 25-33 52-33 52s-33-27-33-52c0-18 15-33 33-33z" fill="#08a4c9"/>
                        <circle cx="210" cy="117" r="12" fill="#f7fbfc"/>
                        <circle cx="210" cy="117" r="5" fill="#08a4c9"/>
                        <circle cx="208" cy="58" r="20" fill="#ffd08e"/>
                        <path d="M185 114c9-16 21-24 36-24 14 0 26 8 34 24v56h-70z" fill="#f28f3b"/>
                        <path d="M160 138c18 4 33 13 46 27" fill="none" stroke="#ffd08e" stroke-width="14" stroke-linecap="round"/>
                        <path d="M257 138c-12 13-19 27-21 44" fill="none" stroke="#ffd08e" stroke-width="14" stroke-linecap="round"/>
                        <path d="M184 142l-28 32" stroke="#ffd08e" stroke-width="14" stroke-linecap="round"/>
                        <path d="M164 172l42 9-9 42-42-9z" fill="#fff7df"/>
                        <path d="M171 181l18 3M168 193l22 4M166 205l20 4" stroke="#7d8e95" stroke-width="3" stroke-linecap="round"/>
                        <path d="M198 170l-10 58" stroke="#174454" stroke-width="16" stroke-linecap="round"/>
                        <path d="M223 170l18 56" stroke="#174454" stroke-width="16" stroke-linecap="round"/>
                        <path d="M193 65c6-10 15-15 27-15 11 0 20 5 26 15" fill="none" stroke="rgba(255,255,255,0.16)" stroke-width="10" stroke-linecap="round"/>
                    </svg>
                @endif
            </div>

            <div class="panel-chip">
                <i class="fa-solid fa-shield-heart"></i>
                <span>{{ $chipLabel }}</span>
            </div>
        </aside>
    </main>
</body>
</html>
