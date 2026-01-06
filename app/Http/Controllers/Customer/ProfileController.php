<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('customer.profile.edit'); // view di atas
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $customer = $user->customer;

        $dataUser = $request->validate([
            'name' => ['required','string','max:255'],
            'phone' => ['required','string','max:50'],
            'whatsapp' => ['required','string','max:50'],
            'avatar' => ['nullable','image','max:2048'],
        ]);

        $dataCus = $request->validate([
            'address' => ['required','string','max:255'],
            'city' => ['required','string','max:100'],
            'province' => ['required','string','max:100'],
            'postal_code' => ['required','string','max:10'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $dataUser['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($dataUser);
        $customer->update($dataCus);

        return back()->with('success','Profil updated.');
    }
}
