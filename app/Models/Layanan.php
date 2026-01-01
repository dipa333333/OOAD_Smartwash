<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $primaryKey = 'idLayanan';

    protected $fillable = [
        'namaLayanan',
        'harga'
    ];
}