@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Profil Saya</h1>

        @if(Auth::user()->role == 'admin')
            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900">Kembali ke Dashboard</a>
        @else
            <a href="{{ route('pelanggan.dashboard') }}" class="text-gray-600 hover:text-gray-900">Kembali ke Dashboard</a>
        @endif
    </div>

    <div class="bg-white p-8 rounded-lg shadow-lg">
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2 border-b pb-2 mb-2">
                    <h3 class="text-lg font-semibold text-gray-700">Informasi Dasar</h3>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Username (Login)</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Nomor Telepon / WA</label>
                    <input type="text" name="nomorTelepon" value="{{ old('nomorTelepon', $user->nomorTelepon) }}" class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-bold mb-2">Alamat Lengkap</label>
                    <textarea name="alamat" rows="3" class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-500">{{ old('alamat', $user->alamat) }}</textarea>
                </div>


                <div class="md:col-span-2 border-b pb-2 mb-2 mt-4">
                    <h3 class="text-lg font-semibold text-gray-700">Ganti Password (Opsional)</h3>
                    <p class="text-xs text-gray-500">Biarkan kosong jika tidak ingin mengganti password.</p>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Password Baru</label>
                    <input type="password" name="password" class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-500" placeholder="Minimal 6 karakter">
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">Ulangi Password Baru</label>
                    <input type="password" name="password_confirmation" class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-blue-500" placeholder="Ketik ulang password baru">
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-700 transition shadow-lg">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection