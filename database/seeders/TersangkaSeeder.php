<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tersangka;
class TersangkaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Tersangka::create([
            'nama' => 'John Doe',
            'no_ktp' => '1234567890123456',
            'alamat' => 'Jl. Kebon Jeruk No. 12',
            'tanggal_lahir' => '1985-08-15',
        ]);
    }
}
