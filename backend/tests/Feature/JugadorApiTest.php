<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Club;
use App\Models\Jugador;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JugadorApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_devuelve_lista_de_jugadores()
    {
        $club = Club::factory()->create();

        Jugador::factory()->create([
            'nombre'   => 'Ana López',
            'posicion' => 'Capitana',
            'dorsal'   => 7,
            'club_id'  => $club->id,
        ]);

        $response = $this->getJson('/api/jugadors');

        $response->assertStatus(200)
                 ->assertJsonFragment(['nombre' => 'Ana López']);
    }

    public function test_api_devuelve_jugador_con_su_club()
    {
        $club = Club::factory()->create(['nombre' => 'Dragones CR']);

        Jugador::factory()->create([
            'nombre'  => 'Luis Ortega',
            'club_id' => $club->id,
        ]);

        $response = $this->getJson('/api/jugadors');

        $response->assertStatus(200)
                 ->assertJsonFragment(['nombre' => 'Dragones CR']);
    }

    public function test_api_devuelve_jugador_por_id()
    {
        $club = Club::factory()->create();
        $jugador = Jugador::factory()->create([
            'nombre'  => 'Carlos Ruiz',
            'club_id' => $club->id,
        ]);

        $response = $this->getJson("/api/jugadors/{$jugador->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['nombre' => 'Carlos Ruiz']);
    }

    public function test_api_devuelve_404_si_jugador_no_existe()
    {
        $response = $this->getJson('/api/jugadors/999');

        $response->assertStatus(404);
    }

    public function test_admin_puede_crear_jugador()
    {
        $club = Club::factory()->create();

        $response = $this->withHeaders(['X-ROLE' => 'admin'])
                         ->postJson('/api/jugadors', [
                             'nombre'   => 'Miguel Torres',
                             'posicion' => 'Centrocampista',
                             'dorsal'   => 8,
                             'club_id'  => $club->id,
                         ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('jugadors', [
            'nombre' => 'Miguel Torres',
            'dorsal' => 8,
        ]);
    }

    public function test_usuario_no_admin_no_puede_crear_jugador()
    {
        $club = Club::factory()->create();

        $response = $this->postJson('/api/jugadors', [
            'nombre'   => 'Intruso',
            'posicion' => 'Delantero',
            'dorsal'   => 99,
            'club_id'  => $club->id,
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_puede_eliminar_jugador()
    {
        $club = Club::factory()->create();
        $jugador = Jugador::factory()->create(['club_id' => $club->id]);

        $response = $this->withHeaders(['X-ROLE' => 'admin'])
                         ->deleteJson("/api/jugadors/{$jugador->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('jugadors', ['id' => $jugador->id]);
    }
}