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
        'kronologis',
        'data_tersangka_id',
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
        return $this->belongsTo(Tersangka::class, 'data_tersangka_id');
    }
}
