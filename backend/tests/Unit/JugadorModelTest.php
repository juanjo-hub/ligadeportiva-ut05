<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Club;
use App\Models\Jugador;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JugadorModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_jugador_tiene_campos_fillable_correctos()
    {
        $jugador = new Jugador();

        $this->assertEquals(
            ['nombre', 'posicion', 'dorsal', 'club_id'],
            $jugador->getFillable()
        );
    }

    public function test_jugador_pertenece_a_un_club()
    {
        $club = Club::factory()->create(['nombre' => 'Fénix eSports']);

        $jugador = Jugador::factory()->create([
            'nombre'  => 'Ana López',
            'club_id' => $club->id,
        ]);

        $this->assertInstanceOf(Club::class, $jugador->club);
        $this->assertEquals('Fénix eSports', $jugador->club->nombre);
    }

    public function test_club_tiene_muchos_jugadores()
    {
        $club = Club::factory()->create();

        Jugador::factory()->count(3)->create(['club_id' => $club->id]);

        $this->assertCount(3, $club->jugadors);
    }

    public function test_jugador_se_crea_con_factory()
    {
        $jugador = Jugador::factory()->create();

        $this->assertDatabaseHas('jugadors', [
            'id' => $jugador->id,
        ]);
    }

    public function test_eliminar_club_elimina_jugadores_en_cascada()
    {
        $club = Club::factory()->create();
        $jugador = Jugador::factory()->create(['club_id' => $club->id]);

        $club->delete();

        $this->assertDatabaseMissing('jugadors', ['id' => $jugador->id]);
    }
}