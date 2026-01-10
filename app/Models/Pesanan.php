<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $primaryKey = 'idPesanan';

    protected $fillable = [
        'idUser',
        'tanggalPesan',
        'statusPesanan',
        'totalHarga',
        'estimasiSelesai'
    ];

    protected $casts = [
        'estimasiSelesai' => 'date',
        'tanggalPesan' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }

    public function details()
    {
        return $this->hasMany(DetailPesanan::class, 'idPesanan', 'idPesanan');
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'idPesanan', 'idPesanan');
    }
}