<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Admin
        User::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'nama' => 'Administrator SmartWash',
            'role' => 'admin',
        ]);

        // Buat Pelanggan
        User::create([
            'username' => 'budi',
            'password' => Hash::make('budi123'),
            'nama' => 'Budi Santoso',
            'role' => 'pelanggan',
            'alamat' => 'Jl. Mawar No. 10',
            'nomorTelepon' => '081234567890',
        ]);
    }
}