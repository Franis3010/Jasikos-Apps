<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;

Route::get('/', function () {
    $services = \App\Models\Service::all();
    return view('home', compact('services'));
  })->name('home');

Route::middleware('guest')->get('/', function () {
    return redirect()->route('login');
});
Route::middleware('auth')->get('/', [HomeController::class, 'index'])->name('home');
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',   [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register',[RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Service
    Route::get('/service/{id}', [ServiceController::class, 'show'])->name('service.show');
    Route::get('/service/{id}/edit', [ServiceController::class, 'edit'])->name('service.edit');
    Route::put('/service/{id}', [ServiceController::class, 'update'])->name('service.update');
    // wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/{service}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    // cart
    Route::post('/cart/add/{service}', [CartController::class, 'add'])->name('cart.add');
    Route::get('cart', [CartController::class, 'show'])->name('cart.show');
    Route::post('cart/{id}/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('cart/{id}/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Profile (only if authenticated)
    Route::middleware('auth')->get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::middleware('auth')->post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // … any other protected routes …

});




