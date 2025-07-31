<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan foto baru jika ada
        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->photo = $request->file('photo')->store('photos', 'public');
        }

        // Update nama dan email
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui.');
    }
}
