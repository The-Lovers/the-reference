<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupère la locale dans l'URL
        $locale = $request->route('locale');

        if (!in_array($locale, ['fr', 'en'])) {
            $locale = session('locale', 'fr');
        }

        // Applique la langue et stocke en session
        App::setLocale($locale);
        session(['locale' => $locale]);

        // Force Laravel à générer toutes les routes avec cette locale
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
