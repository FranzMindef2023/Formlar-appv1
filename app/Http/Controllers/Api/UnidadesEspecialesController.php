<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UnidadesMilitares;

class UnidadesEspecialesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $unidades = DB::table('unidades_militares as um')
        ->join('ubicacion_geografica as ug', 'um.id_provincia', '=', 'ug.idubigeo')
        ->select('um.id', 'ug.descubigeo as nombre', 'ug.nivel', 'um.id_ubicacion')
        ->where('um.id_ubicacion', $id)
        ->where('um.es_centro_reclutamiento', false)
        ->whereNotNull('um.id_centro_reclutamiento')
        ->where('um.status', true) // solo activos
        ->get();

        return response()->json($unidades);
    }
    public function listarCentrosReclutamiento(Request $request)
    {
        // Validar que venga id_fuerza
        $request->validate([
            'id_fuerza' => 'required|integer|exists:fuerzas,id'
        ]);

        $centros =UnidadesMilitares::query()
            ->where('es_centro_reclutamiento', true)
            ->where('status', true)
            ->where('id_fuerza', $request->id_fuerza)
            ->select('id', 'descripcion')
            ->orderBy('descripcion')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $centros
        ],200);
    }
    public function unidadesPorCentro(Request $request)
    {
        // Validar que venga id_fuerza
        $request->validate([
            'id_centro_reclutamiento' => 'required|integer|exists:unidades_militares,id'
        ]);
    

        $unidades =UnidadesMilitares::where('id_centro_reclutamiento', $request->id_centro_reclutamiento)
            ->where('status', true)
            ->select('id', 'descripcion')
            ->orderBy('descripcion')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $unidades
        ]);
    }
    public function listarUnidadesMilitares(Request $request)
    {
        // Validar que venga id_fuerza
        $request->validate([
            'id_fuerza' => 'required|integer|exists:fuerzas,id'
        ]);

        $centros = UnidadesMilitares::query()
            ->where('es_centro_reclutamiento', false)                // No son centros de reclutamiento
            ->whereNotNull('id_centro_reclutamiento')               // Están asignados a un centro
            ->where('status', true)                                 // Solo activos
            ->where('id_fuerza', $request->id_fuerza)               // De una fuerza específica
            ->select('id', 'descripcion')
            ->orderBy('descripcion')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $centros
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
