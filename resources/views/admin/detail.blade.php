@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow">
    <div class="flex justify-between items-center border-b pb-4 mb-4">
        <h2 class="text-2xl font-bold">Detail Pesanan #{{ $pesanan->idPesanan }}</h2>
        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Kembali</a>
    </div>

    <div class="grid grid-cols-2 gap-8">
        <div>
            <h3 class="font-bold text-gray-500 uppercase text-sm">Informasi Pelanggan</h3>
            <p class="text-lg font-bold">{{ $pesanan->user->nama }}</p>
            <p>{{ $pesanan->user->alamat ?? 'Alamat tidak tersedia' }}</p>
            <p>{{ $pesanan->user->nomorTelepon ?? '-' }}</p>
        </div>
        <div class="text-right">
            <h3 class="font-bold text-gray-500 uppercase text-sm">Status & Tanggal</h3>
            <span class="inline-block px-3 py-1 rounded bg-blue-100 text-blue-800 font-bold mb-2">
                {{ $pesanan->statusPesanan }}
            </span>
            <p class="text-sm text-gray-600">Dipesan: {{ \Carbon\Carbon::parse($pesanan->tanggalPesan)->format('d M Y') }}</p>
        </div>
    </div>

    <div class="mt-8">
        <h3 class="font-bold text-gray-700 mb-2">Rincian Layanan</h3>
        <table class="w-full border">
            <thead class="bg-gray-50">
                <tr>
                    <th class="border p-2 text-left">Layanan</th>
                    <th class="border p-2 text-center">Jumlah</th>
                    <th class="border p-2 text-right">Harga Satuan</th>
                    <th class="border p-2 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesanan->details as $detail)
                <tr>
                    <td class="border p-2">{{ $detail->layanan->namaLayanan }}</td>
                    <td class="border p-2 text-center">{{ $detail->jumlah }}</td>
                    <td class="border p-2 text-right">{{ number_format($detail->layanan->harga, 0, ',', '.') }}</td>
                    <td class="border p-2 text-right">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr class="bg-gray-100 font-bold">
                    <td colspan="3" class="border p-2 text-right">TOTAL HARGA</td>
                    <td class="border p-2 text-right">Rp {{ number_format($pesanan->totalHarga, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection