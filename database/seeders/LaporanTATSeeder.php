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
    /**
     * Run the database seeds.
     *
     */
    public function run()
    {

        $user = User::factory()->create();
        $tersangka = Tersangka::factory()->create();
        // Inisialisasi Faker untuk generate data dummy
        $faker = Faker::create();

        // Menggunakan factory atau cara manual untuk membuat dummy data
        for ($i = 0; $i < 20; $i++) {
            LaporanTAT::create([
                'user_id' => 2, // Menggunakan user_id 1, pastikan user dengan ID ini ada di database
                'surat_permohonan_tat' => $faker->word . '.pdf', // Nama file dummy
                'surat_perintah_penangkapan' => $faker->word . '.pdf',
                'kronologis' => $faker->paragraph,
                'data_tersangka_id' => $tersangka->id, // Gunakan ID yang sesuai dari tabel tersangka
                'laporan_polisi' => $faker->word . '.pdf',
                'surat_perintah_penyidikan' => $faker->unique()->word,
                'surat_uji_laboratorium' => $faker->word . '.pdf',
                'berita_acara_pemeriksaan_tersangka' => $faker->word . '.pdf',
                'surat_persetujuan_tat' => $faker->word . '.pdf',
                'surat_pernyataan_penyidik' => $faker->word . '.pdf',
                'status' => $faker->randomElement(['menunggu', 'diterima', 'ditolak']),
                'alasan_penolakan' => $faker->optional()->sentence,
                'tanggal_pelaksanaan' => $faker->optional()->dateTimeThisYear,
                'file_surat_penerimaan' => $faker->optional()->word . '.pdf',
            ]);
        }
    }
}
