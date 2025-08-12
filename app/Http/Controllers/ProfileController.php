<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        // Isi field name dan email (logika lama dari Breeze)
        $request->user()->fill($validatedData);

        // Jika email diubah, reset status verifikasi (logika lama dari Breeze)
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // --- LOGIKA BARU UNTUK AVATAR, JABATAN, BIO ---
        $user = $request->user();

        // 1. Tangani Upload Avatar
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Simpan avatar baru dan simpan path-nya
            $validatedData['avatar'] = $request->file('avatar')->store('avatars', 'public');
    }

    // 2. Update user dengan semua data (termasuk jabatan dan bio dari $validatedData)
    $user->update($validatedData);

    // 3. Simpan semua perubahan
    $user->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
