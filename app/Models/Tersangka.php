<?php
// File: app/Models/Tersangka.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tersangka extends Model
{
    use HasFactory;

    protected $table = 'tersangka'; 
    
    protected $fillable = [
        'nama',
        'no_ktp',
        'alamat',
        'tanggal_lahir',
        'foto_ktp'
    ];
}
// This model represents a suspect in the system, with fields for their name, ID number, address, date of birth, and a photo of their ID card.
// It uses the HasFactory trait for factory-based testing and seeding.