@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.layanan.index') }}" class="text-blue-600 font-bold text-sm flex items-center gap-2 hover:underline mb-2">
            ← Kembali ke Katalog
        </a>
        <h1 class="text-3xl font-black text-gray-800 tracking-tight">Edit Layanan ✏️</h1>
        <p class="text-gray-500 font-medium text-sm">Mengubah detail layanan: <span class="text-blue-600 font-bold">{{ $layanan->namaLayanan }}</span></p>
    </div>

    <div class="bg-white rounded-[2.5rem] p-10 shadow-xl shadow-gray-100 border border-gray-50 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-bl-[5rem] -mr-10 -mt-10 transition-transform group-hover:scale-110"></div>

        <form action="{{ route('admin.layanan.update', $layanan->idLayanan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-8 relative z-10">
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-3 ml-1">Nama Layanan</label>
                    <input type="text" name="namaLayanan" value="{{ old('namaLayanan', $layanan->namaLayanan) }}" required
                        class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-4 focus:ring-amber-100 transition font-bold text-gray-800 text-lg"
                        placeholder="Misal: Cuci Kiloan Reguler">
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-3 ml-1">Harga Satuan (Rp)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-6 flex items-center font-bold text-gray-400">Rp</span>
                        <input type="number" name="harga" value="{{ old('harga', $layanan->harga) }}" required
                            class="w-full pl-14 pr-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-4 focus:ring-amber-100 transition font-black text-gray-900 text-3xl"
                            placeholder="0">
                    </div>
                </div>

                <div class="pt-4 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('admin.layanan.index') }}" class="flex-1 text-center py-4 text-gray-500 font-bold hover:bg-gray-50 rounded-2xl transition order-2 sm:order-1">
                        Batalkan
                    </a>
                    <button type="submit" class="flex-[2] bg-amber-500 text-white font-black py-4 rounded-2xl shadow-xl shadow-amber-100 hover:bg-amber-600 transition transform hover:-translate-y-1 uppercase tracking-widest order-1 sm:order-2">
                        Update Layanan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="mt-8 p-6 bg-blue-50 rounded-2xl border border-blue-100 flex gap-4 items-center">
        <span class="text-2xl">💡</span>
        <p class="text-xs text-blue-700 leading-relaxed font-medium">
            <strong>Tips:</strong> Perubahan harga akan langsung berlaku untuk pesanan baru yang dibuat oleh pelanggan setelah tombol update ditekan. Pesanan yang sudah berjalan tidak akan terpengaruh.
        </p>
    </div>
</div>
@endsection