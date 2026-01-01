<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idPesanan')->constrained('pesanans', 'idPesanan')->onDelete('cascade');
            $table->foreignId('idLayanan')->constrained('layanans', 'idLayanan')->onDelete('cascade');
            $table->integer('jumlah');
            $table->double('subtotal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
    }
};