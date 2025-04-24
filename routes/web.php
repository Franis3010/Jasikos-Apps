<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Auth;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [HomeController::class, 'viewLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::get('/service/{id}', [ServiceController::class, 'show'])->name('service.show');
Route::get('/service/{id}/edit', [ServiceController::class, 'edit'])->name('service.edit');
Route::put('/service/{id}', [ServiceController::class, 'update'])->name('service.update');

Route::middleware('auth')->get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::middleware('auth')->post('/profile', [ProfileController::class, 'update'])->name('profile.update');

Route::middleware('auth')->get('/home', function () {
    return view('home');
})->name('home');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');