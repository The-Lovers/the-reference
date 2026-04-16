<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $contactRequest->subject }}</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1f2937; line-height: 1.6;">
    <h2 style="margin-bottom: 16px;">Nouvelle demande de contact</h2>

    <p><strong>Nom :</strong> {{ $contactRequest->full_name }}</p>
    <p><strong>Téléphone :</strong> {{ $contactRequest->phone }}</p>
    <p><strong>Email :</strong> {{ $contactRequest->email ?: '-' }}</p>
    <p><strong>Objet :</strong> {{ $contactRequest->subject }}</p>
    <p><strong>Source :</strong> {{ $contactRequest->source_label ?: __('index.contain.form.direct-request') }}</p>

    <p style="margin-top: 20px;"><strong>Message :</strong></p>
    <div style="padding: 16px; background: #f3f4f6; border-radius: 8px; white-space: pre-line;">
        {{ $contactRequest->message }}
    </div>
</body>
</html>
