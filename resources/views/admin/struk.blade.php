<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $pesanan->idPesanan }}</title>
    <style>
        @page { size: 80mm 200mm; margin: 0; }
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 70mm; 
            margin: 0 auto;
            padding: 10px;
            font-size: 12px;
            color: #000;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .divider { border-top: 1px dashed #000; margin: 5px 0; }
        .header { margin-bottom: 10px; }
        .header h2 { margin: 0; font-size: 18px; }
        .info { font-size: 10px; margin-bottom: 10px; }
        .table { width: 100%; border-collapse: collapse; }
        .footer { margin-top: 15px; font-size: 10px; }

        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header text-center">
        <h2>SMARTWASH</h2>
        <div style="font-size: 9px;">Jl. Laundry Modern No. 123, Jakarta</div>
        <div style="font-size: 9px;">Telp: 0812-3456-7890</div>
    </div>

    <div class="divider"></div>

    <div class="info">
        <table width="100%">
            <tr>
                <td>No. Nota</td>
                <td class="text-right">#{{ $pesanan->idPesanan }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td class="text-right">{{ $pesanan->created_at->format('d/m/y H:i') }}</td>
            </tr>
            <tr>
                <td>Pelanggan</td>
                <td class="text-right">{{ strtoupper($pesanan->user->nama) }}</td>
            </tr>
        </table>
    </div>

    <div class="divider"></div>

    <table class="table">
        @foreach($pesanan->details as $detail)
        <tr>
            <td colspan="2">{{ $detail->layanan->namaLayanan }}</td>
        </tr>
        <tr>
            <td style="padding-bottom: 5px;">{{ $detail->jumlah }} x {{ number_format($detail->layanan->harga, 0, ',', '.') }}</td>
            <td class="text-right" style="vertical-align: bottom;">{{ number_format($detail->jumlah * $detail->layanan->harga, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="divider"></div>

    <table width="100%" class="bold">
        <tr>
            <td>TOTAL</td>
            <td class="text-right">Rp {{ number_format($pesanan->totalHarga, 0, ',', '.') }}</td>
        </tr>
        @if($pesanan->transaksi)
        <tr>
            <td>BAYAR ({{ $pesanan->transaksi->metodePembayaran }})</td>
            <td class="text-right">Rp {{ number_format($pesanan->transaksi->totalBayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>KEMBALI</td>
            <td class="text-right">Rp {{ number_format($pesanan->transaksi->totalBayar - $pesanan->totalHarga, 0, ',', '.') }}</td>
        </tr>
        @endif
    </table>

    <div class="divider"></div>

    <div class="text-center bold" style="margin: 10px 0; border: 1px solid #000; padding: 3px;">
        @if($pesanan->transaksi)
            *** LUNAS ***
        @else
            * BELUM BAYAR *
        @endif
    </div>

    <div class="footer text-center">
        <p>Terima kasih telah mempercayakan pakaian Anda kepada kami!</p>
        <p>Status cucian dapat dipantau di:<br>smartwash.test</p>
    </div>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer;">Tutup Halaman</button>
    </div>

</body>
</html>