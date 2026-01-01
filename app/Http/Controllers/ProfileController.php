<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;

class ProfileController extends Controller
{
    // 1. Tampilkan Form Edit Profil
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // 2. Proses Update Data
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi Input
        $request->validate([
            'nama' => 'required|string|max:255',
            // Username harus unik, TAPI kecualikan (ignore) milik user ini sendiri
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user->idUser, 'idUser')
            ],
            'nomorTelepon' => 'nullable|numeric',
            'alamat' => 'nullable|string',
            // Password opsional (nullable), kalau diisi minimal 6 karakter & harus confirmed
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update Data Diri Dasar
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->nomorTelepon = $request->nomorTelepon;
        $user->alamat = $request->alamat;

        // Cek apakah user mengisi password baru?
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        /** @var \App\Models\User $user */
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}