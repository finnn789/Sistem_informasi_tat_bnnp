<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Kepolisian Lubeg',
            'email' => 'operator1@gmail.com',
            'password' => bcrypt('12345678'),
            'nrp' => '1234567890',  // Ganti dengan NRP yang sesuai
            'no_telp' => '081234567890',  // Ganti dengan nomor telepon yang sesuai
            'satuan_kerja' => 'Satuan Kerja Polres Lubeg',  // Ganti dengan satuan kerja yang sesuai
            'role' => 'operator',  // Ganti dengan role yang sesuai
        ]);
    }
}
