<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use App\Models\Service;
use App\Http\Controllers\AdminController;

// Redirect guest users to login
Route::middleware('guest')->get('/', function () {
    return redirect()->route('login');
});

// Redirect authenticated users based on role
Route::middleware('auth')->get('/', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.home');
    }

    $services = Service::all();
    return view('home', compact('services'));
})->name('home');

// Admin homepage route
Route::middleware('auth')->get('/admin-home', [AdminController::class, 'index'])->name('admin.home');

// Guest-only routes (login, register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register',[RegisterController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Service routes
    Route::get('/service/{id}', [ServiceController::class, 'show'])->name('service.show');
    // Route::get('/service/{id}', [ServiceController::class, 'adminshow'])->name('service.adminshow');
    Route::get('/service/{id}/edit', [ServiceController::class, 'edit'])->name('service.edit');
    Route::put('/service/{id}', [ServiceController::class, 'update'])->name('service.update');
    Route::get('/service', [ServiceController::class, 'browseForUser'])->name('service.browse');

    // Wishlist routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/{service}', [WishlistController::class, 'remove'])->name('wishlist.remove');

    // Cart routes
    Route::post('/cart/add/{service}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
    Route::post('/cart/{id}/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/{id}/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // admin services rooutes
    Route::get('/admin/services', [ServiceController::class, 'adminShow'])->name('service.adminshow');
    Route::get('/admin/services/create', [ServiceController::class, 'create'])->name('service.create');
    Route::post('/admin/services', [ServiceController::class, 'store'])->name('service.store');
    Route::delete('/admin/services/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');
});
