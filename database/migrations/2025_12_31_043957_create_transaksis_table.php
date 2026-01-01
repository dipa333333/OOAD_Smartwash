<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('idTransaksi');
            // Relasi 1-to-1 dengan Pesanan
            $table->foreignId('idPesanan')->unique()->constrained('pesanans', 'idPesanan')->onDelete('cascade');
            $table->date('tanggalTransaksi');
            $table->double('totalBayar');
            $table->string('metodePembayaran');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};