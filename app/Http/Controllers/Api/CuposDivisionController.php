<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCuposDivisionRequest;
use App\Http\Requests\UpdateCuposDivisionRequest;
use App\Models\Apertura;
use App\Models\CuposDivision;
use Illuminate\Http\Request;

class CuposDivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private function successResponse($data, $message = '', $status = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message
        ], $status);
    }
    private function errorResponse($error = 'Something went wrong!', $message = 'Something went wrong!', $status = 400)
    {
        return response()->json([
            'success' => false,
            'error' => $error,
            'message' => $message
        ], $status);
    }
    public function index()
    {
        $cupos_divisiones = CuposDivision::all();

        if ($cupos_divisiones->isEmpty()) {

            return $this->errorResponse(null, 'Cupos divisiones is empty.', 404);
        }

        return $this->successResponse($cupos_divisiones, 'Cupos divisones retrieved successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCuposDivisionRequest $request)
    {


        try {
            $total = Apertura::firstWhere('gestion', date('Y'));
            if (!$total) {
                return $this->errorResponse(null, 'No se ha abierto una apertura para la presente gestion');
            }
            $actual_quantity = CuposDivision::where('gestion_apertura', date('Y'))->sum('cupos');

            if ($actual_quantity + $request->cupos > $total->cantidad) {
                return $this->errorResponse('La cantidad de cupos disponibles para asignar a la apertura de la presente gestion es ' . $total->cantidad - $actual_quantity, 'La cantidad total de cupos no puede exceder el limite definido para la gestion actual.', 422);
            }

            $cupos_division = CuposDivision::create($request->all());

            return $this->successResponse($cupos_division, 'Cupos division created successfully.', 201);
        } catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
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
    public function update(UpdateCuposDivisionRequest $request, string $id)
    {
        try {
            $cupos_division = CuposDivision::findOrFail($id);

            $total = Apertura::firstWhere('gestion', $request->gestion_apertura);
            if (!$total) {
                return $this->errorResponse(null, 'No se ha abierto una apertura para la presente gestion');
            }

            $actual_quantity = CuposDivision::where('gestion_apertura', $request->gestion_apertura)->sum('cupos');

            if ($actual_quantity + $request->cupos > $total->cantidad + $cupos_division->cupos) {
                return $this->errorResponse('La cantidad de cupos disponibles para actualizar a la apertura de la gestion ' . $request->gestion_apertura . ' de la ' . $request->codigo_division . ' division es ' . $total->cantidad - $actual_quantity + $cupos_division->cupos, 'La cantidad total de cupos no puede exceder el limite definido para la gestion' . $request->gestion_apertura, 422);
            }

            $cupos_division->update($request->validated());

            return $this->successResponse($cupos_division, 'Cupos division updated successfully.', 201);
        } catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
