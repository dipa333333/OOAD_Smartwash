<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'nomorTelepon' => 'nullable|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'nomorTelepon' => $request->nomorTelepon,
            'password' => Hash::make($request->password),
            'role' => 'pelanggan',
        ]);

        Auth::login($user);

        return redirect()->route('pelanggan.dashboard')->with('success', 'Akun berhasil dibuat! Selamat datang di SmartWash.');
    }
}