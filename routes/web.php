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

// Home routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Show login form only to guests (unauthenticated users)
Route::get('/login', [HomeController::class, 'viewLogin'])->name('login')->middleware('guest');
Route::get('/search', [HomeController::class, 'search'])->name('service.search');
// Authentication
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Service
Route::get('/service/{id}', [ServiceController::class, 'show'])->name('service.show');
Route::get('/service/{id}/edit', [ServiceController::class, 'edit'])->name('service.edit');
Route::put('/service/{id}', [ServiceController::class, 'update'])->name('service.update');

// Wishlist & Cart
Route::post('/wishlist/add/{service}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/cart/add/{service}', [CartController::class, 'add'])->name('cart.add');

// Profile (only if authenticated)
Route::middleware('auth')->get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::middleware('auth')->post('/profile', [ProfileController::class, 'update'])->name('profile.update');

Route::middleware('auth')->group(function () {
    Route::post('/wishlist/add/{service}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
});

Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/add/{service}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::delete('/wishlist/{service}', [WishlistController::class, 'remove'])->name('wishlist.remove');


Route::get('cart', [CartController::class, 'show'])->name('cart.show');
Route::post('cart/{id}/add', [CartController::class, 'add'])->name('cart.add');
Route::delete('cart/{id}/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('cart/clear', [CartController::class, 'clear'])->name('cart.clear');
