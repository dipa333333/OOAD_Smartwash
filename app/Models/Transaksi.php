<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $primaryKey = 'idTransaksi';

    protected $fillable = [
        'idPesanan',
        'tanggalTransaksi',
        'totalBayar',
        'metodePembayaran'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'idPesanan', 'idPesanan');
    }
}