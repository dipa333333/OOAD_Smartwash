@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-gray-800 tracking-tight">Tambah Layanan ✨</h1>
        <p class="text-gray-500 font-medium italic text-sm">Pastikan harga sudah kompetitif ya, Admin!</p>
    </div>

    <div class="bg-white rounded-[2.5rem] p-10 shadow-xl shadow-gray-100 border border-gray-50">
        <form action="{{ route('admin.layanan.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-3 ml-1">Nama Layanan</label>
                    <input type="text" name="namaLayanan" required
                        class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-100 transition font-bold text-gray-800"
                        placeholder="Misal: Cuci Kiloan Reguler">
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-3 ml-1">Harga Satuan (Rp)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-6 flex items-center font-bold text-gray-400">Rp</span>
                        <input type="number" name="harga" required
                            class="w-full pl-14 pr-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-100 transition font-black text-gray-900 text-2xl"
                            placeholder="0">
                    </div>
                </div>

                <div class="pt-4 flex gap-3">
                    <a href="{{ route('admin.layanan.index') }}" class="flex-1 text-center py-4 text-gray-500 font-bold hover:bg-gray-50 rounded-2xl transition">Batal</a>
                    <button type="submit" class="flex-[2] bg-blue-600 text-white font-black py-4 rounded-2xl shadow-xl shadow-blue-200 hover:bg-blue-700 transition transform hover:-translate-y-1 uppercase tracking-widest">
                        Simpan Layanan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection