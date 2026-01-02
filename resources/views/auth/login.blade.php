@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center relative overflow-hidden">

    <div id="login-bubble-area" class="absolute inset-0 z-0 pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-md">
        <div class="bg-white/80 backdrop-blur-lg rounded-[3rem] shadow-2xl border border-white/50 overflow-hidden">

            <div class="bg-blue-600 p-10 text-center text-white relative">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>

                <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-2xl shadow-lg mb-4 transform -rotate-6 group hover:rotate-0 transition-transform duration-300">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-black tracking-tight">Selamat Datang!</h2>
                <p class="text-blue-100 text-sm mt-1">Silakan masuk ke akun SmartWash Anda</p>
            </div>

            <form action="{{ route('login.post') }}" method="POST" class="p-10 space-y-6">
                @csrf

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            👤
                        </span>
                        <input type="text" name="username" required
                            class="w-full pl-11 pr-4 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 transition font-semibold text-gray-700 placeholder-gray-300"
                            placeholder="Masukkan username">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            🔑
                        </span>
                        <input type="password" name="password" required
                            class="w-full pl-11 pr-4 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 transition font-semibold text-gray-700 placeholder-gray-300"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-xs font-bold text-gray-500">Ingat Saya</span>
                    </label>
                    <a href="#" class="text-xs font-bold text-blue-600 hover:underline tracking-tight">Lupa Password?</a>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white font-black py-4 rounded-2xl shadow-xl shadow-blue-200 hover:bg-blue-700 transform hover:-translate-y-1 transition duration-300 uppercase tracking-widest">
                    Masuk Sekarang
                </button>

                <p class="text-center text-sm text-gray-500 font-medium mt-4">
                    Belum punya akun? <a href="#" class="text-blue-600 font-black hover:underline">Daftar Sekarang</a>
                </p>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bubbleArea = document.getElementById('login-bubble-area');

        function createLoginBubble() {
            const bubble = document.createElement('div');
            bubble.classList.add('bubble');

            const size = Math.random() * 30 + 10 + 'px';
            bubble.style.width = size;
            bubble.style.height = size;
            bubble.style.left = Math.random() * 100 + '%';
            bubble.style.bottom = '-50px';
            bubble.style.backgroundColor = 'rgba(59, 130, 246, 0.15)';
            bubble.style.animationDuration = Math.random() * 4 + 3 + 's';

            bubbleArea.appendChild(bubble);
            setTimeout(() => { bubble.remove(); }, 6000);
        }

        setInterval(createLoginBubble, 500);
    });
</script>

<style>
    @keyframes bubbleUp {
        0% { transform: translateY(0) scale(0.5); opacity: 0; }
        50% { opacity: 0.5; }
        100% { transform: translateY(-800px) scale(1.5); opacity: 0; }
    }
    .bubble {
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        animation: bubbleUp linear infinite;
    }
</style>
@endsection