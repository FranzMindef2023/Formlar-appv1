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
    public function index()
    {
        $centros_reclutamiento =  CentrosReclutamiento::all();

        if ($centros_reclutamiento->isEmpty()) {
            return response()->json([
                "message" => "centros_reclutamiento is empty",
            ]);
        }

        return response()->json([
            "data" => $centros_reclutamiento,
            "message" => "centros_reclutamiento retrieved successfully",
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
