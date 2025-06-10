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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nrp')->default('')->after('name');
            $table->string('no_telp')->nullable()->after('email');
            $table->string('satuan_kerja')->nullable()->after('no_telp');
            $table->enum('role', ['operator', 'admin_bnn'])->default('operator')->after('satuan_kerja');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nrp', 'no_telp', 'satuan_kerja', 'role']);
        });
    }
};
