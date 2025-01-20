<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{


    public function ei($id)
    {
        try {
            $result = DB::select("
            SELECT cr.regimiento, p.*
            FROM premilitars p
            JOIN unidades_educativas ue ON p.codigo_unidad_educativa = ue.codigo
            JOIN cupos_unidades_educativas cue ON ue.codigo = cue.unidades_educativa_codigo
            JOIN centros_reclutamientos cr ON cue.centros_reclutamiento_id = cr.id
            WHERE p.invitado
            AND cr.id = ?
            AND p.gestion = EXTRACT(YEAR FROM CURRENT_DATE)::INT
            ORDER BY p.oficio
        ", [$id]);

            return response()->json([
                'success' => true,
                'data' => $result,
            ], 200);
        } catch (\Exception $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'error' => $th->getMessage(), // Para depuración.
            ], 500);
        }
    }
}
