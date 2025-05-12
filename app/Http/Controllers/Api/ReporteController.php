<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\StorePersonaRequest;
use App\Models\Personas;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function personasPorCentro($idCentro)
    {
        try {
            $gestion = Carbon::now()->year;

            $personas = Personas::with(['centroReclutamiento', 'unidadEspecial'])
                ->where('id_centro_reclutamiento', $idCentro)
                ->whereYear('created_at', $gestion)
                ->get()
                ->map(function ($persona) {
                    $persona->edad = Carbon::parse($persona->fecha_nacimiento)->age;
                    return $persona;
                });

            return response()->json($personas);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Error al obtener personas por centro',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }
    public function todasLasPersonas()
    {
        try {
            $gestion = Carbon::now()->year;

            $personas = Personas::with(['centroReclutamiento', 'unidadEspecial'])
                ->whereYear('created_at', $gestion)
                ->get()
                ->map(function ($persona) {
                    $persona->edad = Carbon::parse($persona->fecha_nacimiento)->age;
                    return $persona;
                });

            return response()->json($personas);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Error al listar todas las personas',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }
    public function resumenPorUnidadEspecial()
    {
        try {
            $gestion = Carbon::now()->year;

            $resumen = DB::table('personas')
                ->join('unidades_especiales', 'personas.id_centro_reclutamiento', '=', 'unidades_especiales.id')
                ->where('unidades_especiales.status', 1)
                ->whereYear('personas.created_at', $gestion)
                ->select('unidades_especiales.descripcion', DB::raw('COUNT(personas.id) as total'))
                ->groupBy('unidades_especiales.descripcion')
                ->get();

            return response()->json($resumen);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Error al generar el resumen',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }
}
