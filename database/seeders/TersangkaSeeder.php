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
        // Create multiple sample Tersangka entries
        $tersangkaData = [
            [
                'nama' => 'Ahmad Suryadi',
                'no_ktp' => '3201010101850001',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta Pusat',
                'tanggal_lahir' => '1985-01-01',
                'foto_ktp' => 'foto_ktp/ahmad_suryadi.jpg',
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'no_ktp' => '3201020202900002',

                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Sudirman No. 456, Jakarta Selatan',
                'tanggal_lahir' => '1990-02-02',
                'foto_ktp' => 'foto_ktp/siti_nurhaliza.jpg',
            ],
            [
                'nama' => 'Budi Santoso',
                'no_ktp' => '3201030303880003',

                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Thamrin No. 789, Jakarta Pusat',
                'tanggal_lahir' => '1988-03-03',
                'foto_ktp' => 'foto_ktp/budi_santoso.jpg',
            ],
            [
                'nama' => 'Dewi Lestari',
                'no_ktp' => '3201040404920004',

                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Gatot Subroto No. 321, Jakarta Selatan',
                'tanggal_lahir' => '1992-04-04',
                'foto_ktp' => 'foto_ktp/dewi_lestari.jpg',
            ],
            [
                'nama' => 'Eko Prasetyo',
                'no_ktp' => '3201050505870005',

                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Rasuna Said No. 654, Jakarta Selatan',
                'tanggal_lahir' => '1987-05-05',
                'foto_ktp' => 'foto_ktp/eko_prasetyo.jpg',
            ],
        ];

        // Insert all tersangka records
        foreach ($tersangkaData as $data) {
            Tersangka::create($data);
        }

        echo "TersangkaSeeder berhasil dijalankan! " . count($tersangkaData) . " tersangka dibuat.\n";
    }
}
