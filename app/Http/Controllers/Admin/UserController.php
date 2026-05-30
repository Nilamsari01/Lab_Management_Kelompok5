<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::whereIn('role', ['admin', 'dosen'])->orderBy('role')->orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,dosen'],
            'access_allowed' => ['sometimes', 'boolean'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'access_allowed' => $request->boolean('access_allowed', true),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dibuat.');
    }

    public function edit(User $user): View
    {
        if (! in_array($user->role, ['admin', 'dosen'])) {
            abort(404);
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        if (! in_array($user->role, ['admin', 'dosen'])) {
            abort(404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,dosen'],
            'access_allowed' => ['sometimes', 'boolean'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->access_allowed = $request->boolean('access_allowed', true);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if (! in_array($user->role, ['admin', 'dosen'])) {
            abort(404);
        }

        if (Auth::id() === $user->id) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dihapus.');
    }
}
