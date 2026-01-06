@extends('layouts.app')

@section('content')
<div class="relative bg-white overflow-hidden rounded-[3rem] shadow-xl mb-20 animate-[fadeIn_1s_ease-in] border border-gray-100">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 rounded-br-[100px]">
            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                        <span class="block xl:inline">Cucian Menumpuk?</span>
                        <span class="block text-blue-600 transition-colors duration-500 hover:text-indigo-600 italic">Santai, SmartWash Aja!</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0 leading-relaxed">
                        Solusi laundry cerdas dengan sistem tracking real-time. Kami menjamin pakaian Anda kembali wangi, rapi, dan tepat waktu.
                    </p>

                    <div class="mt-8 sm:max-w-lg sm:mx-auto lg:mx-0">
                        <form action="{{ route('cek.pesanan') }}" method="GET" class="relative group">
                            <div class="absolute -inset-1 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-full blur opacity-20 group-hover:opacity-40 transition duration-200"></div>
                            <div class="relative flex items-center bg-white rounded-full border border-gray-200 shadow-lg shadow-blue-900/5 p-1.5 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent transition-all">
                                <div class="pl-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="number" name="id" placeholder="Nomor Nota (Cth: 10)" required
                                    class="w-full px-4 py-3 bg-transparent border-none text-gray-800 font-bold placeholder:text-gray-400 focus:ring-0 outline-none text-sm sm:text-base appearance-none">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-black py-3 px-6 rounded-full transition-all transform hover:scale-105 shadow-md text-xs sm:text-sm uppercase tracking-wider flex items-center gap-2">
                                    <span>Lacak</span>
                                    <span class="hidden sm:inline">Sekarang</span>
                                </button>
                            </div>
                        </form>
                        <p class="mt-2 text-[10px] text-gray-400 font-bold uppercase tracking-widest pl-4">
                            *Cek status tanpa login
                        </p>
                    </div>
                    <div class="mt-8 sm:mt-10 sm:flex sm:justify-center lg:justify-start gap-4">
                        @auth
                            <a href="{{ route('pelanggan.dashboard') }}" class="flex items-center justify-center px-8 py-3 rounded-2xl text-blue-600 bg-blue-50 hover:bg-blue-100 font-bold transition border border-blue-200 uppercase tracking-wider text-sm">
                                 Masuk Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="flex items-center justify-center px-8 py-3 rounded-2xl text-blue-600 bg-blue-50 hover:bg-blue-100 font-bold transition border border-blue-200 uppercase tracking-wider text-sm">
                                 Login Member
                            </a>
                        @endauth
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-gradient-to-br from-blue-700 to-indigo-950 flex items-center justify-center overflow-hidden p-10">

        <div id="bubble-area" class="absolute inset-0 z-0 opacity-30"></div>

        <div class="absolute opacity-20 scale-150 sm:scale-[2] pointer-events-none">
            <div class="relative w-40 h-48 bg-white rounded-2xl border-4 border-blue-400 overflow-hidden shadow-inner">
                <div class="absolute top-4 left-4 right-4 h-2 bg-blue-100 rounded-full"></div>
                <div class="absolute top-12 left-1/2 -translate-x-1/2 w-32 h-32 rounded-full border-4 border-dashed border-blue-300 animate-[spin_8s_linear_infinite]"></div>
                <div class="absolute bottom-0 w-full h-20 bg-blue-400/50 animate-[wave_3s_ease-in-out_infinite]"></div>
            </div>
        </div>

        <div class="relative z-10 w-full max-w-lg">

            <div class="bg-white/95 backdrop-blur-xl rounded-[2.5rem] shadow-2xl p-8 transform -rotate-2 hover:rotate-0 transition-all duration-500 shadow-blue-950/50 border border-white/40">
                <div class="flex items-center gap-3 mb-8">
                    <div class="flex gap-1.5">
                        <div class="w-3 h-3 rounded-full bg-rose-400"></div>
                        <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                        <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                    </div>
                    <div class="ml-auto bg-blue-600 text-[10px] font-black text-white px-4 py-1 rounded-full uppercase tracking-tighter shadow-lg shadow-blue-200">
                        Live Status
                    </div>
                </div>

                <div class="space-y-5">
                    <div class="group p-4 bg-gray-50 rounded-3xl border border-blue-50 flex items-center gap-4 transition-all hover:bg-white hover:shadow-md">
                        <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-2xl animate-spin duration-[5s]">👕</div>
                        <div class="flex-1 text-left">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-[11px] font-black text-gray-800 uppercase tracking-tight">Kaus Kiloan (4.5kg)</span>
                                <span class="text-[9px] font-bold text-blue-600 animate-pulse">SEDANG DICUCI</span>
                            </div>
                            <div class="h-2 w-full bg-blue-100 rounded-full overflow-hidden">
                                <div class="bg-blue-600 h-full w-[65%] animate-[loading_2s_ease-in-out_infinite]"></div>
                            </div>
                        </div>
                    </div>

                    <div class="group p-4 bg-emerald-50/50 rounded-3xl border border-emerald-100 flex items-center gap-4 transition-all hover:bg-white hover:shadow-md">
                        <div class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white text-2xl">✨</div>
                        <div class="flex-1 text-left">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-[11px] font-black text-gray-800 uppercase tracking-tight">Jaket Denim (1 pcs)</span>
                                <span class="text-[9px] font-bold text-emerald-600">SIAP AMBIL</span>
                            </div>
                            <div class="h-2 w-full bg-emerald-100 rounded-full overflow-hidden">
                                <div class="bg-emerald-500 h-full w-full"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="absolute -right-8 -bottom-10 bg-white p-4 rounded-3xl shadow-2xl border border-blue-50 hidden md:flex items-center gap-4 animate-[bounce_5s_infinite] transform rotate-3 z-20">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white font-black shadow-lg shadow-blue-200">
                        B
                    </div>
                    <div class="text-left">
                        <p class="text-xs font-black text-gray-800 tracking-tight leading-none">Budi Santoso</p>
                        <p class="text-[9px] text-blue-500 font-bold uppercase mt-1">Selesai 2m yang lalu</p>
                    </div>
                    <div class="ml-2 w-7 h-7 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 shadow-inner">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="py-24 bg-white overflow-hidden" id="tentang-kami">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col lg:flex-row items-center gap-16 md:gap-24">

            <div class="relative w-full lg:w-1/2">
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-blue-50 rounded-full blur-3xl opacity-70"></div>
                <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-indigo-50 rounded-full blur-3xl opacity-70"></div>

                <div class="relative group">
                    <div class="absolute -inset-4 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-[3.5rem] opacity-10 group-hover:opacity-20 transition duration-500"></div>

                    <img src="https://images.unsplash.com/photo-1517677208171-0bc6725a3e60?auto=format&fit=crop&q=80&w=1000"
                         alt="SmartWash Workshop"
                         class="relative w-full h-[500px] object-cover rounded-[3rem] shadow-2xl border-4 border-white transform group-hover:scale-[1.02] transition duration-500">

                    <div class="absolute -bottom-8 -left-8 bg-white p-6 rounded-[2rem] shadow-2xl border border-gray-50 flex items-center gap-5 animate-bounce-slow">
                        <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center text-3xl shadow-lg shadow-blue-200">
                            🧼
                        </div>
                        <div>
                            <p class="text-3xl font-black text-gray-800 leading-none">10th</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1 text-left">Tahun <br> Pengalaman</p>
                        </div>
                    </div>

                    <div class="absolute top-10 -right-6 bg-emerald-500 p-4 rounded-2xl shadow-xl border-4 border-white text-white rotate-6 hover:rotate-0 transition duration-300">
                        <p class="text-[10px] font-black uppercase tracking-tighter">1 Mesin 1 Pelanggan</p>
                        <p class="text-[9px] font-bold opacity-80">Higienitas Terjamin ✨</p>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/2 text-left">
                <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-600 px-5 py-2 rounded-full mb-8">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    <span class="text-[15px] font-black uppercase tracking-[0.2em]">Siapa Kami?</span>
                </div>

                <h2 class="text-4xl md:text-5xl font-black text-gray-800 leading-[1.1] mb-8 tracking-tighter">
                    Kami Menjaga <span class="text-blue-600">Pakaian Anda</span> <br> Seperti Milik Sendiri.
                </h2>

                <p class="text-gray-500 text-lg leading-relaxed mb-10 italic">
                    Maha Laundry dengan sistem SmartWash hadir untuk mendefinisikan ulang standar kebersihan. Kami bukan hanya mencuci pakaian, kami memberikan Anda **ketenangan pikiran** dan **waktu luang** yang berharga.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-12">
                    <div class="group">
                        <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white transition duration-300">
                            🌊
                        </div>
                        <h4 class="font-black text-gray-800 mb-2 uppercase text-xs tracking-widest">Air Terfilter</h4>
                        <p class="text-sm text-gray-400 leading-relaxed">Sistem filtrasi canggih memastikan air bebas kaporit dan zat yang merusak serat kain.</p>
                    </div>
                    <div class="group">
                        <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white transition duration-300">
                            🌿
                        </div>
                        <h4 class="font-black text-gray-800 mb-2 uppercase text-xs tracking-widest">Deterjen Organik</h4>
                        <p class="text-sm text-gray-400 leading-relaxed">Ramah lingkungan dan hipoalergenik, aman untuk kulit sensitif dan pakaian bayi.</p>
                    </div>
                </div>

                <div class="pt-8 border-t border-gray-100 flex items-center gap-6">
                    <div class="flex -space-x-3">
                        <img src="https://i.pravatar.cc/100?u=1" class="w-10 h-10 rounded-full border-2 border-white">
                        <img src="https://i.pravatar.cc/100?u=2" class="w-10 h-10 rounded-full border-2 border-white">
                        <img src="https://i.pravatar.cc/100?u=3" class="w-10 h-10 rounded-full border-2 border-white">
                    </div>
                    <p class="text-xs text-gray-400 font-medium">Bergabung dengan <span class="text-gray-800 font-bold">1,000+ Pelanggan Setia</span> di area Denpasar.</p>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 mb-24">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-blue-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <p class="text-4xl font-black text-blue-600 group-hover:scale-110 transition-transform">
                <span class="counter" data-target="1200">0</span>+
            </p>
            <p class="text-gray-400 mt-2 text-xs font-bold uppercase tracking-widest">Pelanggan Puas</p>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-blue-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <p class="text-4xl font-black text-blue-600 group-hover:scale-110 transition-transform">
                <span class="counter" data-target="4.9" data-type="decimal">0</span>★
            </p>
            <p class="text-gray-400 mt-2 text-xs font-bold uppercase tracking-widest">Rating Google</p>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-blue-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <p class="text-4xl font-black text-blue-600 group-hover:scale-110 transition-transform">
                <span class="counter" data-target="24">0</span>h
            </p>
            <p class="text-gray-400 mt-2 text-xs font-bold uppercase tracking-widest">Respon Cepat</p>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-blue-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <p class="text-4xl font-black text-blue-600 group-hover:scale-110 transition-transform">
                <span class="counter" data-target="100">0</span>%
            </p>
            <p class="text-gray-400 mt-2 text-xs font-bold uppercase tracking-widest">Terdata Aman</p>
        </div>
    </div>
</div>

<div class="mb-24 px-4 bg-blue-50/50 py-20 rounded-[4rem]">
    <div class="text-center mb-16">
        <h2 class="text-4xl font-black text-gray-900 tracking-tight">Gampang Banget! ⚡</h2>
        <p class="text-gray-500 mt-2">Proses cuci jadi lebih simpel dengan 3 langkah</p>
    </div>
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12">
        <div class="text-center group relative">
            <div class="w-20 h-20 bg-white text-blue-600 rounded-3xl flex items-center justify-center mx-auto mb-6 text-3xl font-black shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-all duration-500 transform group-hover:rotate-12">1</div>
            <h3 class="font-bold text-xl mb-3 text-gray-800">Pesan Online</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Pilih layanan di dashboard & antar cucian ke outlet.</p>
        </div>
        <div class="text-center group relative">
            <div class="w-20 h-20 bg-white text-blue-600 rounded-3xl flex items-center justify-center mx-auto mb-6 text-3xl font-black shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-all duration-500 transform group-hover:rotate-12">2</div>
            <h3 class="font-bold text-xl mb-3 text-gray-800">Pantau Status</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Cek progres cucian (Antre/Cuci/Selesai) secara real-time.</p>
        </div>
        <div class="text-center group relative">
            <div class="w-20 h-20 bg-white text-blue-600 rounded-3xl flex items-center justify-center mx-auto mb-6 text-3xl font-black shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-all duration-500 transform group-hover:rotate-12">3</div>
            <h3 class="font-bold text-xl mb-3 text-gray-800">Ambil & Wangi</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Ambil baju yang sudah bersih & bayar lewat kasir.</p>
        </div>
    </div>
</div>

<div id="kalkulator" class="bg-white rounded-[4rem] p-10 md:p-16 shadow-2xl shadow-blue-100 mb-24 border border-blue-50 mx-4">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div>
            <h2 class="text-4xl font-black text-gray-900 mb-4 tracking-tight">Simulasi Harga 🧮</h2>
            <p class="text-gray-500 mb-10">Bantu kamu menghitung estimasi biaya sebelum ke outlet.</p>
            <div class="space-y-8">
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Pilih Layanan</label>
                    <select id="calcLayanan" class="w-full p-5 bg-gray-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-100 font-bold text-gray-700 shadow-sm appearance-none cursor-pointer transition">
                        @foreach($layanans as $layanan)
                            <option value="{{ $layanan->harga }}">{{ $layanan->namaLayanan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <div class="flex justify-between mb-4">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest">Berat Estimasi</label>
                        <span id="rangeVal" class="text-blue-600 font-black text-2xl italic">1 Kg</span>
                    </div>
                    <input type="range" id="calcRange" min="1" max="30" value="1" class="w-full h-3 bg-blue-100 rounded-lg appearance-none cursor-pointer accent-blue-600">
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-blue-600 to-indigo-800 rounded-[3rem] p-12 text-white text-center shadow-2xl relative overflow-hidden group">
            <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <p class="text-blue-100 text-xs font-bold uppercase tracking-[0.2em] mb-4">Total Estimasi Biaya</p>
            <div id="calcResult" class="text-6xl md:text-7xl font-black mb-6 tracking-tighter italic">Rp 0</div>
            <div class="h-1.5 w-24 bg-blue-400/50 mx-auto rounded-full mb-8"></div>
            <p class="text-blue-200 text-[10px] leading-relaxed italic opacity-80 uppercase tracking-widest">Harga akhir akan dipastikan kembali oleh petugas laundry.</p>
        </div>
    </div>
</div>


<div class="py-24 bg-gray-900 rounded-[5rem] mx-4 mb-24 overflow-hidden relative border border-white/5">
    <div class="absolute top-0 right-0 w-96 h-96 bg-blue-600/20 blur-[150px] -z-0"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-600/10 blur-[150px] -z-0"></div>

    <div class="max-w-6xl mx-auto relative z-10 mb-16 px-4">
        <h2 class="text-4xl font-black text-white text-center mb-4 italic">Apa Kata Mereka? 💬</h2>
        <p class="text-center text-gray-400 uppercase tracking-[0.3em] text-[10px] font-bold">Review jujur dari ribuan pelanggan setia</p>
    </div>

    <div class="relative flex overflow-hidden group">
        <div class="flex gap-8 animate-marquee group-hover:pause-animate">
            @php
                $testis = [
                    ['A', 'Andi Pratama', 'Mahasiswa', 'Gak perlu nanya status terus. Tinggal buka dashboard langsung kelihatan!'],
                    ['R', 'Rina Setia', 'Ibu Rumah Tangga', 'Wanginya awet banget, packing rapi. Sistemnya modern banget.'],
                    ['D', 'Doni Saputra', 'Freelancer', 'Tracking-nya membantu banget. Gak perlu lagi chat admin tiap jam.'],
                    ['S', 'Siti Aminah', 'Wirausaha', 'Layanan Express-nya juara! Pagi taruh, sore sudah bisa diambil.'],
                    ['B', 'Bambang U.', 'Karyawan', 'Adminnya fast respon dan sistem pembayarannya sangat mudah.'],
                    ['M', 'Maya Putri', 'Influencer', 'Laundry paling estetik dan bajunya tetap terawat seperti baru.']
                ];
            @endphp

            {{-- Cetak Pertama --}}
            @foreach($testis as $t)
            <div class="flex-shrink-0 w-[350px] bg-white/5 backdrop-blur-xl p-8 rounded-[3rem] border border-white/10 hover:border-blue-500/50 transition-all duration-500 group/card">
                <p class="text-gray-300 italic mb-8 leading-relaxed h-20 overflow-hidden">“{{ $t[3] }}”</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-600 flex items-center justify-center font-black text-white text-xl shadow-lg shadow-blue-900/20 group-hover/card:scale-110 transition-transform">
                        {{ $t[0] }}
                    </div>
                    <div>
                        <p class="font-bold text-white tracking-tight">{{ $t[1] }}</p>
                        <p class="text-[9px] text-blue-400 font-black uppercase tracking-widest">{{ $t[2] }}</p>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Cetak Kedua --}}
            @foreach($testis as $t)
            <div class="flex-shrink-0 w-[350px] bg-white/5 backdrop-blur-xl p-8 rounded-[3rem] border border-white/10 hover:border-blue-500/50 transition-all duration-500 group/card">
                <p class="text-gray-300 italic mb-8 leading-relaxed h-20 overflow-hidden">“{{ $t[3] }}”</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-600 flex items-center justify-center font-black text-white text-xl shadow-lg shadow-blue-900/20 group-hover/card:scale-110 transition-transform">
                        {{ $t[0] }}
                    </div>
                    <div>
                        <p class="font-bold text-white tracking-tight">{{ $t[1] }}</p>
                        <p class="text-[9px] text-blue-400 font-black uppercase tracking-widest">{{ $t[2] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto mb-24 px-4">
    <h2 class="text-4xl font-black text-gray-900 text-center mb-16 italic">FAQ & Info ❓</h2>
    <div class="grid md:grid-cols-2 gap-4">
        @php
            $faqs = [
                ['Berapa lama proses pengerjaannya?', 'Standar pengerjaan kami adalah 1-2 hari kerja.'],
                ['Apakah bisa antar-jemput?', 'Tentu! Hubungi WhatsApp kami untuk request penjemputan.'],
                ['Area layanan di mana saja?', 'Saat ini kami fokus melayani area sekitar outlet pusat.'],
                ['Metode pembayarannya apa?', 'Bisa Tunai atau QRIS saat pengambilan pakaian.'],
            ];
        @endphp
        @foreach($faqs as $f)
        <details class="group bg-white rounded-3xl shadow-sm border border-gray-100 p-8 cursor-pointer transition-all hover:border-blue-200">
            <summary class="flex items-center justify-between gap-4 text-gray-900 list-none font-bold text-lg leading-tight">
                {{ $f[0] }}
                <span class="text-blue-600 transition group-open:rotate-180">▼</span>
            </summary>
            <p class="mt-6 text-gray-500 italic text-sm leading-relaxed border-t pt-6 border-gray-50">{{ $f[1] }}</p>
        </details>
        @endforeach
    </div>
</div>

<div class="relative bg-blue-600 rounded-[4rem] p-12 md:p-20 overflow-hidden mb-10 mx-4 shadow-2xl group">
    <div id="footer-bubble-area" class="absolute inset-0 z-0 pointer-events-none opacity-50"></div>

    <div class="relative z-10 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <div class="text-center lg:text-left">
                <h2 class="text-4xl md:text-5xl font-black text-white mb-6 italic tracking-tighter uppercase leading-tight">
                    Siap Mencuci <br><span class="text-cyan-300">Tanpa Ribet?</span>
                </h2>
                <p class="text-blue-100 mb-10 text-lg opacity-90 leading-relaxed">
                    Gabung dengan ribuan pelanggan kami. Lokasi strategis, parkir luas, dan layanan kilat menunggu Anda.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto bg-white text-blue-600 font-black px-10 py-4 rounded-2xl hover:bg-gray-100 transition shadow-xl transform hover:-translate-y-1 uppercase tracking-widest text-xs sm:text-sm text-center">
                        Mulai Sekarang
                    </a>
                    <a href="https://wa.me/6285739519144" class="w-full sm:w-auto bg-blue-700 text-white font-black px-10 py-4 rounded-2xl border border-blue-500 hover:bg-blue-800 transition uppercase tracking-widest text-xs sm:text-sm text-center">
                        Hubungi Admin
                    </a>
                </div>
            </div>

            <div class="relative w-full h-80 lg:h-96 bg-blue-800 rounded-[3rem] overflow-hidden border-8 border-blue-500/30 shadow-inner group-hover:border-blue-400/50 transition-colors duration-500">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d52015.36964177921!2d115.15122662167967!3d-8.663618699999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd24091ebc2ba6f%3A0x781eae1b410d4c19!2sMAHA%20LAUNDRY!5e1!3m2!1sid!2sid!4v1767336590459!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    class="absolute inset-0 filter grayscale hover:grayscale-0 transition duration-700">
                </iframe>

                <div class="absolute bottom-6 right-6 bg-white text-blue-800 px-4 py-2 rounded-xl text-xs font-bold shadow-lg pointer-events-none">
                    📍 Lokasi Laundry
                </div>
            </div>

        </div>
    </div>
</div>

<footer class="bg-gray-100 py-16 px-6 border-t border-gray-200">
    <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-16">
        <div>
            <div class="flex items-center gap-2 mb-6">
                <span class="text-2xl font-black text-gray-800 uppercase italic">Smart<span class="text-blue-600">Wash</span></span>
            </div>
            <p class="text-sm text-gray-500 leading-relaxed italic">Sistem management laundry modern terintegrasi dengan tracking status real-time.</p>
        </div>
        <div>
            <h4 class="text-gray-900 font-black uppercase tracking-[0.2em] text-xs mb-8">Informasi Kontak</h4>
            <ul class="space-y-4 text-sm font-medium text-gray-500">
                <li class="flex items-center gap-3">📍 <span class="hover:text-blue-600 transition cursor-default">Jl. Letda Ngurah Putra No. 2A</span></li>
                <li class="flex items-center gap-3">📞 <span class="hover:text-blue-600 transition cursor-default">0812-3456-7890</span></li>
                <li class="flex items-center gap-3">🕒 <span class="hover:text-blue-600 transition cursor-default">08:00 - 21:00 WIB</span></li>
            </ul>
        </div>
        <div>
            <h4 class="text-gray-900 font-black uppercase tracking-[0.2em] text-xs mb-8">Navigasi Cepat</h4>
            <ul class="space-y-4 text-sm font-bold text-gray-500">
                <li><a href="#" class="hover:text-blue-600 transition">Beranda</a></li>
                <li><a href="#kalkulator" class="hover:text-blue-600 transition">Simulasi Harga</a></li>
                <li><a href="{{ route('login') }}" class="hover:text-blue-600 transition">Pesan Sekarang</a></li>
            </ul>
        </div>
    </div>
    <div class="max-w-6xl mx-auto mt-16 pt-8 border-t border-gray-200 text-center">
        <p class="text-[10px] font-black uppercase tracking-[0.5em] text-gray-400">© {{ date('Y') }} Maha Laundry • Made with Passion for Cleanliness</p>
    </div>
</footer>

<style>
    /* 1. Animasi Muncul Halus */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* 2. Animasi Gelembung Sabun */
    @keyframes bubbleUp {
        0% { transform: translateY(0) scale(0.5); opacity: 0; }
        50% { opacity: 0.8; }
        100% { transform: translateY(-300px) scale(1.2); opacity: 0; }
    }
    .bubble {
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        animation: bubbleUp ease-in infinite;
    }

    /* 3. Animasi Loading Bar */
    @keyframes loading {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    /* 4. Animasi (Wave) */
    @keyframes wave {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-5px) rotate(2deg); }
    }

    /* 5. Animasi Putaran Mesin */
    @keyframes spin {
        from { transform: translate(-50%, 0) rotate(0deg); }
        to { transform: translate(-50%, 0) rotate(360deg); }
    }

    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(calc(-350px * 6 - 2rem * 6)); }
    }

    .animate-marquee {
        animation: marquee 40s linear infinite;
    }

    .pause-animate {
        animation-play-state: paused;
    }

    @media (max-width: 768px) {
        .animate-marquee {
            animation-duration: 25s;
        }
    }

    summary::-webkit-details-marker { display: none; }

    html { scroll-behavior: smooth; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. KALKULATOR ---
        const slider = document.getElementById('calcRange');
        const textBerat = document.getElementById('rangeVal');
        const selectLayanan = document.getElementById('calcLayanan');
        const textHasil = document.getElementById('calcResult');

        function hitungUlang() {
            const kg = parseInt(slider.value);
            const harga = parseInt(selectLayanan.value);
            const total = kg * harga;
            textBerat.innerText = kg + ' Kg';
            textHasil.innerText = 'Rp ' + total.toLocaleString('id-ID');
        }
        slider.addEventListener('input', hitungUlang);
        selectLayanan.addEventListener('change', hitungUlang);
        hitungUlang();

        // --- 2. BUBBLES ---
        function createBubble(targetAreaId, bubbleStyle = 'rgba(255, 255, 255, 0.2)') {
        const area = document.getElementById(targetAreaId);
        if (!area) return;

        const bubble = document.createElement('div');
        bubble.classList.add('bubble');
        bubble.style.background = bubbleStyle;
        bubble.style.border = '1px solid rgba(255, 255, 255, 0.4)';
        bubble.style.boxShadow = '0 0 5px rgba(255, 255, 255, 0.2)';

        const size = Math.random() * 20 + 10 + 'px';
        bubble.style.width = size;
        bubble.style.height = size;

        bubble.style.position = 'absolute';
        bubble.style.borderRadius = '50%';

        bubble.style.left = Math.random() * 100 + '%';
        bubble.style.bottom = '-20px';
        bubble.style.animationDuration = Math.random() * 3 + 2 + 's';

        area.appendChild(bubble);
        setTimeout(() => { bubble.remove(); }, 4000);
    }
    setInterval(() => createBubble('bubble-area', 'rgba(59, 130, 246, 0.3)'), 500);
    setInterval(() => createBubble(
        'footer-bubble-area',
        'radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.1))'
    ), 800);


        const counters = document.querySelectorAll('.counter');
        const speed = 100;

        const animateCounter = (counter) => {
            const target = +counter.getAttribute('data-target');
            const type = counter.getAttribute('data-type');
            let count = 0;

            // Hitung kenaikan per frame
            const increment = target / speed;

            const updateCount = () => {
                count += increment;
                if (count < target) {
                    counter.innerText = type === 'decimal' ? count.toFixed(1) : Math.ceil(count);
                    setTimeout(updateCount, 15);
                } else {
                    counter.innerText = type === 'decimal' ? target.toFixed(1) : target;
                }
            };
            updateCount();
        };

        // Trigger animasi saat scroll sampai ke elemennya
        const observerOptions = { threshold: 0.5 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        counters.forEach(counter => observer.observe(counter));
    });
</script>
@endsection