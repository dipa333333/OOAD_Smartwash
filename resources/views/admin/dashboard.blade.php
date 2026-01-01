@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Ringkasan Operasional 📊</h1>
        <p class="text-gray-500">Selamat datang kembali, Admin. Pantau dan kelola pesanan hari ini.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.laporan') }}" class="flex items-center gap-2 bg-white text-gray-700 font-bold px-5 py-2.5 rounded-xl shadow-sm border border-gray-200 hover:bg-gray-50 transition">
            <span>📊</span> Laporan Keuangan
        </a>
        <a href="{{ route('admin.layanan.index') }}" class="flex items-center gap-2 bg-blue-600 text-white font-bold px-5 py-2.5 rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 transition">
            <span>🛠️</span> Kelola Layanan
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="relative bg-white p-6 rounded-3xl shadow-sm border-b-4 border-blue-500 overflow-hidden group hover:shadow-xl transition-all duration-300">
        <div class="absolute -right-4 -top-4 text-6xl opacity-10 group-hover:rotate-12 transition-transform">📩</div>
        <h3 class="text-gray-400 text-xs uppercase font-black tracking-widest">Pesanan Baru</h3>
        <p class="text-4xl font-black text-gray-800 mt-2">{{ $stats['masuk'] }}</p>
        <p class="text-sm text-blue-600 font-medium mt-1">Perlu Validasi Segera</p>
    </div>

    <div class="relative bg-white p-6 rounded-3xl shadow-sm border-b-4 border-amber-500 overflow-hidden group hover:shadow-xl transition-all duration-300">
        <div class="absolute -right-4 -top-4 text-6xl opacity-10 group-hover:rotate-12 transition-transform">⚙️</div>
        <h3 class="text-gray-400 text-xs uppercase font-black tracking-widest">Dalam Proses</h3>
        <p class="text-4xl font-black text-gray-800 mt-2">{{ $stats['proses'] }}</p>
        <p class="text-sm text-amber-600 font-medium mt-1">Sedang Dikerjakan</p>
    </div>

    <div class="relative bg-white p-6 rounded-3xl shadow-sm border-b-4 border-emerald-500 overflow-hidden group hover:shadow-xl transition-all duration-300">
        <div class="absolute -right-4 -top-4 text-6xl opacity-10 group-hover:rotate-12 transition-transform">💰</div>
        <h3 class="text-gray-400 text-xs uppercase font-black tracking-widest">Siap Ambil</h3>
        <p class="text-4xl font-black text-gray-800 mt-2">{{ $stats['siap_ambil'] }}</p>
        <p class="text-sm text-emerald-600 font-medium mt-1">Menunggu Pembayaran</p>
    </div>
</div>

<div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
        <h2 class="text-xl font-bold text-gray-800">Daftar Antrean Laundry</h2>
        <span class="bg-white px-4 py-1 rounded-full text-xs font-bold text-gray-500 border shadow-sm">
            Total: {{ count($pesanans) }} Pesanan
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-gray-400 text-xs uppercase tracking-widest">
                    <th class="px-8 py-4 font-black">Pelanggan</th>
                    <th class="px-8 py-4 font-black">Layanan & Total</th>
                    <th class="px-8 py-4 font-black">Status & Estimasi</th>
                    <th class="px-8 py-4 font-black text-center">Aksi Operasional</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pesanans as $pesanan)
                <tr class="group hover:bg-blue-50/30 transition-colors">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-md">
                                {{ substr($pesanan->user->nama, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-800">{{ $pesanan->user->nama }}</p>
                                <p class="text-xs text-gray-400">Order #{{ $pesanan->idPesanan }}</p>

                                @if($pesanan->user->nomorTelepon)
                                    @php
                                        $noHp = $pesanan->user->nomorTelepon;
                                        if(substr($noHp, 0, 1) == '0') $noHp = '62' . substr($noHp, 1);
                                        $pesanWA = "Halo Kak {$pesanan->user->nama}, pesanan #{$pesanan->idPesanan} statusnya: {$pesanan->statusPesanan}.";
                                    @endphp
                                    <a href="https://wa.me/{{ $noHp }}?text={{ urlencode($pesanWA) }}" target="_blank" class="text-[10px] text-green-600 font-bold hover:underline flex items-center gap-1 mt-1">
                                        🟢 WhatsApp Pelanggan
                                    </a>
                                @endif
                            </div>
                        </div>
                    </td>

                    <td class="px-8 py-6">
                        <p class="font-black text-gray-800 text-lg">Rp {{ number_format($pesanan->totalHarga, 0, ',', '.') }}</p>
                        @if($pesanan->transaksi)
                            <span class="inline-block px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-tighter">Lunas</span>
                        @else
                            <span class="inline-block px-2 py-0.5 rounded-md bg-rose-100 text-rose-700 text-[10px] font-black uppercase tracking-tighter">Belum Bayar</span>
                        @endif
                    </td>

                    <td class="px-8 py-6">
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
                        <span class="px-3 py-1 rounded-lg text-xs font-bold {{ $color[0] }} {{ $color[1] }}">
                            {{ $pesanan->statusPesanan }}
                        </span>
                        @if($pesanan->estimasiSelesai)
                            <p class="text-[10px] text-gray-400 mt-2 font-medium">Est: {{ $pesanan->estimasiSelesai->format('d M Y') }}</p>
                        @endif
                    </td>

                    <td class="px-8 py-6">
                        <div class="flex flex-col items-center gap-2">
                            <div class="flex gap-2 w-full justify-center">
                                <a href="{{ route('admin.pesanan.show', $pesanan->idPesanan) }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition" title="Detail">👁️</a>
                                <a href="{{ route('admin.pesanan.label', $pesanan->idPesanan) }}" target="_blank" class="p-2 bg-gray-800 rounded-lg hover:bg-black text-white transition" title="Cetak Label">🏷️</a>
                            </div>

                            <form action="{{ route('admin.pesanan.update', $pesanan->idPesanan) }}" method="POST" class="w-full">
                                @csrf @method('PATCH')
                                @if($pesanan->statusPesanan == 'Menunggu Validasi')
                                    <div class="flex flex-col gap-1">
                                        <input type="date" name="estimasi" required class="text-[10px] border border-gray-200 rounded-lg p-1.5 focus:ring-2 focus:ring-blue-500 outline-none">
                                        <button name="status" value="Antre" class="w-full bg-blue-600 text-white text-[10px] font-bold py-2 rounded-lg hover:bg-blue-700 transition">VALIDASI</button>
                                    </div>
                                @elseif($pesanan->statusPesanan == 'Antre')
                                    <button name="status" value="Cuci" class="w-full bg-indigo-600 text-white text-[10px] font-bold py-2 rounded-lg">MULAI CUCI</button>
                                @elseif($pesanan->statusPesanan == 'Cuci')
                                    <button name="status" value="Setrika" class="w-full bg-purple-600 text-white text-[10px] font-bold py-2 rounded-lg">MULAI SETRIKA</button>
                                @elseif($pesanan->statusPesanan == 'Setrika')
                                    <button name="status" value="Selesai" class="w-full bg-emerald-600 text-white text-[10px] font-bold py-2 rounded-lg">SELESAI</button>
                                @endif
                            </form>

                            @if($pesanan->statusPesanan == 'Selesai')
                                @if($pesanan->transaksi)
                                    <a href="{{ route('admin.pesanan.struk', $pesanan->idPesanan) }}" target="_blank" class="w-full text-center bg-amber-500 text-white text-[10px] font-bold py-2 rounded-lg">CETAK STRUK</a>
                                @else
                                    <a href="{{ route('admin.pesanan.bayar', $pesanan->idPesanan) }}" class="w-full text-center bg-emerald-600 text-white text-[10px] font-bold py-2 rounded-lg animate-pulse shadow-lg shadow-emerald-100">PROSES BAYAR</a>
                                @endif
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-20 text-center">
                        <div class="text-gray-300 mb-2 text-5xl">📭</div>
                        <p class="text-gray-500 font-medium">Belum ada pesanan yang masuk hari ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection