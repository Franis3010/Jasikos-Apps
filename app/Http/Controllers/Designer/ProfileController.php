<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $designer = auth()->user()->designer;
        return view('designer.profile.edit', compact('designer'));
    }

    public function update(Request $request)
    {
        $user     = auth()->user();
        $designer = $user->designer;

        // --- Normalisasi WhatsApp: ambil digit saja, ubah 08.. -> 62..
        $wa = preg_replace('/\D/', '', (string) $request->input('whatsapp', ''));
        if ($wa !== '' && str_starts_with($wa, '0')) {
            $wa = '62' . substr($wa, 1);
        }
        $request->merge(['whatsapp' => $wa]);

        // --- Validasi
        $data = $request->validate([
            // USER
            'whatsapp' => ['required', 'regex:/^62\d{8,13}$/'],
            'avatar'   => ['nullable','image','max:2048'],

            // DESIGNER
            'display_name'      => ['required','string','max:100'],
            'bio'               => ['required','string'],
            'bank_name'         => ['required','string','max:100'],
            'bank_account_no'   => ['required','string','max:100'],
            'bank_account_name' => ['required','string','max:100'],
            'qris_image'        => ['nullable','image','max:2048'],
        ], [
            'whatsapp.regex' => 'WhatsApp must start with 62 and contain digits only (e.g. 628123456789).',
        ]);

        // --- Update user (tanpa file dulu)
        $user->update([
            'whatsapp' => $data['whatsapp'],
        ]);

        // --- Avatar (opsional)
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->update([
                'avatar' => $request->file('avatar')->store('avatars', 'public'),
            ]);
        }

        // --- Update designer (tanpa file dulu)
        $designer->update([
            'display_name'      => $data['display_name'],
            'bio'               => $data['bio'],
            'bank_name'         => $data['bank_name'],
            'bank_account_no'   => $data['bank_account_no'],
            'bank_account_name' => $data['bank_account_name'],
        ]);

        // --- QRIS (opsional)
        if ($request->hasFile('qris_image')) {
            if ($designer->qris_image) {
                Storage::disk('public')->delete($designer->qris_image);
            }
            $designer->update([
                'qris_image' => $request->file('qris_image')->store('qris', 'public'),
            ]);
        }

        return back()->with('success', 'Designer profile updated.');
    }
}
