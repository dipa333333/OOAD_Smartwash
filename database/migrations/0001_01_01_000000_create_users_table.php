<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('idUser'); // Sesuai diagram: #idUser
            $table->string('username')->unique(); // Sesuai diagram: #username
            $table->string('password'); // Sesuai diagram: -password
            $table->string('nama'); // Sesuai diagram: #nama
            $table->enum('role', ['admin', 'pelanggan']); // Sesuai diagram: #role

            // Atribut khusus Pelanggan (nullable karena Admin tidak punya ini)
            $table->text('alamat')->nullable();
            $table->string('nomorTelepon')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};