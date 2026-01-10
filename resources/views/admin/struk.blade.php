<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran #{{ $pesanan->idPesanan }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Courier New', Courier, monospace; background: #eee; }
        .struk { width: 300px; background: white; margin: 50px auto; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .dashed { border-top: 1px dashed #000; margin: 10px 0; }
        @media print {
            body { background: white; }
            .struk { width: 100%; box-shadow: none; margin: 0; padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="struk">
        <div class="text-center mb-4">
            <h1 class="text-xl font-bold uppercase">SmartWash</h1>
            <p class="text-xs">Jln. Kebersihan No. 1, Jakarta</p>
            <p class="text-xs">WA: 0812-3456-7890</p>
        </div>

        <div class="dashed"></div>

        <div class="text-xs mb-2">
            <div class="flex justify-between">
                <span>No. Nota</span>
                <span>#{{ $pesanan->idPesanan }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tanggal</span>
                <span>{{ date('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Pelanggan</span>
                <span class="font-bold">{{ substr($pesanan->user->nama, 0, 15) }}</span>
            </div>
            <div class="flex justify-between">
                <span>Kasir</span>
                <span>{{ Auth::user()->nama }}</span>
            </div>
        </div>

        <div class="dashed"></div>

        <div class="text-xs mb-2 space-y-1">
            @foreach($pesanan->details as $detail)
            <div>
                <div class="font-bold">{{ $detail->layanan->namaLayanan }}</div>
                <div class="flex justify-between">
                    <span>{{ $detail->jumlah }} x {{ number_format($detail->hargaSatuan, 0, ',', '.') }}</span>
                    <span>{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="dashed"></div>

        @php
            $total = $pesanan->transaksi->totalBayar;
            $bayar = session('uang_bayar') ? session('uang_bayar') : $total;
            $kembali = $bayar - $total;
        @endphp

        <div class="text-xs font-bold space-y-1">
            <div class="flex justify-between text-sm">
                <span>TOTAL</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>TUNAI/BAYAR</span>
                <span>Rp {{ number_format($bayar, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>KEMBALI</span>
                <span>Rp {{ number_format($kembali, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between mt-2 italic font-normal text-center">
                <span class="w-full text-[10px]">{{ $pesanan->transaksi->metodePembayaran }}</span>
            </div>
        </div>

        <div class="dashed"></div>

        <div class="text-center text-[10px] mt-4">
            <p>Terima Kasih atas Kepercayaan Anda</p>
            <p>Barang yang tidak diambil > 1 bulan</p>
            <p>bukan tanggung jawab kami.</p>
        </div>

        <div class="no-print mt-6 flex flex-col gap-2">
            <button onclick="window.print()" class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold hover:bg-blue-700 text-xs">
                🖨️ CETAK STRUK
            </button>
            <button onclick="handleClose()" class="w-full bg-gray-200 text-gray-800 py-2 rounded-lg font-bold hover:bg-gray-300 text-xs">
                ❌ TUTUP
            </button>
        </div>
    </div>

    <script>
        function handleClose() {
            window.close();
            window.location.href = "{{ route('admin.dashboard') }}";
        }
    </script>
</body>
</html>