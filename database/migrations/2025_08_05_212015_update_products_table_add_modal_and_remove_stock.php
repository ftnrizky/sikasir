<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Hapus kolom lama jika ada
            if (Schema::hasColumn('products', 'price')) {
                $table->dropColumn('price');
            }

            // Tambahkan kolom harga_modal dan harga_jual
            if (!Schema::hasColumn('products', 'harga_modal')) {
                $table->integer('harga_modal')->after('name');
            }

            if (!Schema::hasColumn('products', 'harga_jual')) {
                $table->integer('harga_jual')->after('harga_modal');
            }

            // Hapus kolom stok jika ada
            if (Schema::hasColumn('products', 'stock')) {
                $table->dropColumn('stock');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('price')->nullable();
            $table->integer('stock')->default(0);
            $table->dropColumn(['harga_modal', 'harga_jual']);
        });
    }
};