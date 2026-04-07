<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Liga;
use Illuminate\Http\Request;

class LigaController extends Controller
{
    // GET /api/ligas
    public function index()
    {
        return Liga::with('partidos')->get();
    }

    // GET /api/ligas/{id}
    public function show($id)
    {
        return Liga::with('partidos')->findOrFail($id);
    }

    // POST /api/ligas
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'deporte' => 'required',
            'temporada' => 'required',
        ]);

        return Liga::create($request->all());
    }

    // PUT /api/ligas/{id}
    public function update(Request $request, $id)
    {
        $liga = Liga::findOrFail($id);
        $liga->update($request->all());

        return $liga;
    }

    // DELETE /api/ligas/{id}
    public function destroy($id)
    {
        Liga::destroy($id);
        return response()->json(['message' => 'Liga eliminada']);
    }
}
