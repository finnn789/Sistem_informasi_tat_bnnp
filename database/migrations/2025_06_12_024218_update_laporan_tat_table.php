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
        Schema::table('laporan_tat', function (Blueprint $table) {
            // Menambahkan kolom yang hilang
            $table->string('nomor_surat_permohonan_tat')->unique()->after('surat_perintah_penangkapan');
            $table->enum('status', ['menunggu', 'diterima', 'ditolak'])->change(); // Mengubah status menjadi enum yang sesuai

            // Menambahkan kolom nullable jika belum ada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
