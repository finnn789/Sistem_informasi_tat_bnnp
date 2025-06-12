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
        'data_tersangka_id',
        'jenis_kelamin',
        'alamat',
        'tanggal_lahir',
        'foto_ktp'
    ];
    public function laporanTAT()
    {
        return $this->hasMany(LaporanTAT::class, 'data_tersangka_id');
    }
}
// This model represents a suspect in the system, with fields for their name, ID number, address, date of birth, and a photo of their ID card.
// It uses the HasFactory trait for factory-based testing and seeding.