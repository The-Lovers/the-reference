<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Fortify;

class AuthenticateUser
{
    /**
     * Tentative d'authentifier l'utilisateur par email ou username.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @return mixed
     */
    public function __invoke(StatefulGuard $guard): mixed
    {
        return tap(new AttemptToAuthenticate, function ($action) use ($guard) {
            $this->ensureLoginIsNotThrottled();

            // Récupérer l'identifiant (email ou username)
            $credentials = request()->only('email', 'password');

            // Vérifier si l'input fourni est un email OU un username
            $identifier = $credentials['email'] ?? '';
            $password = $credentials['password'] ?? '';

            // Chercher d'abord par email
            $user = User::where('email', $identifier)->first();

            // Si pas trouvé par email, chercher par username
            if (!$user) {
                $user = User::where('username', $identifier)->first();
            }

            // Si l'utilisateur n'existe pas
            if (!$user) {
                $this->throwFailedAuthenticationException();
            }

            // Vérifier le mot de passe
            if (!\Illuminate\Support\Facades\Hash::check($password, $user->password)) {
                $this->throwFailedAuthenticationException();
            }

            // Authentifier l'utilisateur
            $guard->login($user);
        });
    }

    /**
     * Vérifier que le login n'est pas throttlé.
     */
    protected function ensureLoginIsNotThrottled(): void
    {
        if ($this->isThrottled()) {
            $this->throwThrottleRequestsException();
        }
    }

    /**
     * Vérifier si les tentatives de login sont throttlées.
     */
    protected function isThrottled(): bool
    {
        return \Illuminate\Support\Facades\RateLimiter::tooManyAttempts(
            $this->throttleKey(),
            5 // Max 5 tentatives
        );
    }

    /**
     * Clé pour le throttling.
     */
    protected function throttleKey(): string
    {
        return \Illuminate\Support\Str::transliterate(
            \Illuminate\Support\Str::lower(request()->input('email')) . '|' . request()->ip()
        );
    }

    /**
     * Lancer une exception d'authentification échouée.
     */
    protected function throwFailedAuthenticationException(): void
    {
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ])->status(422);
    }

    /**
     * Lancer une exception de throttling.
     */
    protected function throwThrottleRequestsException(): void
    {
        throw ValidationException::withMessages([
            'email' => [trans('auth.throttle', ['seconds' => \Illuminate\Support\Facades\RateLimiter::availableIn($this->throttleKey())])],
        ])->status(429);
    }
}
