<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\Jugador;
use Illuminate\Database\Eloquent\Factories\Factory;

class JugadorFactory extends Factory
{
    protected $model = Jugador::class;

    public function definition(): array
    {
        return [
            'nombre'   => fake()->name(),
            'posicion' => fake()->randomElement(['Delantero', 'Portero', 'Defensa', 'Centrocampista']),
            'dorsal'   => fake()->numberBetween(1, 99),
            'club_id'  => Club::factory(),
        ];
    }
}