<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jugador;
use Illuminate\Http\Request;

class JugadorController extends Controller
{
    // GET /api/jugadors
    public function index()
    {
        return Jugador::with('club')->get();
    }

    // GET /api/jugadors/{id}
    public function show($id)
    {
        return Jugador::with('club')->findOrFail($id);
    }

    // POST /api/jugadors
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'posicion' => 'required',
            'dorsal' => 'required|integer',
            'club_id' => 'required|exists:clubs,id',
        ]);

        return Jugador::create($request->all());
    }

    // PUT /api/jugadors/{id}
    public function update(Request $request, $id)
    {
        $jugador = Jugador::findOrFail($id);
        $jugador->update($request->all());

        return $jugador;
    }

    // DELETE /api/jugadors/{id}
    public function destroy($id)
    {
        Jugador::destroy($id);
        return response()->json(['message' => 'Jugador eliminado']);
    }
}
