<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Compte créé sur {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>body{font-family:Arial, sans-serif;line-height:1.6;color:#333}</style>
</head>
<body>
    <h2>Bonjour {{ $user->surname }} {{ $user->name }},</h2>

    <p>Nous avons le plaisir de vous informer que votre compte sur la plateforme <strong>{{ config('app.name') }}</strong> a été créé avec succès.</p>

    <p><strong>Vos informations de connexion :</strong></p>
    <ul>
        <li>Nom d’utilisateur : <strong>{{ $user->username }}</strong></li>
        <li>Email : <strong>{{ $user->email }}</strong></li>
        <li>Mot de passe : <strong>{{ $password }}</strong></li>
    </ul>

    <p>
        <a href="{{ route('login') }}" style="color:#fff;background:#0b3c5d;padding:10px 15px;text-decoration:none;border-radius:5px;">
            Se connecter à {{ config('app.name') }}
        </a>
    </p>

    <p>Pour des raisons de sécurité, nous vous recommandons de changer votre mot de passe dès votre première connexion.</p>

    <p>Si vous avez des questions ou rencontrez des problèmes pour vous connecter, n’hésitez pas à contacter notre support à <a href="mailto:support@votre-plateforme.com">support@votre-plateforme.com</a>.</p>

    <p>Bienvenue sur <strong>{{ config('app.name') }}</strong> et bonne navigation !</p>

    <p>Cordialement,<br>L’équipe {{ config('app.name') }}</p>
</body>
</html>
