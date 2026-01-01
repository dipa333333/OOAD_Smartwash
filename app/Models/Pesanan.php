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

    // Cast tanggal ke format date agar mudah diolah
    protected $casts = [
        'estimasiSelesai' => 'date',
        'tanggalPesan' => 'date',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }

    // Relasi ke DetailPesanan
    public function details()
    {
        return $this->hasMany(DetailPesanan::class, 'idPesanan', 'idPesanan');
    }

    // Relasi ke Transaksi (1 to 1)
    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'idPesanan', 'idPesanan');
    }
}