<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        Layanan::create(['namaLayanan' => 'Cuci Komplit (Cuci+Gosok)', 'harga' => 6000]);
        Layanan::create(['namaLayanan' => 'Cuci Kering', 'harga' => 4500]);
        Layanan::create(['namaLayanan' => 'Setrika Saja', 'harga' => 3500]);
        Layanan::create(['namaLayanan' => 'Cuci Bedcover Besar', 'harga' => 30000]);
        Layanan::create(['namaLayanan' => 'Cuci Sepatu', 'harga' => 25000]);
    }
}