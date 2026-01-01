<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $fillable = [
        'idPesanan',
        'idLayanan',
        'jumlah',
        'subtotal'
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'idLayanan', 'idLayanan');
    }
}