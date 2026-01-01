<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('idPesanan');
            // Relasi ke User (Pelanggan)
            $table->foreignId('idUser')->constrained('users', 'idUser')->onDelete('cascade');
            $table->date('tanggalPesan');
            // Status sesuai Sequence Diagram (Menunggu Validasi, Antre, Cuci, Setrika, Selesai)
            $table->string('statusPesanan')->default('Menunggu Validasi');
            $table->double('totalHarga')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};