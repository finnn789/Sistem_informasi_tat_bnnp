<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanTersangka extends Model
{
    use HasFactory;
    protected $table = 'laporan_tersangka';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'laporan_tat_id', // ID dari laporan_tat
        'tersangka_id',   // ID dari tersangka
           // Menyimpan keterangan tambahan
    ];
}
