<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Club;
use App\Models\Jugador;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JugadorApiMockTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_jugadores_con_datos_mockeados_via_factory()
    {
        $club = Club::factory()->create([
            'nombre' => 'Fénix eSports',
            'ciudad' => 'Ciudad Real',
        ]);

        Jugador::factory()->create([
            'nombre'   => 'Ana López',
            'posicion' => 'Capitana',
            'dorsal'   => 7,
            'club_id'  => $club->id,
        ]);

        Jugador::factory()->create([
            'nombre'   => 'Luis Ortega',
            'posicion' => 'Support',
            'dorsal'   => 9,
            'club_id'  => $club->id,
        ]);

        $response = $this->getJson('/api/jugadors');

        $response->assertStatus(200)
                 ->assertJsonCount(2)
                 ->assertJsonFragment(['nombre' => 'Ana López'])
                 ->assertJsonFragment(['nombre' => 'Luis Ortega']);
    }

    public function test_simulacion_llamada_a_api_externa()
    {
        Http::fake([
            'api.externa.com/jugadores' => Http::response([
                ['id' => 1, 'nombre' => 'Jugador Externo', 'posicion' => 'Delantero']
            ], 200),
        ]);

        $response = Http::get('api.externa.com/jugadores');

        $this->assertTrue($response->ok());
        $this->assertEquals('Jugador Externo', $response->json()[0]['nombre']);
    }

    public function test_simulacion_error_de_api_externa()
    {
        Http::fake([
            'api.externa.com/jugadores' => Http::response(
                ['error' => 'Servicio no disponible'], 500
            ),
        ]);

        $response = Http::get('api.externa.com/jugadores');

        $this->assertTrue($response->serverError());
        $this->assertEquals(500, $response->status());
    }

    public function test_crear_jugador_con_mock_y_verificar_en_bd()
    {
        $club = Club::factory()->create();

        $datosJugador = [
            'nombre'   => 'Carlos Ruiz',
            'posicion' => 'Defensa',
            'dorsal'   => 5,
            'club_id'  => $club->id,
        ];

        $response = $this->withHeaders(['X-ROLE' => 'admin'])
                         ->postJson('/api/jugadors', $datosJugador);

        $response->assertStatus(201);

        $this->assertDatabaseHas('jugadors', [
            'nombre'   => 'Carlos Ruiz',
            'posicion' => 'Defensa',
            'dorsal'   => 5,
        ]);
    }
}