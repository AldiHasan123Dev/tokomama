<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        // Ambil user yang sedang login
        $user = auth()->user();

        // Ambil semua role dari tabel roles
        $roles = Role::all();

        // Kirim data ke view
        return view('profile.edit', compact('user', 'roles'));
    }
    /**
     * Update the user's profile information.
     */
   public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'password'=> 'nullable|string|min:6',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        // Ambil user dari database
        $user = User::findOrFail($id);

        // Update field user
        $user->role_id = $request->role_id;
        $user->name    = $request->name;
        $user->email   = $request->email;
        $user->phone   = $request->phone;
        $user->address = $request->address;

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Simpan perubahan
        $user->save();

        // Redirect kembali ke halaman edit dengan pesan sukses
        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function update1(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'password'=> 'nullable|string|min:6',
        ]);

        // Ambil user dari database
        $user = User::findOrFail($id);

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Simpan perubahan
        $user->save();

        // Redirect kembali ke halaman edit dengan pesan sukses
        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
