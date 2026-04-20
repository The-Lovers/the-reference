<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * @param  \Illuminate\Http\Request  $request
     */
    public function toResponse($request)
    {
        if ($request->wantsJson()) {
            return response()->json(['two_factor' => false]);
        }

        $locale = session('locale', app()->getLocale());

        if ($request->user()?->force_password_change) {
            return redirect()->route('profile.edit', [
                'locale' => $locale,
                'user' => $request->user(),
            ])->with('warning', __('forms.profile.force_password_change'));
        }

        return redirect()->intended(route('dashboard', ['locale' => $locale]));
    }
}
