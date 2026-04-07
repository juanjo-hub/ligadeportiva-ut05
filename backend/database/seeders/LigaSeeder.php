<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Liga;

class LigaSeeder extends Seeder
{
    public function run(): void
    {
        Liga::create([
            'nombre' => 'Liga Maestre',
            'deporte' => 'Fútbol',
            'temporada' => '2025/2026'
        ]);
    }
}
