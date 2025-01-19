<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UnidadesEducativa;
use Illuminate\Http\Request;

class UnidadesEducativaController extends Controller
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
            'error' => $error,
            'message' => $message,
        ], $status);
    }

    public function index()
    {
        try {
            $ue = UnidadesEducativa::with([
                'cupos_unidades_educativa' => function ($query) {
                    $query->where('gestion', date('Y'));
                },
            ])
                ->get(); // NOTE  in the future could fail

            if ($ue->isEmpty()) {
                return $this->errorResponse(null, 'No hay unidades educativas disponibles.');
            }

            return $this->successResponse($ue, 'Unidades educativas recuperadas exitosamente.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Error al recuperar unidades educativas.');
        }
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
        try {
            $ue = UnidadesEducativa::with([
                'cupos_unidades_educativa' => function ($query) {
                    $query->where('gestion', date('Y'));
                },
            ])
                ->firstWhere('codigo', $id);


            return $this->successResponse($ue, 'Unidades educativas recuperadas exitosamente.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Error al recuperar unidades educativas.');
        }
    }


    public function show_actual_gestion()
    {
        try {
            $ue = UnidadesEducativa::with([
                'cupos_unidades_educativa' => function ($query) {
                    $query->where('gestion', date('Y'));
                },
            ])
                ->get(); // NOTE  in the future could fail

            if ($ue->isEmpty()) {
                return $this->errorResponse(null, 'No hay unidades educativas disponibles.');
            }

            return $this->successResponse($ue, 'Unidades educativas recuperadas exitosamente.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Error al recuperar unidades educativas.');
        }
    }

    public function show_by_gestion(string $year)
    {
        try {
            $ue = UnidadesEducativa::with([
                'cupos_unidades_educativa' => function ($query) use ($year) {
                    $query->where('gestion', $year);
                },
            ])
                ->get(); // NOTE  in the future could fail

            if ($ue->isEmpty()) {
                return $this->errorResponse(null, 'No hay unidades educativas disponibles.');
            }

            return $this->successResponse($ue, 'Unidades educativas recuperadas exitosamente.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Error al recuperar unidades educativas.');
        }
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
