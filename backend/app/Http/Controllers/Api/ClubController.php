<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    // GET /api/clubs
    public function index()
    {
        return Club::all();
    }

    // GET /api/clubs/{id}
    public function show($id)
    {
        return Club::findOrFail($id);
    }

    // POST /api/clubs
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'ciudad' => 'required',
            'categoria' => 'required',
        ]);

        return Club::create($request->all());
    }

    // PUT /api/clubs/{id}
    public function update(Request $request, $id)
    {
        $club = Club::findOrFail($id);
        $club->update($request->all());

        return $club;
    }

    // DELETE /api/clubs/{id}
    public function destroy($id)
    {
        Club::destroy($id);
        return response()->json(['message' => 'Club eliminado']);
    }
}
