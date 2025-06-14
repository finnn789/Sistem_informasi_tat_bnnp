<?php
// File: app/Models/Tersangka.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LaporanTAT;

class Tersangka extends Model
{
    use HasFactory;

    protected $table = 'tersangka';

    protected $fillable = [
        'nama',
        'no_ktp',
        'jenis_kelamin',
        'alamat',
        'tanggal_lahir',
        'foto_ktp'
    ];
    public function laporanTAT()
    {
         return $this->belongsToMany(LaporanTAT::class, 'laporan_tersangka', 'tersangka_id', 'laporan_tat_id')
                    ->withTimestamps();
    }
}
// This model represents a suspect in the system, with fields for their name, ID number, address, date of birth, and a photo of their ID card.
// It uses the HasFactory trait for factory-based testing and seeding.