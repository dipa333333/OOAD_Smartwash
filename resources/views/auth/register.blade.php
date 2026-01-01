@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center relative overflow-hidden">
    <div id="login-bubble-area" class="absolute inset-0 z-0 pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-lg">
        <div class="bg-white/80 backdrop-blur-lg rounded-[3rem] shadow-2xl border border-white/50 overflow-hidden">
            <div class="bg-blue-600 p-8 text-center text-white relative">
                <h2 class="text-2xl font-black tracking-tight text-white">Buat Akun Baru</h2>
                <p class="text-blue-100 text-sm mt-1">Bergabunglah bersama komunitas SmartWash</p>
            </div>

            <form action="{{ route('register.post') }}" method="POST" class="p-10 space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                    <input type="text" name="nama" required class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 font-semibold text-gray-700" placeholder="Contoh: Budi Santoso">
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Username</label>
                    <input type="text" name="username" required class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 font-semibold text-gray-700" placeholder="Untuk login">
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">No. Telepon (WA)</label>
                    <input type="text" name="nomorTelepon" class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 font-semibold text-gray-700" placeholder="08123456789">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                        <input type="password" name="password" required class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 font-semibold text-gray-700" placeholder="******">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Ulangi Password</label>
                        <input type="password" name="password_confirmation" required class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 font-semibold text-gray-700" placeholder="******">
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-black py-4 rounded-2xl shadow-xl hover:bg-blue-700 transform hover:-translate-y-1 transition duration-300 uppercase tracking-widest mt-4">
                    Daftar Sekarang
                </button>

                <p class="text-center text-sm text-gray-500 font-medium">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-black hover:underline">Login di sini</a>
                </p>
            </form>
        </div>
    </div>
</div>

@endsection