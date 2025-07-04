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
        $users = [
            [
                'name' => 'Kepolisian Lubeg',
                'email' => 'operator1@gmail.com',
                'password' => bcrypt('12345678'),
                'nrp' => '1234567890',  // Ganti dengan NRP yang sesuai
                'no_telp' => '081234567890',  // Ganti dengan nomor telepon yang sesuai
                'satuan_kerja' => 'Satuan Kerja Polres Lubeg',  // Ganti dengan satuan kerja yang sesuai
                'role' => 'operator',  // Ganti dengan role yang sesuai
            ],
            [
                'name' => 'Admin BNN',
                'email' => 'admin2@gmail.com',
                'password' => bcrypt('12345678'),
                'nrp' => '1234567890',  // Ganti dengan NRP yang sesuai
                'no_telp' => '081234567890',  // Ganti dengan nomor telepon yang sesuai
                'satuan_kerja' => 'Admin BNN',  // Ganti dengan satuan kerja yang sesuai
                'role' => 'admin_bnn',  // Ganti dengan role yang sesuai
            ]
        ];

        foreach ($users as $userData) {
            // Cek apakah user dengan email ini sudah ada
            $existingUser = User::where('email', $userData['email'])->first();

            if (!$existingUser) {
                User::create($userData);
                $this->command->info("User {$userData['name']} ({$userData['email']}) berhasil dibuat.");
            } else {
                $this->command->warn("User dengan email {$userData['email']} sudah ada, dilewati.");
            }
        }
    }
}
