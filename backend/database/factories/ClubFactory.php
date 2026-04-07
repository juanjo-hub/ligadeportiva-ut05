<?php

namespace Database\Factories;

use App\Models\Club;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClubFactory extends Factory
{
    protected $model = Club::class;

    public function definition(): array
    {
        return [
            'nombre'    => fake()->company(),
            'ciudad'    => fake()->city(),
            'categoria' => fake()->randomElement(['Juvenil', 'Senior', 'Cadete']),
        ];
    }
}