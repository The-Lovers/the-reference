<!DOCTYPE html5>
<html>
<head>
    <meta charset="UTF-8">
    <title>Compte créé sur {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body style="width: auto; margin: auto; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 5%;">
    <div class="container">
        <div class="header" style="border: none; width: auto; text-align: center; border-radius: 2rem 2rem 0 0; color: #f9f9f9; background: #0b3c5d; display: flex; flex-direction: row; flex-wrap: nowrap; justify-content: space-between; align-items: center;">
            <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="max-width: 15rem; aspect-ratio: 16 / 9; height: auto;">
            <h1 style="text-transform: uppercase;">{!! __('config.email.new-user.welcome', ['title' => config('app.name')]) !!}</h1>
            <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="max-width: 15rem; aspect-ratio: 16 / 9; height: auto;">
        </div>
        <div class="content" style="border: none; width: auto; text-align: center;">
            {{-- <h2>Bonjour {{ $user->surname }} {{ $user->name }},</h2> --}}
            <h2 style="color: #0b3c5d; font-weight: bold; font-size: 2rem;">{!! __('config.email.new-user.hello', ['surname' => $user->surname, 'name' => $user->name]) !!}</h2>

            <p style="line-height: 1.5rem; font-size: 1.2rem;">
                {!! __('config.email.new-user.intro', ['title' => config('app.name')]) !!}
            </p>

            <p style="line-height: 1.5rem; font-size: 1.2rem;">
                {!! __('config.email.new-user.infos') !!}
            </p>
            <ul style="list-style-type: none !important;">
                <li>{!! __('config.email.new-user.username', ['username' => $user->username]) !!}</li>
                <li>{!! __('config.email.new-user.email', ['email' => $user->email]) !!}</li>
                <li>{!! __('config.email.new-user.password', ['password' => $password]) !!}</li>
            </ul>

            <p style="line-height: 1.5rem; font-size: 1.2rem;">
                <a href="{{ route('login') }}" class="btn" style="color: #f9f9f9; background: #0b3c5d; padding: 10px 15px; text-decoration: none; border-radius: 1.2rem; font-weight: bold;" onmouseover="this.style.background='#f57c00'; this.style.color='#1c1c1c';" onmouseout="this.style.background='#0b3c5d'; this.style.color='#f9f9f9';">
                    {!! __('config.email.new-user.button', ['title' => config('app.name')]) !!}
                </a>
            </p>

            <p style="line-height: 1.5rem; font-size: 1.2rem;">
                {!! __('config.email.new-user.warning') !!}
            </p>

            <p style="line-height: 1.5rem; font-size: 1.2rem;">
                {!! __('config.email.new-user.support', ['mail' => config('app.mail')]) !!}
            </p>

            <p style="line-height: 1.5rem; font-size: 1.2rem;">
                {!! __('config.email.new-user.salutaion', ['title' => config('app.name')]) !!}
            </p>
        </div>
        <div class="footer" style="border: none; width: auto; text-align: center; border-radius: 0 0 2rem 2rem; background: #0b3c5d; color: #f9f9f9; display: flex; flex-direction: row; flex-wrap: nowrap; justify-content: center; align-items: center;">
            <p style="line-height: 1.5rem; font-size: 1.2rem;">
                {!! __('config.email.new-user.copyright', ['title' => config('app.name')]) !!}<br>
                {!! __('config.email.new-user.localisation') !!}<br>
                {!! __('config.email.new-user.our-email', ['email' => "example@email.com"]) !!}<br>
                {!! __('config.email.new-user.address', ['phone' => "+237 6 xx xx xx xx"]) !!}
            </p>
        </div>
    </div>
    <script>
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>
</body>
</html>
