<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartWash - Laundry System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%232563eb'><circle cx='18' cy='7' r='2.5'/><path d='M2 12C2 12 5 9 8 12C11 15 13 15 16 12C19 9 22 12 22 12' stroke='%232563eb' stroke-width='2.5' stroke-linecap='round'/></svg>">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        @keyframes wave {
            0%, 100% { transform: translateX(0); }
            50% { transform: translateX(2px); }
        }
        .animate-wave { animation: wave 3s ease-in-out infinite; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased min-h-screen flex flex-col">

    <nav class="bg-blue-600 text-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">

            @auth
                @php
                    $dashboardUrl = (Auth::user()->role == 'admin') ? route('admin.dashboard') : route('pelanggan.dashboard');
                @endphp
                <a href="{{ $dashboardUrl }}" class="flex items-center gap-3 group transition">
            @else
                <a href="{{ url('/') }}" class="flex items-center gap-3 group transition">
            @endauth
                <div class="relative">
                    <div class="absolute -inset-1 bg-cyan-400 opacity-20 rounded-full blur group-hover:opacity-60 transition duration-500"></div>
                    <div class="relative bg-white p-2 rounded-2xl shadow-sm border border-blue-50 transform group-hover:scale-110 group-hover:rotate-3 transition duration-300">
                        <svg class="w-7 h-7 text-blue-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 12C2 12 5 9 8 12C11 15 13 15 16 12C19 9 22 12 22 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="animate-wave"/>
                            <path d="M2 17C2 17 5 14 8 17C11 20 13 20 16 17C19 14 22 17 22 17" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" opacity="0.5"/>
                            <circle cx="18" cy="7" r="2.5" fill="currentColor" class="animate-bounce" style="animation-duration: 2s;"/>
                            <circle cx="12" cy="5" r="1.5" fill="currentColor" opacity="0.6" class="animate-bounce" style="animation-duration: 3s;"/>
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-black tracking-tighter leading-none text-white uppercase">
                        SMART<span class="text-cyan-300">WASH</span>
                    </span>
                    <div class="flex items-center gap-1 mt-1">
                        <span class="w-2 h-[2px] bg-cyan-400 rounded-full"></span>
                        <span class="text-[9px] font-black text-blue-100 uppercase tracking-[0.3em] leading-none">Clean Excellence</span>
                    </div>
                </div>
            </a>

            <div class="flex items-center gap-2 md:gap-4">
                @auth
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('admin.layanan.index') }}" class="hidden md:flex items-center gap-2 text-xs font-bold bg-blue-500 hover:bg-blue-400 px-4 py-2 rounded-xl transition">
                            🛠️ <span class="hidden lg:inline">Kelola Layanan</span>
                        </a>
                    @endif

                    <div class="flex items-center gap-3 bg-blue-700/50 p-1 pr-4 rounded-2xl border border-blue-500/30">
                        <a href="{{ route('profile.edit') }}" class="w-8 h-8 rounded-xl bg-white flex items-center justify-center text-blue-600 font-bold shadow-sm hover:scale-105 transition">
                            {{ substr(Auth::user()->nama, 0, 1) }}
                        </a>
                        <div class="hidden sm:block">
                            <p class="text-[10px] font-bold text-blue-200 uppercase leading-none mb-1">{{ Auth::user()->role }}</p>
                            <a href="{{ route('profile.edit') }}" class="text-xs font-bold hover:text-blue-200 transition tracking-tight">
                                {{ Auth::user()->nama }}
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 p-2.5 rounded-xl transition shadow-lg shadow-red-900/20" title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                @else
                    @if(Route::is('login'))
                        <div class="flex items-center gap-3">
                            <a href="{{ url('/') }}" class="hidden sm:block text-sm font-bold text-blue-100 hover:text-white transition"> Beranda </a>
                            <a href="{{ route('register') }}" class="bg-white text-blue-600 font-black px-6 py-2.5 rounded-xl hover:bg-blue-50 transition shadow-md text-sm uppercase tracking-wider">
                                Daftar
                            </a>
                        </div>
                    @elseif(Route::is('register'))
                        <div class="flex items-center gap-3">
                            <a href="{{ url('/') }}" class="hidden sm:block text-sm font-bold text-blue-100 hover:text-white transition"> Beranda </a>
                            <a href="{{ route('login') }}" class="bg-white text-blue-600 font-black px-6 py-2.5 rounded-xl hover:bg-blue-50 transition shadow-md text-sm uppercase tracking-wider">
                                Login
                            </a>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="bg-white text-blue-600 font-black px-6 py-2.5 rounded-xl hover:bg-gray-100 transition shadow-md uppercase text-sm tracking-wider">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="hidden sm:block bg-blue-500 text-white font-black px-6 py-2.5 rounded-xl hover:bg-blue-400 transition border border-blue-400 shadow-sm text-sm uppercase tracking-wider">
                                Daftar
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <main class="container mx-auto mt-8 px-4 mb-10 flex-grow">
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow mb-6 animate-pulse" role="alert">
                <p class="font-bold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Oops! Periksa input Anda:
                </p>
                <ul class="list-disc list-inside mt-2 text-sm ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 shadow-sm flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <strong class="font-bold">Gagal!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 shadow-sm flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-gray-800 text-gray-400 text-center py-6 text-sm mt-auto border-t border-gray-700">
        <div class="container mx-auto px-4">
            <p>&copy; {{ date('Y') }} <strong class="text-white">SmartWash</strong>. All rights reserved.</p>
            <p class="text-[10px] mt-1 text-gray-500 uppercase tracking-widest">Premium Laundry Management System</p>
        </div>
    </footer>

</body>
</html>