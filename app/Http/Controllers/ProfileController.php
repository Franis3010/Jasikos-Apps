<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        // Validate the image
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if ($user->profile_picture && file_exists(storage_path('app/public/' . $user->profile_picture))) {
                unlink(storage_path('app/public/' . $user->profile_picture));
            }

            // Store the new profile picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'Profile updated!');
    }
}