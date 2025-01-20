<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CentrosReclutamiento;
use Illuminate\Http\Request;

class CentrosReclutamientoController extends Controller
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
    private function errorResponse($error = 'Something went wrong!', $message = '', $status = 400)
    {
        return response()->json([
            'success' => false,
            'error' => $error,
            'message' => $message,
        ], $status);
    }
    public function index()
    {
        $centros_reclutamiento =  CentrosReclutamiento::all();

        if ($centros_reclutamiento->isEmpty()) {
            return $this->errorResponse(null, 'Centros reclutamiento is empty', 404);
        }

        return $this->successResponse($centros_reclutamiento, 'Centros reclutamiento retrieved successfully');
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
            $centro_reclutamiento = CentrosReclutamiento
                ::with([
                    'cupos_centros_reclutamientos_gestiones' => function ($query) {
                        $query->orderBy('created_at', 'desc');
                    },
                    'fuerza'
                ])->findOrFail($id);

            return $this->successResponse($centro_reclutamiento, "Centro de reclutamiento retrieved succesfully", 200);
        } catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
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

    public function show_actual_gestion()
    {
        try {
            $centros_reclutamiento = CentrosReclutamiento::with([
                'cupos_centros_reclutamientos_gestiones' => function ($query) {
                    $query->where('gestion', date('Y'));
                }
            ])
                ->get();

            return response()->json([
                "success" => true,
                "data" => $centros_reclutamiento,
                "message" => "divisiones retrieved successfully",
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                "success" => true,
                "error" => $e->getMessage(),
                "message" => "Something went wrong!",
            ]);
        }
    }

    public function show_by_gestion(string $year)
    {
        try {
            $centros_reclutamiento = CentrosReclutamiento::with([
                'cupos_centros_reclutamientos_gestiones' => function ($query) use ($year) {
                    $query->where('gestion', $year);
                }
            ])->get();

            $centros_reclutamiento = $centros_reclutamiento->map(function ($centro) {
                $centro->cupos = $centro->cupos_centros_reclutamientos_gestiones->sum('cupo');
                return $centro;
            });

            return response()->json([
                "success" => true,
                "data" => $centros_reclutamiento,
                "message" => "Centros de reclutamiento retrieved successfully",
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                "success" => false,
                "error" => $e->getMessage(),
                "message" => "Something went wrong!",
            ]);
        }
    }
}
