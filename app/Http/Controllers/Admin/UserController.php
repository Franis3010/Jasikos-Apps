<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $role = $request->get('role');

        $users = User::when($q, fn($x) => $x->where(function($w) use($q) {
                            $w->where('name', 'like', "%$q%")->orWhere('email', 'like', "%$q%");
                        }))
                        ->when($role, fn($x) => $x->where('role', $role))
                        ->orderBy('created_at', 'desc')
                        ->paginate(15)
                        ->withQueryString();

        return view('admin.users.index', compact('users','q','role'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'role'     => ['required', Rule::in(['admin','designer','customer'])],
            'phone'    => ['nullable','string','max:30'],
            'whatsapp' => ['nullable','string','max:30'],
        ]);

        // prevent downgrading own role
        if (auth()->id() === $user->id && $data['role'] !== 'admin') {
            return back()->with('warning', 'You cannot change your own account role to non-admin.');
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('warning', 'You cannot delete your own account.');
        }
        $user->delete();
        return back()->with('success', 'User deleted.');
    }
}
