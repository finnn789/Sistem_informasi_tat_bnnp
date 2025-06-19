<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\LaporanTAT;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Tersangka;
use App\Models\User;

class LaporanTATSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama
        LaporanTAT::truncate();

        $user = User::first() ?? User::create([
            'name' => 'Admin Polres',
            'email' => 'admin@polres.go.id',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        $tersangkaList = Tersangka::all();
        
        if ($tersangkaList->isEmpty()) {
            echo "Warning: No tersangka records found. Make sure TersangkaSeeder has been run first.\n";
            return;
        }
        
        $faker = Faker::create('id_ID');

        // Generate 10 laporan dengan data random tapi unique
        for ($i = 1; $i <= 20; $i++) {
            $laporan = LaporanTAT::create([
                'user_id' => $user->id,
                'surat_permohonan_tat' => $faker->unique()->bothify('SP-TAT-###-????') . '.pdf',
                'surat_perintah_penangkapan' => $faker->unique()->bothify('SPP-###-????') . '.pdf',
                'nomor_surat_permohonan_tat' => $faker->unique()->bothify('TAT/###/????'),
                'kronologis' => $faker->paragraph(3),
                'laporan_polisi' => $faker->unique()->bothify('LP-###-????') . '.pdf',
                'surat_perintah_penyidikan' => $faker->unique()->bothify('SPRIN-###-????'), // Unique dengan faker
                'surat_uji_laboratorium' => $faker->unique()->bothify('LAB-###-????') . '.pdf',
                'berita_acara_pemeriksaan_tersangka' => $faker->unique()->bothify('BAP-###-????') . '.pdf',
                'surat_persetujuan_tat' => $faker->unique()->bothify('SETUJU-TAT-###-????') . '.pdf',
                'surat_pernyataan_penyidik' => $faker->unique()->bothify('SP-SIDIK-###-????') . '.pdf',
                'status' => $faker->randomElement(['menunggu', 'diterima', 'ditolak']),
                'alasan_penolakan' => $faker->optional(0.3)->sentence(),
                'tanggal_pelaksanaan' => $faker->optional(0.6)->dateTimeBetween('now', '+1 month'),
                'file_surat_penerimaan' => $faker->optional(0.6)->bothify('surat_penerimaan_###') . '.pdf',
            ]);

            // Attach 1-3 tersangka secara random
            $jumlahTersangka = $faker->numberBetween(1, min(3, $tersangkaList->count()));
            $selectedTersangka = $tersangkaList->random($jumlahTersangka);
            $laporan->tersangka()->attach($selectedTersangka->pluck('id')->toArray());

            echo "✓ Laporan {$laporan->nomor_surat_permohonan_tat} - Status: {$laporan->status}\n";
        }

        echo "\nSeeder LaporanTAT berhasil dijalankan! 10 laporan dibuat.\n";
    }
}