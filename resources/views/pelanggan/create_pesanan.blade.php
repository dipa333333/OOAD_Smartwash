@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    <div class="mb-10 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-gray-800 tracking-tight">Buat Pesanan ✨</h1>
            <p class="text-gray-500 font-medium">Pilih jenis layanan dan tentukan jumlahnya.</p>
        </div>
        <a href="{{ route('pelanggan.dashboard') }}" class="text-gray-400 hover:text-gray-600 font-bold text-sm"> Kembali</a>
    </div>

    <form action="{{ route('pelanggan.pesan.store') }}" method="POST" id="formOrder">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($layanans as $index => $layanan)
                <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 hover:border-blue-500 transition-all group relative overflow-hidden">
                    <div class="absolute -right-2 -top-2 text-4xl opacity-5 group-hover:opacity-10 transition-opacity uppercase font-black">
                        {{ substr($layanan->namaLayanan, 0, 1) }}
                    </div>

                    <div class="flex items-start gap-4 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-inner">
                            @if(stripos($layanan->namaLayanan, 'Sepatu') !== false) 👟
                            @elseif(stripos($layanan->namaLayanan, 'Bedcover') !== false) 🛏️
                            @elseif(stripos($layanan->namaLayanan, 'Setrika') !== false) 🔥
                            @else 👕 @endif
                        </div>
                        <div>
                            <h3 class="font-black text-gray-800 leading-tight">{{ $layanan->namaLayanan }}</h3>
                            <p class="text-blue-600 font-bold text-sm">Rp {{ number_format($layanan->harga, 0, ',', '.') }} <span class="text-gray-400 font-normal">/unit</span></p>
                        </div>
                    </div>

                    <input type="hidden" name="layanan[{{ $index }}]" value="{{ $layanan->idLayanan }}">
                    <div class="relative">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 block">Jumlah (Kg/Pcs)</label>
                        <input type="number"
                               name="jumlah[{{ $index }}]"
                               value="0"
                               min="0"
                               data-harga="{{ $layanan->harga }}"
                               class="input-jumlah w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-lg font-black text-gray-800 focus:ring-2 focus:ring-blue-500 transition"
                               placeholder="0">
                    </div>
                </div>
                @endforeach
            </div>

            <div class="lg:col-span-1 sticky top-24">
                <div class="bg-gray-900 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-blue-200 overflow-hidden relative">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-600 opacity-20 blur-3xl"></div>

                    <div class="relative z-10">
                        <h2 class="text-xs font-black uppercase tracking-[0.3em] text-blue-400 mb-6 italic">Ringkasan Estimasi</h2>

                        <div class="space-y-4 mb-10" id="summary-list">
                            <p class="text-sm text-gray-500 italic">Belum ada item dipilih...</p>
                        </div>

                        <div class="pt-6 border-t border-white/10 mb-8">
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Total Biaya</p>
                            <div class="text-4xl font-black text-white">
                                Rp <span id="grand-total">0</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-black py-4 rounded-2xl shadow-xl transition transform hover:-translate-y-1 uppercase tracking-widest text-sm">
                            Kirim Pesanan 🚀
                        </button>
                    </div>
                </div>

                <div class="mt-4 p-4 bg-amber-50 rounded-2xl border border-amber-100 flex gap-3 items-start">
                    <span class="text-lg">💡</span>
                    <p class="text-[10px] text-amber-700 leading-tight">
                        <strong>Info:</strong> Pastikan data sudah benar. Admin akan melakukan validasi ulang saat barang diterima.
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.input-jumlah');
        const grandTotalDisplay = document.getElementById('grand-total');
        const summaryList = document.getElementById('summary-list');

        function updateSummary() {
            let total = 0;
            let summaryHTML = '';

            inputs.forEach(input => {
                const jumlah = parseInt(input.value) || 0;
                const harga = parseInt(input.getAttribute('data-harga'));
                const namaLayanan = input.closest('.bg-white').querySelector('h3').innerText;

                if (jumlah > 0) {
                    const subtotal = jumlah * harga;
                    total += subtotal;
                    summaryHTML += `
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-300 font-medium">${namaLayanan} (x${jumlah})</span>
                            <span class="font-bold text-white">Rp ${subtotal.toLocaleString('id-ID')}</span>
                        </div>
                    `;
                }
            });

            grandTotalDisplay.innerText = total.toLocaleString('id-ID');
            summaryList.innerHTML = summaryHTML || '<p class="text-sm text-gray-500 italic">Belum ada item dipilih...</p>';
        }

        inputs.forEach(input => {
            input.addEventListener('input', updateSummary);
        });
    });
</script>
@endsection