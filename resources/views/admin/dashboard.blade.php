@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-black text-gray-800 tracking-tight">Ringkasan Operasional 📊</h1>
        <p class="text-gray-500 font-medium italic text-sm">Update terakhir: {{ now()->format('d M Y, H:i') }} WIB</p>
    </div>
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('admin.laporan') }}" class="flex items-center gap-2 bg-white text-gray-700 font-bold px-5 py-3 rounded-2xl shadow-sm border border-gray-100 hover:bg-gray-50 transition group">
            <span class="group-hover:rotate-12 transition-transform">📊</span> Laporan Keuangan
        </a>
        <a href="{{ route('admin.layanan.index') }}" class="flex items-center gap-2 bg-blue-600 text-white font-bold px-5 py-3 rounded-2xl shadow-xl shadow-blue-200 hover:bg-blue-700 transition group">
            <span class="group-hover:rotate-12 transition-transform">🛠️</span> Kelola Layanan
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="relative bg-white p-6 rounded-[2.5rem] shadow-sm border-b-8 border-blue-500 overflow-hidden group hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
        <div class="absolute -right-4 -top-4 text-6xl opacity-10 group-hover:rotate-12 transition-transform grayscale group-hover:grayscale-0">📩</div>
        <h3 class="text-gray-400 text-[10px] uppercase font-black tracking-[0.2em]">Pesanan Baru</h3>
        <p class="text-5xl font-black text-gray-800 mt-2 tracking-tighter">{{ $stats['masuk'] }}</p>
        <p class="text-xs text-blue-600 font-bold mt-2 flex items-center gap-1">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-ping"></span> Perlu Validasi
        </p>
    </div>

    <div class="relative bg-white p-6 rounded-[2.5rem] shadow-sm border-b-8 border-amber-500 overflow-hidden group hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
        <div class="absolute -right-4 -top-4 text-6xl opacity-10 group-hover:rotate-12 transition-transform grayscale group-hover:grayscale-0">⚙️</div>
        <h3 class="text-gray-400 text-[10px] uppercase font-black tracking-[0.2em]">Dalam Proses</h3>
        <p class="text-5xl font-black text-gray-800 mt-2 tracking-tighter">{{ $stats['proses'] }}</p>
        <p class="text-xs text-amber-600 font-bold mt-2 italic">Sedang dikerjakan...</p>
    </div>

    <div class="relative bg-white p-6 rounded-[2.5rem] shadow-sm border-b-8 border-emerald-500 overflow-hidden group hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
        <div class="absolute -right-4 -top-4 text-6xl opacity-10 group-hover:rotate-12 transition-transform grayscale group-hover:grayscale-0">💰</div>
        <h3 class="text-gray-400 text-[10px] uppercase font-black tracking-[0.2em]">Siap Ambil</h3>
        <p class="text-5xl font-black text-gray-800 mt-2 tracking-tighter">{{ $stats['siap_ambil'] }}</p>
        <p class="text-xs text-emerald-600 font-bold mt-2">Menunggu Pembayaran</p>
    </div>
</div>

<div class="bg-white rounded-[3rem] shadow-xl shadow-gray-100 border border-gray-50 overflow-hidden">
    <div class="px-10 py-8 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-center gap-4 bg-gray-50/30">
        <h2 class="text-2xl font-black text-gray-800 tracking-tight">Antrean Laundry</h2>
        <span class="bg-blue-600 px-6 py-2 rounded-2xl text-xs font-black text-white shadow-lg shadow-blue-100">
            Total: {{ count($pesanans) }} Antrean
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-gray-400 text-[10px] uppercase tracking-[0.2em] border-b border-gray-50">
                    <th class="px-10 py-5 font-black">Pelanggan</th>
                    <th class="px-10 py-5 font-black">Layanan & Total</th>
                    <th class="px-10 py-5 font-black">Status & Estimasi</th>
                    <th class="px-10 py-5 font-black text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pesanans as $pesanan)
                <tr class="group hover:bg-blue-50/40 transition-all duration-300">
                    <td class="px-10 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-700 flex items-center justify-center text-white font-black shadow-lg text-lg">
                                {{ substr($pesanan->user->nama, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-black text-gray-800 text-base leading-none mb-1">{{ $pesanan->user->nama }}</p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">ID #{{ $pesanan->idPesanan }}</p>

                                @if($pesanan->user->nomorTelepon)
                                    @php
                                        $noHp = $pesanan->user->nomorTelepon;
                                        if(substr($noHp, 0, 1) == '0') $noHp = '62' . substr($noHp, 1);
                                        $pesanWA = "Halo Kak {$pesanan->user->nama}, pesanan #{$pesanan->idPesanan} statusnya: {$pesanan->statusPesanan}.";
                                    @endphp
                                    <a href="https://wa.me/{{ $noHp }}?text={{ urlencode($pesanWA) }}" target="_blank" class="inline-flex items-center gap-1.5 text-[10px] text-emerald-600 font-black hover:text-emerald-700 mt-2 bg-emerald-50 px-2 py-1 rounded-lg transition-colors uppercase">
                                        <span class="text-xs">💬</span> Hubungi Pelanggan
                                    </a>
                                @endif
                            </div>
                        </div>
                    </td>

                    <td class="px-10 py-6">
                        <p class="font-black text-gray-900 text-xl tracking-tight">Rp {{ number_format($pesanan->totalHarga, 0, ',', '.') }}</p>
                        @if($pesanan->transaksi)
                            <span class="inline-flex items-center gap-1 mt-1 text-[9px] font-black uppercase tracking-widest text-emerald-600">
                                <span class="w-1 h-1 rounded-full bg-emerald-600"></span> LUNAS
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 mt-1 text-[9px] font-black uppercase tracking-widest text-rose-500">
                                <span class="w-1 h-1 rounded-full bg-rose-500 animate-pulse"></span> TAGIHAN
                            </span>
                        @endif
                    </td>

                    <td class="px-10 py-6">
                        @php
                            $statusMap = [
                                'Menunggu Validasi' => ['bg-gray-100', 'text-gray-600'],
                                'Antre' => ['bg-blue-100', 'text-blue-700'],
                                'Cuci' => ['bg-indigo-100', 'text-indigo-700'],
                                'Setrika' => ['bg-purple-100', 'text-purple-700'],
                                'Selesai' => ['bg-emerald-100', 'text-emerald-700'],
                            ];
                            $color = $statusMap[$pesanan->statusPesanan] ?? ['bg-gray-100', 'text-gray-600'];
                        @endphp
                        <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $color[0] }} {{ $color[1] }}">
                            {{ $pesanan->statusPesanan }}
                        </span>
                        @if($pesanan->estimasiSelesai)
                            <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase tracking-tighter italic">📅 Est: {{ $pesanan->estimasiSelesai->format('d/m/y') }}</p>
                        @endif
                    </td>

                    <td class="px-10 py-6">
                        <div class="flex flex-col gap-2 max-w-[140px] mx-auto">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.pesanan.show', $pesanan->idPesanan) }}" class="flex-1 bg-gray-100 text-center py-2 rounded-xl hover:bg-gray-200 transition text-sm" title="Detail">👁️</a>
                                <a href="{{ route('admin.pesanan.label', $pesanan->idPesanan) }}" target="_blank" class="flex-1 bg-gray-800 text-center py-2 rounded-xl hover:bg-black text-white transition text-sm" title="Label">🏷️</a>
                            </div>

                            <form action="{{ route('admin.pesanan.update', $pesanan->idPesanan) }}" method="POST" class="w-full">
                                @csrf @method('PATCH')
                                @if($pesanan->statusPesanan == 'Menunggu Validasi')
                                    <div class="flex flex-col gap-2 p-2 bg-blue-50 rounded-2xl border border-blue-100">
                                        <input type="date" name="estimasi" required class="text-[10px] bg-white border-none rounded-lg p-2 focus:ring-2 focus:ring-blue-500 outline-none font-bold">
                                        <button name="status" value="Antre" class="w-full bg-blue-600 text-white text-[10px] font-black py-2.5 rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-100 transition uppercase tracking-widest">Validasi</button>
                                    </div>
                                @elseif($pesanan->statusPesanan == 'Antre')
                                    <button name="status" value="Cuci" class="w-full bg-indigo-600 text-white text-[10px] font-black py-3 rounded-xl hover:bg-indigo-700 transition uppercase tracking-widest">Mulai Cuci 🌊</button>
                                @elseif($pesanan->statusPesanan == 'Cuci')
                                    <button name="status" value="Setrika" class="w-full bg-purple-600 text-white text-[10px] font-black py-3 rounded-xl hover:bg-purple-700 transition uppercase tracking-widest">Setrika 🔥</button>
                                @elseif($pesanan->statusPesanan == 'Setrika')
                                    <button name="status" value="Selesai" class="w-full bg-emerald-600 text-white text-[10px] font-black py-3 rounded-xl hover:bg-emerald-700 transition uppercase tracking-widest">Selesai ✨</button>
                                @endif
                            </form>

                            @if($pesanan->statusPesanan == 'Selesai')
                                @if($pesanan->transaksi)
                                    <a href="{{ route('admin.pesanan.struk', $pesanan->idPesanan) }}" target="_blank" class="w-full text-center bg-amber-500 text-white text-[10px] font-black py-3 rounded-xl hover:bg-amber-600 transition shadow-lg shadow-amber-100 uppercase tracking-widest">Cetak Struk</a>
                                @else
                                    <a href="{{ route('admin.pesanan.bayar', $pesanan->idPesanan) }}" class="w-full text-center bg-emerald-600 text-white text-[10px] font-black py-3 rounded-xl animate-pulse shadow-xl shadow-emerald-200 uppercase tracking-widest hover:scale-105 transition-transform">Proses Bayar</a>
                                @endif
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-32 text-center">
                        <div class="text-gray-200 mb-4 text-7xl animate-bounce">📭</div>
                        <h3 class="text-xl font-black text-gray-800">Antrean Kosong</h3>
                        <p class="text-gray-400 font-medium">Belum ada pesanan yang masuk hari ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-10 py-6 border-t border-gray-50 bg-gray-50/30">
        {{ $pesanans->links('pagination.admin-theme') }}
    </div>
</div>
@endsection