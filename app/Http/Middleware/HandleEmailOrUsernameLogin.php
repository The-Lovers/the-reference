<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class HandleEmailOrUsernameLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Appliquer seulement sur la route POST login
        if ($request->is('login') && $request->isMethod('POST')) {
            $identifier = $request->input('email');

            if ($identifier) {
                // Vérifier si c'est un email
                if (!filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
                    // C'est probablement un username, chercher l'email correspondant
                    $user = User::where('username', $identifier)->first();

                    if ($user) {
                        // Remplacer le champ 'email' par l'email réel
                        $request->merge(['email' => $user->email]);
                    }
                }
            }
        }

        return $next($request);
    }
}
