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
        User::factory()->count(10)->create(); // Membuat 10 user dengan data acak

        // Atau jika ingin membuat user dengan role tertentu
        User::factory()->operator()->count(5)->create(); // Membuat 5 user dengan role 'operator'
        User::factory()->admin()->count(2)->create();
    }
}
