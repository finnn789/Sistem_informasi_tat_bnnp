<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('laporan_tat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('surat_permohonan_tat');
            $table->string('surat_perintah_penangkapan');
            $table->string('nomor_surat_permohonan_tat')->unique();
            $table->text('kronologis');
            $table->string('laporan_polisi');
            $table->string('surat_perintah_penyidikan')->unique();
            $table->string('surat_uji_laboratorium');
            $table->string('berita_acara_pemeriksaan_tersangka')->nullable();
            $table->string('surat_persetujuan_tat')->nullable();
            $table->string('surat_pernyataan_penyidik')->nullable();
            $table->enum('status', ['menunggu', 'diterima', 'ditolak']);
            $table->text('alasan_penolakan')->nullable();
            $table->dateTime('tanggal_pelaksanaan')->nullable();
            $table->string('file_surat_penerimaan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_tat');
    }
};
