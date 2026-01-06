<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\{Designer, Customer};

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','string','email','max:255','unique:'.User::class],
            'password' => ['required','confirmed', Rules\Password::defaults()],
            'role'     => ['required','in:designer,customer'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        if ($user->role === 'designer') {
            Designer::create(['user_id' => $user->id, 'display_name' => $user->name]);
        } else {
            Customer::create(['user_id' => $user->id, 'address' => null]);
        }

        // Kirim event registered (untuk email verification jika dipakai)
        event(new Registered($user));

        // >>> JANGAN auto-login
        // Auth::login($user);

        // Arahkan ke halaman login dengan pesan sukses
        return redirect()
            ->route('login')
            ->with('status', 'Registration successful. Please sign in.');

        // (Alternatif kalau mau paksa verifikasi dulu)
        // return redirect()->route('verification.notice')
        //     ->with('status', 'We have sent a verification link to your email.');
    }
}
