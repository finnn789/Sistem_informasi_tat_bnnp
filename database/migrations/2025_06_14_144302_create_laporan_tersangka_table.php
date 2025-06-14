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
        Schema::create('laporan_tersangka', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_tat_id')->constrained('laporan_tat')->onDelete('cascade'); // Menghubungkan dengan laporan_tat
            $table->foreignId('tersangka_id')->constrained('tersangka')->onDelete('cascade'); // Menghubungkan dengan tersangka
            $table->timestamps();
            $table->unique(['laporan_tat_id', 'tersangka_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_tersangka');
    }
};
