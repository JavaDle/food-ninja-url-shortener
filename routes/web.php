<?php

use App\Http\Controllers\Web\RedirectController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:web')->get('filament/switch-language/{code}', static function ($code) {
    request()->session()->put('locale', $code);
    return redirect()->back();
})->name('locale-switcher.switch');

Route::view('/', 'app');

Route::get('/{link:short_code}', RedirectController::class)->name('links.redirect');
