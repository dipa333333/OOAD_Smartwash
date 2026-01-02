@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-blue-600 mb-6 font-bold transition">
        <span>⬅️</span> Kembali ke Dashboard
    </a>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">

        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-gray-200 border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-100 rounded-bl-[100px] -z-0"></div>

            <h2 class="text-2xl font-black text-gray-800 mb-1 relative z-10">Rincian Order</h2>
            <p class="text-sm text-gray-400 font-bold uppercase tracking-widest mb-8 relative z-10">#{{ $pesanan->idPesanan }}</p>

            <div class="space-y-6 relative z-10">
                <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                    <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-black text-xl">
                        {{ substr($pesanan->user->nama, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Pelanggan</p>
                        <p class="font-black text-gray-800 text-lg leading-none">{{ $pesanan->user->nama }}</p>
                    </div>
                </div>

                <div class="border-t border-dashed border-gray-200 pt-6">
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-4">Item Laundry</p>
                    <ul class="space-y-3">
                        @foreach($pesanan->details as $detail)
                        <li class="flex justify-between items-center text-sm">
                            <span class="font-medium text-gray-600">
                                <span class="font-bold text-blue-600">{{ $detail->jumlah }}{{ $detail->layanan->satuan }}</span>
                                x {{ $detail->layanan->namaLayanan }}
                            </span>
                            <span class="font-bold text-gray-800">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="bg-blue-600 p-6 rounded-2xl text-white shadow-lg shadow-blue-200 mt-6 text-center">
                    <p class="text-blue-200 text-xs font-bold uppercase tracking-widest mb-1">Total Tagihan</p>
                    <h1 class="text-4xl font-black">Rp {{ number_format($pesanan->totalHarga, 0, ',', '.') }}</h1>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-gray-200 border border-gray-100">
            <h2 class="text-xl font-black text-gray-800 mb-6">Proses Pembayaran 💳</h2>

            <form action="{{ route('admin.pesanan.process', $pesanan->idPesanan) }}" method="POST" id="paymentForm">
                @csrf
                <input type="hidden" name="total_bayar" id="totalBayar" value="{{ $pesanan->totalHarga }}">

                <div class="mb-6">
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Metode Pembayaran</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="metode" value="Tunai" class="peer sr-only" checked onchange="toggleMetode()">
                            <div class="p-4 rounded-xl border-2 border-gray-100 bg-gray-50 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 font-bold text-center transition">
                                💵 Tunai (Cash)
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="metode" value="QRIS" class="peer sr-only" onchange="toggleMetode()">
                            <div class="p-4 rounded-xl border-2 border-gray-100 bg-gray-50 peer-checked:border-purple-500 peer-checked:bg-purple-50 peer-checked:text-purple-700 font-bold text-center transition">
                                📱 QRIS / Transfer
                            </div>
                        </label>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Nominal Diterima</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">Rp</span>
                        <input type="number" name="uang_bayar" id="uangBayar"
                            class="w-full pl-12 pr-4 py-4 bg-gray-50 border-none rounded-2xl text-2xl font-black text-gray-800 focus:ring-4 focus:ring-blue-100 outline-none transition"
                            placeholder="0" required oninput="hitungKembalian()">
                    </div>

                    <div class="flex flex-wrap gap-2 mt-3" id="quickButtons">
                        <button type="button" onclick="setUang('{{ $pesanan->totalHarga }}')" class="bg-blue-100 text-blue-700 px-4 py-2 rounded-lg text-xs font-bold hover:bg-blue-200 transition">Uang Pas</button>
                        <button type="button" onclick="setUang(50000)" class="bg-gray-100 text-gray-600 px-3 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">50rb</button>
                        <button type="button" onclick="setUang(100000)" class="bg-gray-100 text-gray-600 px-3 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">100rb</button>
                    </div>
                </div>

                <div class="bg-emerald-50 p-6 rounded-2xl border border-emerald-100 text-center mb-8 transition-all duration-300" id="boxKembalian">
                    <p class="text-emerald-600 text-xs font-black uppercase tracking-widest mb-1">Kembalian</p>
                    <h3 class="text-3xl font-black text-emerald-700" id="textKembalian">Rp 0</h3>
                </div>

                <button type="submit" id="btnBayar" disabled class="w-full bg-gray-300 text-gray-500 font-black py-4 rounded-2xl text-lg shadow-none cursor-not-allowed transition-all">
                    Bayar Sekarang 🚀
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const totalTagihan = parseInt(document.getElementById('totalBayar').value);
    const inputUang = document.getElementById('uangBayar');
    const textKembalian = document.getElementById('textKembalian');
    const btnBayar = document.getElementById('btnBayar');
    const boxKembalian = document.getElementById('boxKembalian');

    // Format Rupiah
    const formatRupiah = (angka) => {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
    }

    // Fungsi Quick Button
    function setUang(jumlah) {
        inputUang.value = jumlah;
        hitungKembalian();
    }

    // Logic Hitung Kembalian Real-time
    function hitungKembalian() {
        let bayar = parseInt(inputUang.value) || 0;
        let kembalian = bayar - totalTagihan;

        if (bayar >= totalTagihan) {
            // Uang Cukup
            textKembalian.innerText = formatRupiah(kembalian);
            textKembalian.classList.remove('text-red-500');
            textKembalian.classList.add('text-emerald-700');

            boxKembalian.classList.remove('bg-red-50', 'border-red-100');
            boxKembalian.classList.add('bg-emerald-50', 'border-emerald-100');

            // Aktifkan Tombol
            btnBayar.disabled = false;
            btnBayar.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed', 'shadow-none');
            btnBayar.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700', 'shadow-xl', 'shadow-blue-200', 'transform', 'hover:scale-[1.02]');
        } else {
            // Uang Kurang
            textKembalian.innerText = "Kurang " + formatRupiah(Math.abs(kembalian));
            textKembalian.classList.remove('text-emerald-700');
            textKembalian.classList.add('text-red-500');

            boxKembalian.classList.remove('bg-emerald-50', 'border-emerald-100');
            boxKembalian.classList.add('bg-red-50', 'border-red-100');

            // Matikan Tombol
            btnBayar.disabled = true;
            btnBayar.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed', 'shadow-none');
            btnBayar.classList.remove('bg-blue-600', 'text-white', 'hover:bg-blue-700', 'shadow-xl', 'shadow-blue-200', 'transform', 'hover:scale-[1.02]');
        }
    }

    // Jika pilih QRIS, otomatis isi uang pas (karena transfer pasti pas)
    function toggleMetode() {
        const radios = document.getElementsByName('metode');
        let selected;
        for(let r of radios) { if(r.checked) selected = r.value; }

        if(selected === 'QRIS') {
            setUang(totalTagihan);
            document.getElementById('quickButtons').style.display = 'none'; // Sembunyikan tombol cash
            inputUang.readOnly = true; // Kunci input manual
            inputUang.classList.add('bg-gray-100');
        } else {
            inputUang.value = ''; // Reset
            hitungKembalian();
            document.getElementById('quickButtons').style.display = 'flex';
            inputUang.readOnly = false;
            inputUang.classList.remove('bg-gray-100');
            inputUang.focus();
        }
    }

    // Fokus otomatis ke input saat halaman dimuat
    window.onload = function() {
        inputUang.focus();
    }
</script>
@endsection