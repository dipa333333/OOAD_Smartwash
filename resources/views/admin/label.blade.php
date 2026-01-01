<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Label #{{ $pesanan->idPesanan }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 10px;
            width: 300px;
            border: 1px dashed #000;
        }
        .header { text-align: center; margin-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; text-transform: uppercase; }
        .meta { font-size: 12px; margin-bottom: 5px; }
        .qr-box { text-align: center; margin: 10px 0; }
        .items { border-top: 2px solid #000; border-bottom: 2px solid #000; padding: 5px 0; margin: 5px 0; }
        .item-row { display: flex; justify-content: space-between; font-size: 14px; font-weight: bold; }
        .footer { text-align: center; font-size: 10px; margin-top: 10px; }

        @media print {
            body { border: none; width: auto; margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <div class="title">SMARTWASH</div>
        <div style="font-size: 10px;">ORDER TAG</div>
    </div>

    <div class="qr-box">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=ORDER-{{ $pesanan->idPesanan }}" alt="QR Code">
        <br>
        <span style="font-size: 24px; font-weight: bold;">#{{ $pesanan->idPesanan }}</span>
    </div>

    <div style="margin-bottom: 10px;">
        <div class="meta"><strong>Pelanggan:</strong> {{ strtoupper($pesanan->user->nama) }}</div>
        <div class="meta"><strong>Tgl Masuk:</strong> {{ $pesanan->created_at->format('d/m/Y H:i') }}</div>
        @if($pesanan->estimasiSelesai)
        <div class="meta"><strong>Est. Selesai:</strong> {{ $pesanan->estimasiSelesai->format('d/m/Y') }}</div>
        @endif
    </div>

    <div class="items">
        @foreach($pesanan->details as $detail)
        <div class="item-row">
            <span>{{ $detail->layanan->namaLayanan }}</span>
            <span>x{{ $detail->jumlah }}</span>
        </div>
        @endforeach
    </div>

    <div class="item-row" style="margin-top: 5px;">
        <span>TOTAL ITEM:</span>
        <span>{{ $totalItem }} Pcs/Kg</span>
    </div>

    <div class="footer">
        <p>Jangan sampai hilang / tertukar.<br>Tempelkan pada kantong.</p>
    </div>

    <button class="no-print" onclick="window.history.back()" style="width: 100%; padding: 10px; margin-top: 20px; cursor: pointer; background: #ddd; border: none;">Kembali</button>

</body>
</html>