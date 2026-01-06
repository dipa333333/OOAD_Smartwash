@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 mb-8 text-white shadow-xl relative overflow-hidden">
    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
    <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>

    <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold mb-2">Halo, {{ Auth::user()->nama }}! 👋</h1>
            <p class="text-blue-100 opacity-90">Cucian numpuk? Serahkan pada sistem SmartWash  kami sekarang.</p>
        </div>
        <a href="{{ route('pelanggan.pesan') }}" class="group bg-white text-blue-700 font-bold px-6 py-3 rounded-xl shadow-lg hover:bg-gray-50 transition transform hover:-translate-y-1 flex items-center gap-2">
            <svg class="w-5 h-5 group-hover:rotate-12 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Pesanan Baru
        </a>
    </div>
</div>

@php
    $adaTagihan = $pesanans->contains(function ($p) {
        return $p->statusPesanan == 'Selesai' && !$p->transaksi;
    });
@endphp

@if($adaTagihan)
    <div class="bg-orange-50 border-l-4 border-orange-500 p-4 mb-8 rounded-r-lg shadow-sm flex items-start gap-3">
        <svg class="w-6 h-6 text-orange-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        <div>
            <h3 class="font-bold text-orange-800">Menunggu Pembayaran</h3>
            <p class="text-sm text-orange-700">Cucian Anda sudah selesai! Silakan lakukan pembayaran untuk mengambil barang.</p>
        </div>
    </div>
@endif

<div class="mb-6 flex justify-between items-center">
    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Riwayat & Status Cucian
    </h2>
</div>

@if($pesanans->isEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
        <div class="bg-blue-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        </div>
        <h3 class="text-lg font-bold text-gray-700">Belum ada pesanan</h3>
        <p class="text-gray-500 mb-6">Mulai hidup bersih dan praktis hari ini.</p>
        <a href="{{ route('pelanggan.pesan') }}" class="text-blue-600 font-semibold hover:underline">Buat pesanan pertama &rarr;</a>
    </div>
@else
    <div class="grid grid-cols-1 gap-6">
        @foreach($pesanans as $pesanan)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
            <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-b border-gray-100">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Order ID</span>
                    <p class="font-bold text-gray-800 text-lg">#{{ $pesanan->idPesanan }}</p>
                </div>
                <div class="text-right">
                    <span class="text-xs text-gray-500">{{ $pesanan->created_at->format('d M Y, H:i') }}</span>
                    @if($pesanan->statusPesanan == 'Selesai' && !$pesanan->transaksi)
                        <div class="mt-1 text-xs font-bold text-orange-600 bg-orange-100 px-2 py-1 rounded">Belum Bayar</div>
                    @elseif($pesanan->statusPesanan == 'Selesai' && $pesanan->transaksi)
                        <div class="mt-1 text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded">Lunas</div>
                    @endif
                </div>
            </div>

            <div class="p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Total Tagihan:</p>
                        <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($pesanan->totalHarga, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                         @if($pesanan->estimasiSelesai)
                            <p class="text-gray-500 text-sm mb-1">Estimasi Selesai:</p>
                            <p class="font-bold text-gray-700">{{ $pesanan->estimasiSelesai->format('d M Y') }}</p>
                         @else
                            <p class="text-xs text-gray-400 italic mt-2">Menunggu estimasi admin...</p>
                         @endif
                    </div>
                </div>

                @php
                    $steps = ['Menunggu Validasi', 'Antre', 'Cuci', 'Setrika', 'Selesai'];
                    $currentStatus = $pesanan->statusPesanan;
                    $currentIndex = array_search($currentStatus, $steps);
                    if($currentIndex === false) $currentIndex = 0;
                @endphp

                <div class="relative">
                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
                        <div style="width: {{ ($currentIndex + 1) * 20 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500 transition-all duration-500"></div>
                    </div>
                    <div class="flex justify-between text-xs sm:text-sm text-gray-600">
                        @foreach($steps as $index => $step)
                            <div class="text-center {{ $index <= $currentIndex ? 'text-blue-600 font-bold' : 'text-gray-400' }}">
                                {{ $step }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection