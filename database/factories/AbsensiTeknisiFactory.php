<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AbsensiTeknisi;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AbsensiTeknisi>
 */
class AbsensiTeknisiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = AbsensiTeknisi::class;

    public function definition(): array
    {
        return [
            'tanggal' => $this->faker->date(),
            'jam_masuk' => $this->faker->time('H:i:s', '08:00:00'),
            'jam_keluar' => $this->faker->time('H:i:s', '17:00:00'),
            'keterangan' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['Hadir', 'Izin', 'Sakit', 'Alpha']),
        ];
    }
}
