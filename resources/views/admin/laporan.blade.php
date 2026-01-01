@extends('layouts.app')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h1 class="text-3xl font-black text-gray-800 tracking-tight">Laporan Keuangan 📈</h1>
        <p class="text-gray-500 font-medium">Pantau pertumbuhan bisnis SmartWash Anda secara real-time.</p>
    </div>
    <div class="flex gap-3">
        <button onclick="window.print()" class="flex items-center gap-2 bg-white text-gray-700 font-bold px-5 py-2.5 rounded-2xl shadow-sm border border-gray-200 hover:bg-gray-50 transition no-print">
            <span>🖨️</span> Cetak Laporan
        </button>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 bg-gray-800 text-white font-bold px-5 py-2.5 rounded-2xl shadow-lg hover:bg-gray-900 transition no-print">
            Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="relative bg-gradient-to-br from-blue-600 to-blue-700 p-8 rounded-[2.5rem] text-white shadow-xl shadow-blue-200 overflow-hidden group">
        <div class="absolute -right-6 -bottom-6 text-9xl opacity-10 group-hover:scale-110 transition-transform duration-500">💰</div>
        <h3 class="text-blue-100 text-xs font-black uppercase tracking-[0.2em] mb-2">Omzet Hari Ini</h3>
        <p class="text-4xl font-black italic">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</p>
        <div class="mt-4 flex items-center gap-2 text-xs text-blue-200">
            <span class="bg-blue-500/30 px-2 py-1 rounded-lg">Terupdate: {{ date('H:i') }}</span>
        </div>
    </div>

    <div class="relative bg-gradient-to-br from-emerald-500 to-teal-600 p-8 rounded-[2.5rem] text-white shadow-xl shadow-emerald-100 overflow-hidden group">
        <div class="absolute -right-6 -bottom-6 text-9xl opacity-10 group-hover:scale-110 transition-transform duration-500">📊</div>
        <h3 class="text-emerald-50 text-xs font-black uppercase tracking-[0.2em] mb-2">Total Bulan Ini</h3>
        <p class="text-4xl font-black italic">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</p>
        <div class="mt-4 flex items-center gap-2 text-xs text-emerald-100">
            <span class="bg-emerald-400/30 px-2 py-1 rounded-lg">Periode: {{ date('F Y') }}</span>
        </div>
    </div>

    <div class="relative bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-xl shadow-gray-100/50 overflow-hidden group">
        <div class="absolute -right-6 -bottom-6 text-9xl opacity-5 group-hover:scale-110 transition-transform duration-500">🧾</div>
        <h3 class="text-gray-400 text-xs font-black uppercase tracking-[0.2em] mb-2">Volume Transaksi</h3>
        <p class="text-4xl font-black text-gray-800 italic">{{ $totalTransaksi }}</p>
        <div class="mt-4 flex items-center gap-2 text-xs text-gray-400">
            <span class="bg-gray-100 px-2 py-1 rounded-lg">Siklus Hidup Sistem</span>
        </div>
    </div>
</div>

<div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden mb-10">
    <div class="px-10 py-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
        <h2 class="text-xl font-black text-gray-800 tracking-tight">Riwayat Kas Masuk ✨</h2>
        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-4 py-2 rounded-full uppercase">5 Transaksi Terakhir</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-gray-400 text-[10px] uppercase font-black tracking-[0.2em]">
                    <th class="px-10 py-6">Waktu Transaksi</th>
                    <th class="px-10 py-6">Pelanggan</th>
                    <th class="px-10 py-6">Metode</th>
                    <th class="px-10 py-6 text-right">Nominal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($transaksiTerbaru as $t)
                <tr class="hover:bg-blue-50/20 transition-colors group">
                    <td class="px-10 py-6 text-sm text-gray-500 font-medium">
                        {{ \Carbon\Carbon::parse($t->tanggalTransaksi)->format('d M Y') }}
                        <span class="block text-[10px] text-gray-300">{{ \Carbon\Carbon::parse($t->tanggalTransaksi)->format('H:i') }} WIB</span>
                    </td>
                    <td class="px-10 py-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-xs group-hover:bg-blue-600 group-hover:text-white transition-all">
                                {{ substr($t->pesanan->user->nama, 0, 1) }}
                            </div>
                            <span class="font-bold text-gray-700">{{ $t->pesanan->user->nama }}</span>
                        </div>
                    </td>
                    <td class="px-10 py-6">
                        @php
                            $methodColor = match($t->metodePembayaran) {
                                'QRIS' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                'Tunai' => 'bg-amber-50 text-amber-600 border-amber-100',
                                default => 'bg-gray-50 text-gray-600 border-gray-100'
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase border {{ $methodColor }}">
                            {{ $t->metodePembayaran }}
                        </span>
                    </td>
                    <td class="px-10 py-6 text-right">
                        <span class="text-lg font-black text-emerald-600">+ Rp {{ number_format($t->totalBayar, 0, ',', '.') }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-10 py-20 text-center text-gray-400 font-medium italic">Belum ada aliran kas masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="hidden print:block mt-20 text-center border-t pt-10">
    <div class="flex justify-between px-20 text-sm font-bold">
        <div>
            <p class="mb-20">Dicetak Oleh Admin,</p>
            <p>( ____________________ )</p>
        </div>
        <div>
            <p class="mb-20">Mengetahui Pemilik,</p>
            <p>( ____________________ )</p>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        body { background-color: white !important; }
        .rounded-[2.5rem], .rounded-[3rem] { border-radius: 1rem !important; }
        .shadow-xl { shadow: none !important; }
    }
</style>
@endsection