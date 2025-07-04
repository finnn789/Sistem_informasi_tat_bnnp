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
        Schema::create('tersangka', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_ktp')->unique();
            $table->enum('jenis_kelamin', ['L', 'P']); // 'L' untuk laki-laki, 'P' untuk perempuan
            $table->text('alamat');
            $table->date('tanggal_lahir');
            $table->string('foto_ktp')->nullable(); // Path ke foto KTP
            $table->timestamps();

            // You can add foreign key constraint if necessary for 'data_tersangka_id'
            // $table->foreign('tersangka_id')->references('id')->on('laporan_tat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tersangka');
    }
};
