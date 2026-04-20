<?php

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\DomainController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\MissionController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TestimonyController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// ✅ ROUTE DE SWITCH ICI
Route::get('/lang/{lang}', function ($lang) {

    if (! in_array($lang, ['fr', 'en'])) {
        abort(404);
    }

    session(['locale' => $lang]);

    // Revenir à la page précédente, mais avec la nouvelle langue
    $previous = url()->previous();
    $parsed = parse_url($previous);
    $path = $parsed['path'] ?? '/';

    // Supprimer la locale actuelle du chemin
    $path = preg_replace('#^/(fr|en)#', '', $path);

    return redirect("/{$lang}{$path}");

})->name('lang.switch');
Route::get('/', function () {
    return redirect('/fr');
});
Route::group([
    'prefix' => '{locale?}',
    'where' => ['locale' => 'fr|en'],
    'middleware' => 'setlocale'
], function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/not-found', [HomeController::class, 'error_404'])->name('access_denied');
    Route::get('/contact', [HomeController::class, 'contactForm'])->name('public.contact.create');
    Route::post('/contact', [HomeController::class, 'contact'])->name('public.contact.store');
    Route::get('/temoignages/partager', [HomeController::class, 'testimonyForm'])->name('public.testimonies.create');
    Route::post('/temoignages/partager', [HomeController::class, 'storePublicTestimony'])->name('public.testimonies.store');

    Route::middleware(['auth', 'force.password.change'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
        Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::prefix('chat')->name('chat.')->group(function () {
            Route::get('/panel', [ChatController::class, 'index'])->name('panel');
            Route::get('/conversations/{user}', [ChatController::class, 'show'])->name('show');
            Route::post('/conversations/{user}', [ChatController::class, 'store'])->name('store');
        });
        Route::resource('users', UserController::class, [
            'description' => [
                'index' => __("desc.user.index"),
                'create' => __("desc.user.create"),
                'show' => __("desc.user.show"),
                'edit' => __("desc.user.edit"),
                'destroy' => __("desc.user.destroy")
            ]
        ]);
        Route::get('/profile/{user}/edit', [UserController::class, 'edit_profile'])->name('profile.edit');
        Route::patch('/profile/{user}/update', [UserController::class, 'update_profile'])->name('profile.update');
        Route::get('/profile/{user}/show', [UserController::class, 'show_profile'])->name('profile.show');
        // Routes pour les domaines
        Route::resource('domains', DomainController::class, [
            'description' => [
                'index' => __("desc.domain.index"),
                'create' => __("desc.domain.create"),
                'show' => __("desc.domain.show"),
                'edit' => __("desc.domain.edit"),
                'destroy' => __("desc.domain.destroy")
            ]
        ]);
        Route::patch('domains/{domain}/status/{value}', [DomainController::class, 'updateStatus'])
            ->name('domains.status');

        Route::patch('domains/{domain}/featured/{value}', [DomainController::class, 'updateFeatured'])
            ->name('domains.featured');
        // Routes pour les missions
        Route::resource('missions', MissionController::class, [
            'description' => [
                'index' => __("desc.mission.index"),
                'create' => __("desc.mission.create"),
                'show' => __("desc.mission.show"),
                'edit' => __("desc.mission.edit"),
                'destroy' => __("desc.mission.destroy")
            ]
        ]);
        Route::patch('missions/{mission}/status/{value}', [MissionController::class, 'updateStatus'])
            ->name('missions.status');

        Route::patch('missions/{mission}/featured/{value}', [MissionController::class, 'updateFeatured'])
            ->name('missions.featured');
        // Routes pour les services
        Route::resource('services', ServiceController::class, [
            'description' => [
                'index' => __("desc.service.index"),
                'create' => __("desc.service.create"),
                'show' => __("desc.service.show"),
                'edit' => __("desc.service.edit"),
                'destroy' => __("desc.service.destroy")
            ]
        ]);
        // Routes pour les destinations
        Route::resource('destinations', DestinationController::class, [
            'description' => [
                'index' => __("desc.destination.index"),
                'create' => __("desc.destination.create"),
                'show' => __("desc.destination.show"),
                'edit' => __("desc.destination.edit"),
                'destroy' => __("desc.destination.destroy")
            ]
        ]);
        // Routes pour les témoignages
        Route::resource('testimonies', TestimonyController::class, [
            'description' => [
                'index' => __("desc.testimony.index"),
                'create' => __("desc.testimony.create"),
                'show' => __("desc.testimony.show"),
                'edit' => __("desc.testimony.edit"),
                'destroy' => __("desc.testimony.destroy")
            ]
        ]);
    });
});
