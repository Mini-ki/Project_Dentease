<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Feed; 
use Illuminate\Support\Facades\Log; // Untuk logging

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Pastikan direktori tujuan ada
        $storagePath = public_path('img/uploads/feed');
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true); // Buat direktori jika belum ada
        }

        // Ambil semua artikel
        $feeds = Feed::all();

        foreach ($feeds as $feed) {
            // Pastikan kolom 'image' benar-benar memiliki data (bukan null atau string kosong)
            // Dan ini diasumsikan 'image' masih berisi data BLOB dari sebelumnya
            if ($feed->image) {
                try {
                    // Buat nama file unik
                    $filename = uniqid() . '.jpg'; // Anda mungkin perlu mendeteksi ekstensi asli jika BLOB menyimpan tipe
                    $fullPath = $storagePath . '/' . $filename;

                    // Simpan data BLOB sebagai file
                    file_put_contents($fullPath, $feed->image);

                    // Perbarui kolom 'image' di database dengan nama file baru
                    $feed->image = $filename;
                    $feed->save();

                } catch (\Exception $e) {
                    // Log error jika ada masalah dengan satu gambar, tapi lanjutkan yang lain
                    Log::error("Failed to migrate image for feed ID {$feed->id}: " . $e->getMessage());
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     * PERHATIAN: Rollback ini tidak akan menghapus file dari filesystem atau mengembalikan BLOB.
     * Ini hanya menghapus path dari database. Anda harus menghapus file secara manual.
     */
    public function down(): void
    {
        Schema::table('feed', function (Blueprint $table) {
            // Dalam metode down, kita tidak bisa mengembalikan BLOB yang asli.
            // Ini hanya untuk menandai bahwa migrasi data telah dibatalkan
            // dan akan menghapus nilai path dari kolom image.
            // Anda harus menghapus file dari filesystem secara manual.
            $feeds = Feed::all();
            foreach ($feeds as $feed) {
                // Hapus file dari filesystem (opsional, tapi disarankan jika rollback)
                if ($feed->image && file_exists(public_path('img/uploads/feed/' . $feed->image))) {
                    unlink(public_path('img/uploads/feed/' . $feed->image));
                }
                $feed->image = null; // Set kembali ke null atau default
                $feed->save();
            }
        });
    }
};