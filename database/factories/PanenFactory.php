<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\panen>
 */
class PanenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $luasPanen = $this->faker->randomDigitNotNull;
        $produksi = $this->faker->randomDigitNotNull;
        $produksiKw = $produksi * 10;
        $produktivitasValue = $produksiKw / $luasPanen;
        $rounded = round($produktivitasValue, 2);
        // random latitude in indonesia
        $latitude = $this->faker->latitude(-11.00, 6.00);
        // random longitude in indonesia
        $longitude = $this->faker->longitude(95.00, 141.00);
        $created_at = $this->faker->dateTimeBetween('2022-01-01', 'now');
        $updated_at = $this->faker->dateTimeBetween($created_at, 'now');

        return [
            'id_petani' => $this->faker->numberBetween(1, 10),
            'luas_panen' => $luasPanen,
            'produktivitas' => $rounded,
            'produksi' => $produksi,
            'id_provinsi' => $this->faker->numberBetween(1, 34),
            'latitude' => $latitude,
            'longitude' => $longitude,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ];
    }
}
