@extends('layouts.app')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-black text-gray-800 tracking-tight">Katalog Layanan 🛠️</h1>
        <p class="text-gray-500 font-medium">Atur daftar harga dan jenis layanan laundry Anda.</p>
    </div>
    <a href="{{ route('admin.layanan.create') }}" class="flex items-center gap-2 bg-blue-600 text-white font-bold px-6 py-3 rounded-2xl shadow-lg shadow-blue-200 hover:bg-blue-700 transition transform hover:-translate-y-1">
        <span class="text-xl">+</span> Tambah Layanan Baru
    </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($layanans as $layanan)
    <div class="group bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 hover:shadow-2xl hover:shadow-blue-100 transition-all duration-300 relative overflow-hidden">

        <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center text-4xl">
            ✨
        </div>

        <div class="relative z-10">
            <div class="w-14 h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-2xl shadow-lg mb-6 group-hover:rotate-6 transition-transform">
                @if(stripos($layanan->namaLayanan, 'Karpet') !== false) 🏠
                @elseif(stripos($layanan->namaLayanan, 'Sepatu') !== false) 👟
                @elseif(stripos($layanan->namaLayanan, 'Express') !== false) ⚡
                @else 👕 @endif
            </div>

            <h3 class="text-xl font-black text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">
                {{ $layanan->namaLayanan }}
            </h3>

            <div class="flex items-baseline gap-1 mb-8">
                <span class="text-sm font-bold text-gray-400">Rp</span>
                <span class="text-3xl font-black text-gray-900">{{ number_format($layanan->harga, 0, ',', '.') }}</span>
                <span class="text-xs font-medium text-gray-400">/ unit</span>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.layanan.edit', $layanan->idLayanan) }}" class="flex-1 bg-gray-100 text-gray-700 font-bold py-3 rounded-xl text-center hover:bg-amber-100 hover:text-amber-700 transition">
                    Edit
                </a>
                <form action="{{ route('admin.layanan.destroy', $layanan->idLayanan) }}" method="POST" class="inline" onsubmit="return confirm('Hapus layanan ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-3 bg-gray-50 text-gray-400 rounded-xl hover:bg-red-50 hover:text-red-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full bg-white rounded-[3rem] p-20 text-center border-2 border-dashed border-gray-200">
        <div class="text-6xl mb-4">📦</div>
        <h3 class="text-xl font-bold text-gray-800">Katalog Kosong</h3>
        <p class="text-gray-400">Anda belum menambahkan layanan apa pun.</p>
    </div>
    @endforelse
</div>
@endsection