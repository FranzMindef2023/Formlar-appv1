<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $divisiones = Division::with('cupos_divisiones')
            ->get();

        if ($divisiones->isEmpty()) {
            return response()->json([
                "message" => "divisiones is empty",
            ]);
        }

        return response()->json([
            "data" => $divisiones,
            "message" => "divisiones retrieved successfully",
        ]);
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
            $division = Division::with('cupos_divisiones')
                ->firstWhere('codigo', $id);


            return response()->json([
                "success" => true,
                "data" => $division,
                "message" => "divisiones retrieved successfully",
            ]);
        } catch (\Exception $th) {
            return response()->json([
                "success" => true,
                "error" => $th->getMessage(),
                "message" => "Something went wrong!",
            ]);
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
            $divisiones = Division::with([
                'cupos_divisiones' => function ($query) {
                    $query->where('gestion_apertura', date('Y'));
                }
            ])
                ->get();

            return response()->json([
                "success" => true,
                "data" => $divisiones,
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
            $divisiones = Division::with([
                'cupos_divisiones' => function ($query) use ($year) {
                    $query->where('gestion_apertura', $year);
                }
            ])
                ->get();

            return response()->json([
                "success" => true,
                "data" => $divisiones,
                "message" => "Divisiones retrieved successfully",
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
