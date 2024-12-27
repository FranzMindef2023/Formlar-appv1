<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCuposUnidadesEducativasRequest;
use App\Models\CuposCentrosReclutamiento;
use App\Models\CuposUnidadesEducativa;
use Illuminate\Http\Request;

class CuposUnidadesEducativaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private function successResponse($data, $message = '', $status = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    private function errorResponse($error, $message = 'Something went wrong!', $status = 400)
    {
        return response()->json([
            'success' => false,
            'data' => $error,
            'message' => $message,
        ], $status);
    }
    public function index()
    {
        $cupos_unidades_educativa = CuposUnidadesEducativa::all();

        if ($cupos_unidades_educativa->isEmpty()) {
            return $this->errorResponse(null, 'Cupos de Unidades Educativas is empty.');
        }

        return $this->successResponse($cupos_unidades_educativa, 'Cupos unidades educativas retrived successfully.');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCuposUnidadesEducativasRequest $request)
    {
        try {
            if (!\App\Models\Apertura::where('gestion', $request->gestion)->exists()) {
                return $this->errorResponse(null, 'No se aperturo la gestion ' . $request->gestion);
            }


            $total_cupos_centro_reclutamiento = CuposCentrosReclutamiento
                ::where('id_centros_reclutamiento', $request->centros_reclutamiento_id)
                ->where('gestion', $request->gestion)
                ->first();

            if (!$total_cupos_centro_reclutamiento) {
                return $this->errorResponse(null, 'No se habilitaron cupos para el centro de reclutamiento en la gestion ' . $request->gestion);
            }

            $sum_cupos_ue_cr = CuposUnidadesEducativa
                ::where('centros_reclutamiento_id', $request->centros_reclutamiento_id)
                ->where('gestion', $request->gestion)
                ->sum('cupos');

            if ($total_cupos_centro_reclutamiento->cupos + $request->cupos > $sum_cupos_ue_cr) {
                return $this->errorResponse(null, 'El cupo ' . $total_cupos_centro_reclutamiento . ' a asignar excede el limite de cupos para el centro de reclutamiento ');
            }
            $cupos_unidad_educativa = CuposUnidadesEducativa::create($request->validated());
            return $this->successResponse($cupos_unidad_educativa, 'Cupos de la unidad educativa created succesfully.');
        } catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $cupos_unidad_educativa = CuposUnidadesEducativa::findOrFail($id);

            return $this->successResponse($cupos_unidad_educativa, 'Cupos de la unidad educativa retrieved successfully.');
        } catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CuposUnidadesEducativa $cuposUnidadesEducativa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $cupos_unidad_educativa = CuposUnidadesEducativa::findOrFail($id);

            $cupos_unidad_educativa->delete();


            $this->successResponse($id);
        } catch (\Exception $th) {
            $this->errorResponse($th->getMessage());
        }
    }
}
