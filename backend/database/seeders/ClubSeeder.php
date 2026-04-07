<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Club;

class ClubSeeder extends Seeder
{
    public function run(): void
    {
        Club::create([
            'nombre' => 'Real Maestre',
            'ciudad' => 'Ciudad Real',
            'categoria' => 'Primera'
        ]);

        Club::create([
            'nombre' => 'Atlético Calatrava',
            'ciudad' => 'Almagro',
            'categoria' => 'Primera'
        ]);

        Club::create([
            'nombre' => 'Sporting Campo',
            'ciudad' => 'Campo de Criptana',
            'categoria' => 'Segunda'
        ]);
    }
}
