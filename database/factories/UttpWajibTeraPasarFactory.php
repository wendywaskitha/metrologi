<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\JenisUttp;
use App\Models\Satuan;
use App\Models\UttpWajibTeraPasar;
use App\Models\WajibTeraPasar;

class UttpWajibTeraPasarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UttpWajibTeraPasar::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'kap_max' => $this->faker->randomFloat(0, 0, 9999999999.),
            'daya_baca' => $this->faker->randomFloat(0, 0, 9999999999.),
            'merk' => $this->faker->word(),
            'tgl_uji' => $this->faker->date(),
            'expired' => $this->faker->date(),
            'status' => $this->faker->word(),
            'file' => $this->faker->word(),
            'wajib_tera_pasar_id' => WajibTeraPasar::factory(),
            'jenis_uttp_id' => JenisUttp::factory(),
            'satuan_id' => Satuan::factory(),
        ];
    }
}
