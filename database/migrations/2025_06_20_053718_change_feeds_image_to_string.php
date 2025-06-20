<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('feed', function (Blueprint $table) {
            // Mengubah tipe kolom 'image' dari BLOB ke string.
            // Ini akan menjaga data yang ada, TAPI data BLOB tidak akan valid sebagai string path.
            // Data akan tetap ada, tapi nilainya tidak bisa langsung digunakan sebagai path.
            // Kita akan memperbaikinya di langkah migrasi data selanjutnya.
            $table->string('image', 255)->nullable()->change(); // Sesuaikan panjang string jika perlu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feed', function (Blueprint $table) {
            // Mengembalikan tipe kolom ke longBlob jika perlu rollback
            // Perhatian: Mengembalikan ke BLOB akan menyebabkan data string path hilang.
            $table->longBlob('image')->nullable()->change();
        });
    }
};