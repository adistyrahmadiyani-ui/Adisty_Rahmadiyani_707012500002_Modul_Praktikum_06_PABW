<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori_produk')->cascadeOnDelete();
            $table->string('nama_produk');
            $table->decimal('harga', 12, 0);
            $table->unsignedInteger('stok');
            $table->text('deskripsi')->nullable();
            $table->string('lokasi_petani');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
