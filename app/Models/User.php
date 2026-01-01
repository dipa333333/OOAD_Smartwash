<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'idUser'; // Override primary key default 'id'

    protected $fillable = [
        'username',
        'password',
        'nama',
        'role',
        'alamat',
        'nomorTelepon',
    ];

    protected $hidden = [
        'password',
    ];

    // Relasi: User (Pelanggan) punya banyak pesanan
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'idUser', 'idUser');
    }
}