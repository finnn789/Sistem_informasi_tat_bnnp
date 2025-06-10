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
            $table->string('no_ktp');
            $table->string('alamat');
            $table->date('tanggal_lahir');
            $table->string('foto_ktp')->nullable();  // Kolom untuk foto KTP (opsional)
            $table->timestamps();  // Timestamps untuk created_at dan updated_at
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
