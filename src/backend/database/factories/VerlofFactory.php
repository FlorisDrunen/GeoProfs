<?php

namespace Database\Factories;

use App\Models\Verlof;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class VerlofFactory extends Factory
{
    protected $model = Verlof::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'begin_tijd' => $this->faker->time('H:i'),
            'begin_datum' => $this->faker->date('Y-m-d'),
            'eind_tijd' => $this->faker->time('H:i'),
            'eind_datum' => $this->faker->date('Y-m-d'),
            'reden' => $this->faker->sentence(),
            'status' => 'pending',
        ];
    }
}
