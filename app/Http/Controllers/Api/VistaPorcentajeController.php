<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UnidadesEducativa;
use App\Models\VistaPorcentaje;

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
}
