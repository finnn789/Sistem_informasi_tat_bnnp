<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password dummy
            'remember_token' => Str::random(10),
            'role' => $this->faker->randomElement(['operator', 'admin_bnn']), // Menambahkan role
            'nrp' => $this->faker->randomNumber(8),
            'no_telp' => $this->faker->phoneNumber,
            'satuan_kerja' => $this->faker->company,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function operator()
    {
        return $this->state([
            'role' => 'operator',  // Pastikan role ada di dalam database
        ]);
    }

    // Method untuk membuat user dengan role 'adminBnn'
    public function adminBnn()
    {
        return $this->state([
            'role' => 'adminBnn', // Pastikan role ada di dalam database
        ]);
    }
}
