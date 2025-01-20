<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UnidadesEducativa;
use App\Models\VistaPorcentaje;
use Illuminate\Support\Facades\DB;

class VistaPorcentajeController extends Controller
{
    public function index()
    {
        //
    }
    public function show_by_ue_gestion(string $ue_id, string $gestion)
    {
        try {
            if (!UnidadesEducativa::where('codigo', $ue_id)->exists()) {
                return response()->json([
                    'success' => false,
                    'error' =>  'Something went wrong!',
                    'message' => 'El codigo de la unidad educativa proporcionado no existe.',
                ], 404);
            }
            if (!VistaPorcentaje::where('gestion', $gestion)->exists()) {
                return response()->json([
                    'success' => false,
                    'error' =>  'Something went wrong!',
                    'message' => 'La gestion buscada no fue previamente aperturada.',
                ], 404);
            }

            $porcentaje_ue = VistaPorcentaje::where('codigo_unidad_educativa', $ue_id)
                ->where('gestion', $gestion)
                ->first();


            return response()->json([
                'success' => true,
                'data' => $porcentaje_ue,
                'message' => 'Porcentaje retrieved successfully',
            ], 200);
        } catch (\Exception $th) {
            return response()->json([
                'success' => false,
                'error' => $th->getMessage(),
                'message' => 'Something went wrong!',
            ], 500);
        }
    }
    public function show_by_ue(string $ue_id)
    {
        try {
            if (!UnidadesEducativa::where('codigo', $ue_id)->exists()) {
                return response()->json([
                    'success' => false,
                    'error' =>  'Something went wrong!',
                    'message' => 'El codigo de la unidad educativa proporcionado no existe.',
                ], 404);
            }

            $porcentaje_ue = VistaPorcentaje::where('codigo_unidad_educativa', $ue_id)
                ->get();


            return response()->json([
                'success' => true,
                'data' => $porcentaje_ue,
                'message' => 'Porcentaje retrieved successfully',
            ], 200);
        } catch (\Exception $th) {
            return response()->json([
                'success' => false,
                'error' => $th->getMessage(),
                'message' => 'Something went wrong!',
            ], 500);
        }
    }
    public function oficio()
    {
        try {
            $premilitares = DB::statement("
            WITH ordenados AS (
                SELECT
                    p.id, -- Suponiendo que `id` es la clave primaria de `premilitars`
                    LPAD(ROW_NUMBER() OVER (ORDER BY cr.id, p.nota_promedio DESC)::TEXT,
                         LENGTH((SELECT COUNT(*) FROM premilitars WHERE invitado)::TEXT) + 1,
                         '0') AS nuevo_oficio
                FROM premilitars p
                JOIN unidades_educativas ue ON p.codigo_unidad_educativa = ue.codigo
                JOIN cupos_unidades_educativas cue ON ue.codigo = cue.unidades_educativa_codigo
                JOIN centros_reclutamientos cr ON cue.centros_reclutamiento_id = cr.id
                WHERE p.invitado
            )
            UPDATE premilitars
            SET oficio = o.nuevo_oficio
            FROM ordenados o
            WHERE premilitars.id = o.id;
        ");

            return response()->json([
                'success' => true,
                'data' => $premilitares,
                'message' => 'Oficio updated successfully',
            ], 200);
        } catch (\Exception $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'error' => $th->getMessage(), // Para depuración, opcional.
            ], 500);
        }
    }
}
