<?php

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

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
    Route::post('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


