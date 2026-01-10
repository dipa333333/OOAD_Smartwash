@extends('layouts.app')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h1 class="text-3xl font-black text-gray-800 tracking-tight">Laporan Keuangan 📈</h1>
        <p class="text-gray-500 font-medium italic text-sm">Data tahun {{ $tahunTerpilih }} terpantau aman.</p>
    </div>

    <div class="flex flex-wrap items-center gap-3 no-print">
        <form action="{{ route('admin.laporan') }}" method="GET" id="formFilter" class="flex gap-2 bg-white p-2 rounded-2xl shadow-sm border border-gray-100">
            <select name="bulan" onchange="this.form.submit()" class="bg-transparent border-none text-xs font-black text-gray-700 focus:ring-0 cursor-pointer">
                @for($m=1; $m<=12; $m++)
                    <option value="{{ $m }}" {{ (int)$bulanTerpilih == $m ? 'selected' : '' }}>
                        {{ Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>

            <div class="w-[1px] h-6 bg-gray-200"></div>

            <select name="tahun" onchange="this.form.submit()" class="bg-transparent border-none text-xs font-black text-gray-700 focus:ring-0 cursor-pointer">
                @foreach($listTahun as $t)
                    <option value="{{ $t }}" {{ (int)$tahunTerpilih == $t ? 'selected' : '' }}>
                        Tahun {{ $t }}
                    </option>
                @endforeach
            </select>
        </form>

        <button onclick="window.print()" class="flex items-center gap-2 bg-white text-gray-700 font-bold px-5 py-2.5 rounded-2xl shadow-sm border border-gray-200 hover:bg-gray-50 transition">
            <span>🖨️</span> Cetak
        </button>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 bg-gray-800 text-white font-bold px-5 py-2.5 rounded-2xl shadow-lg hover:bg-gray-900 transition">
            Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="relative bg-gradient-to-br from-blue-600 to-blue-700 p-8 rounded-[2.5rem] text-white shadow-xl shadow-blue-200 overflow-hidden group">
        <div class="absolute -right-6 -bottom-6 text-9xl opacity-10 group-hover:scale-110 transition-transform duration-500">💰</div>
        <h3 class="text-blue-100 text-[10px] font-black uppercase tracking-[0.2em] mb-2">Omzet Hari Ini</h3>
        <p class="text-4xl font-black italic">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</p>
        <div class="mt-4 flex items-center gap-2 text-xs text-blue-200">
            <span class="bg-blue-500/30 px-2 py-1 rounded-lg">Real-time: {{ date('H:i') }}</span>
        </div>
    </div>

    <div class="relative bg-gradient-to-br from-emerald-500 to-teal-600 p-8 rounded-[2.5rem] text-white shadow-xl shadow-emerald-100 overflow-hidden group border-4 border-white/20">
        <div class="absolute -right-6 -bottom-6 text-9xl opacity-10 group-hover:scale-110 transition-transform duration-500">📊</div>
        <h3 class="text-emerald-50 text-[10px] font-black uppercase tracking-[0.2em] mb-2">
            Total {{ Carbon\Carbon::create()->month((int)$bulanTerpilih)->translatedFormat('F') }} {{ $tahunTerpilih }}
        </h3>
        <p class="text-4xl font-black italic">Rp {{ number_format($pendapatanFilter, 0, ',', '.') }}</p>
        <div class="mt-4 flex items-center gap-2 text-xs text-emerald-100">
            <span class="bg-emerald-400/30 px-2 py-1 rounded-lg italic">Periode Terpilih</span>
        </div>
    </div>

    <div class="relative bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-xl shadow-gray-100/50 overflow-hidden group">
        <div class="absolute -right-6 -bottom-6 text-9xl opacity-5 group-hover:scale-110 transition-transform duration-500">🧾</div>
        <h3 class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em] mb-2">Total Transaksi Lunas</h3>
        <p class="text-4xl font-black text-gray-800 italic">{{ $totalTransaksiGlobal }}</p>
        <div class="mt-4 flex items-center gap-2 text-xs text-gray-400">
            <span class="bg-gray-100 px-2 py-1 rounded-lg italic">Database Lifecycle</span>
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-gray-100 mb-10 overflow-hidden relative group">
    <div class="flex justify-between items-center mb-6 px-4">
        <div>
            <h2 class="text-xl font-black text-gray-800 tracking-tight">Tren Pendapatan Harian 📈</h2>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">
                Periode: {{ Carbon\Carbon::create()->month((int)$bulanTerpilih)->translatedFormat('F') }} {{ $tahunTerpilih }}
            </p>
        </div>
        <div class="bg-blue-50 px-3 py-1 rounded-lg text-[10px] font-bold text-blue-600 uppercase tracking-widest animate-pulse">
            Live Data
        </div>
    </div>

    <div class="relative h-72 w-full">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

<div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden mb-10">
    <div class="px-10 py-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
        <h2 class="text-xl font-black text-gray-800 tracking-tight">Riwayat Kas Periode {{ $tahunTerpilih }} ✨</h2>
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
                        {{ $t->created_at->format('d M Y') }}
                        <span class="block text-[10px] text-gray-300">{{ $t->created_at->format('H:i') }} WIB</span>
                    </td>
                    <td class="px-10 py-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-xs group-hover:bg-blue-600 group-hover:text-white transition-all">
                                {{ substr($t->pesanan->user->nama ?? 'U', 0, 1) }}
                            </div>
                            <span class="font-bold text-gray-700">{{ $t->pesanan->user->nama ?? 'Umum' }}</span>
                        </div>
                    </td>
                    <td class="px-10 py-6">
                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase border bg-gray-50 text-gray-600 border-gray-100">
                            {{ $t->metodePembayaran }}
                        </span>
                    </td>
                    <td class="px-10 py-6 text-right">
                        <span class="text-lg font-black text-emerald-600">+ Rp {{ number_format($t->totalBayar, 0, ',', '.') }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-10 py-20 text-center text-gray-400 font-medium italic">
                        Tidak ada data transaksi untuk periode ini.
                    </td>
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
        .shadow-xl { box-shadow: none !important; }
    }

    @media print {
        #revenueChart, .bg-white.p-6.rounded-\[2\.5rem\] { display: none !important; }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');

        const labels = {!! json_encode($chartLabels) !!};
        const data = {!! json_encode($chartTotal) !!};

        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(37, 99, 235, 0.4)');
        gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Omzet (Rp)',
                    data: data,
                    borderColor: '#2563eb',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#2563eb',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        titleFont: { size: 14 },
                        bodyFont: { size: 14, weight: 'bold' },
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                            },
                            title: function(context) {
                                return 'Tanggal ' + context[0].label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11, weight: 'bold' }, color: '#94a3b8' }
                    },
                    y: {
                        border: { display: false },
                        grid: { color: '#f1f5f9', borderDash: [5, 5] },
                        ticks: {
                            font: { size: 10, weight: 'bold' },
                            color: '#94a3b8',
                            callback: function(value) {
                                return (value / 1000) + 'k'; 
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        });
    });
</script>
@endsection