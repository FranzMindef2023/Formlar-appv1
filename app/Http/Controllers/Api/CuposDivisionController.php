<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCuposDivisionRequest;
use App\Models\Apertura;
use App\Models\CuposDivision;
use Illuminate\Http\Request;

class CuposDivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cupos_divisiones = CuposDivision::all();

        if ($cupos_divisiones->isEmpty()) {
            return response()->json([
                'message' => 'cupos divisiones is empty',
            ]);
        }

        return response()->json([
            'data' => $cupos_divisiones,
            'message' => 'cupos divisiones retrieved successfully',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCuposDivisionRequest $request)
    {


        try {
            $total = Apertura::firstWhere('gestion', date('Y'))->cantidad;
            $actual_quantity = CuposDivision::where('gestion_apertura', date('Y'))->sum('cupos');

            if ($actual_quantity + $request->cupos > $total) {
                return response()->json([
                    'message' => 'la cantidad total de cupos no puede exceder el limite definido para la gestion actual.',
                ], 422);
            }

            $cupos_division = CuposDivision::create($request->all());


            return response()->json([
                'data' => $cupos_division,
                'message' => 'cupos for the division created successfully',
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'message' => 'something went wrong.',
                'error' => $th->getMessage(),
            ]);
        }
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
