<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nama bahan baku
            $table->string('unit')->default('gram'); // satuan (gram, ml, pcs, dll)
            $table->decimal('stock', 10, 2)->default(0); // jumlah stok sekarang
            $table->decimal('minimum_stock', 10, 2)->default(0); // batas minimal stok
            $table->boolean('is_available')->default(true); // status tersedia / tidak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
