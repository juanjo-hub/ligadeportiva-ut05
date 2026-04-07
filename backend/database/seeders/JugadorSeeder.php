<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jugador;

class JugadorSeeder extends Seeder
{
    public function run(): void
    {
        Jugador::create([
            'nombre' => 'Juan Pérez',
            'posicion' => 'Delantero',
            'dorsal' => 9,
            'club_id' => 1
        ]);

        Jugador::create([
            'nombre' => 'Luis García',
            'posicion' => 'Portero',
            'dorsal' => 1,
            'club_id' => 1
        ]);

        Jugador::create([
            'nombre' => 'Carlos Ruiz',
            'posicion' => 'Defensa',
            'dorsal' => 5,
            'club_id' => 2
        ]);

        Jugador::create([
            'nombre' => 'Miguel Torres',
            'posicion' => 'Centrocampista',
            'dorsal' => 8,
            'club_id' => 3
        ]);
    }
}
