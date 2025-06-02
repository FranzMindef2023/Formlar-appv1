<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\StorePersonaRequest;
use App\Models\UnidadesMilitares;
use App\Models\Personas;
use Illuminate\Support\Facades\DB;
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
    //nuevo funcion de reportes
    public function obtenerRelacionNominalPorCentro($id_centro_reclutamiento)
    {
        try {
            $gestion = date('Y'); // Año actual

            // Buscar unidad militar correspondiente al centro de reclutamiento
            $unidad = UnidadesMilitares::
                where('id', $id_centro_reclutamiento)
                ->where('status', true)
                ->first();

            if (!$unidad) {
                return response()->json([
                    'status' => false,
                    'message' => 'No se encontró unidad militar para el centro de reclutamiento indicado.',
                ], 404);
            }

            // Buscar personas asignadas a esa unidad en la gestión actual
            $relacion = DB::table('destinos_presentacion as dp')
                ->join('personas as p', 'dp.persona_id', '=', 'p.id')
                ->where('dp.id_centro_reclutamiento', $id_centro_reclutamiento)
                ->where('dp.gestion', $gestion)
                ->where('dp.status', true)
                ->select(
                    'p.id',
                    'p.nombres',
                    'p.primer_apellido',
                    'p.segundo_apellido',
                    'p.ci',
                    'p.complemento_ci',
                    'p.expedido',
                    'p.fecha_nacimiento'
                )
                ->orderBy('p.primer_apellido')
                ->get();

            return response()->json([
                'status' => true,
                'data' => [
                    'unidad_militar' => [
                        'id_unidad_militar' => $unidad->id,
                        'unidad_militar' => $unidad->descripcion,
                        'gestion' => $gestion,
                        'cantidad_registrados' => $relacion->count(),
                    ],
                    'relacion_nominal' => $relacion,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al obtener la relación nominal.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
