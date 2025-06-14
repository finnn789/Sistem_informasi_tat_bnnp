<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanTAT extends Model
{
    use HasFactory;

    protected $table = 'laporan_tat';

    protected $fillable = [
        'user_id',
        'surat_permohonan_tat',
        'surat_perintah_penangkapan',
        'nomor_surat_permohonan_tat',
        'kronologis',
        'laporan_polisi',
        'surat_perintah_penyidikan',
        'surat_uji_laboratorium',
        'berita_acara_pemeriksaan_tersangka',
        'surat_persetujuan_tat',
        'surat_pernyataan_penyidik',
        'status',
        'alasan_penolakan',
        'tanggal_pelaksanaan',
        'file_surat_penerimaan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tersangka()
    {
         return $this->belongsToMany(Tersangka::class, 'laporan_tersangka', 'laporan_tat_id', 'tersangka_id')
                    ->withTimestamps();
    }
}
