<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Repositories\RoleRepository;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use App\Http\Responses\LoginResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(\Laravel\Fortify\Contracts\LoginResponse::class, LoginResponse::class);

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });
            Fortify::registerView(function () {
                $roleRepo = app(\App\Repositories\RoleRepository::class);
                $roles = $roleRepo ? $roleRepo->getAll() : collect();

                // Récupérer les indicatifs depuis la base via PhoneCodeRepository
                $phoneCodes = [];
                try {
                    $phoneRepo = app(\App\Repositories\PhoneCodeRepository::class);
                    if ($phoneRepo) {
                        $codes = $phoneRepo->getAll();
                        foreach ($codes as $c) {
                            $key = $c->phone_code ?? ($c['phone_code'] ?? null);
                            if ($key) {
                                $label = ($c->label_fr ?? $c['label_en'] ?? $c->code ?? $c['code'] ?? $key) . ' ' . $key;
                                $phoneCodes[$key] = $label;
                            }
                        }
                    }
                } catch (\Throwable $e) {
                    // fallback: charger depuis le JSON si la table n'existe pas
                    $path = base_path('database/data/countries_195_un.json');
                    if (file_exists($path)) {
                        $json = json_decode(file_get_contents($path), true);
                        if (is_array($json)) {
                            foreach ($json as $c) {
                                if (!empty($c['phone_code'])) {
                                    $k = $c['phone_code'];
                                    $label = ($c['label_fr'] ?? $c['label_en'] ?? $c['code']) . ' ' . $k;
                                    $phoneCodes[$k] = $label;
                                }
                            }
                        }
                    }
                }

                return view('admin.users.create', compact('roles', 'phoneCodes'));
            });
    }
}
