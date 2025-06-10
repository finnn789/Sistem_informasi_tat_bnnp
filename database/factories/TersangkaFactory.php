<?php

namespace Database\Factories;
use App\Models\Tersangka;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tersangka>
 */
class TersangkaFactory extends Factory
{
    protected $model = Tersangka::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->name,
            'no_ktp' => $this->faker->unique()->numerify('###########'),
            'alamat' => $this->faker->address,
            'tanggal_lahir' => $this->faker->date,
        ];
    }
}
