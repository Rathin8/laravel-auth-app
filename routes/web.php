<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    });
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])
        ->name('social.redirect')
        ->where('provider', 'google|github');

    Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])
        ->name('social.callback')
        ->where('provider', 'google|github');
});
