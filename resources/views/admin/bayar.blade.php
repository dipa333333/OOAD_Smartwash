@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Pembayaran Kasir</h2>

    <div class="bg-gray-50 p-4 rounded mb-6 text-center">
        <p class="text-sm text-gray-500">Total Tagihan</p>
        <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($pesanan->totalHarga, 0, ',', '.') }}</p>
    </div>

    <form action="{{ route('admin.pesanan.bayar.process', $pesanan->idPesanan) }}" method="POST">
        @csrf
        <input type="hidden" name="total_bayar" value="{{ $pesanan->totalHarga }}">

        <div class="mb-4">
            <label class="block font-bold mb-2">Metode Pembayaran</label>
            <select name="metode" class="w-full border p-2 rounded">
                <option value="Tunai">Tunai / Cash</option>
                <option value="QRIS">QRIS</option>
                <option value="Transfer">Transfer Bank</option>
            </select>
        </div>

        <div class="mb-6">
            <label class="block font-bold mb-2">Uang Diterima (Rp)</label>
            <input type="number" name="uang_bayar" class="w-full border p-2 rounded text-lg" placeholder="Contoh: 50000" required>
        </div>

        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded">
            PROSES BAYAR
        </button>
    </form>
</div>
@endsection