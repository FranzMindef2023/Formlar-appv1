<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAperturaRequest;
use App\Models\Apertura;
use Illuminate\Http\Request;

class AperturaController extends Controller
{
    public function index()
    {
        $aperturas =  Apertura::all();

        if ($aperturas->isEmpty()) {
            return response()->json([
                'message' => 'aperturas list is empty',
            ], 404);
        }

        return response()->json([
            'data' => $aperturas,
            'message' => 'aperturas list retrieved successfully',
        ], 200);
    }

    public function store(StoreAperturaRequest $request)
    {
        try {
            $apertura = Apertura::create($request->all());
            return response()->json([
                'data' => $apertura,
                'message' => 'apertura created successfully',
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'message' => 'something went wrong.',
                'error' => $th->getMessage(),
            ]);
        }
    }
    public function show(string $id)
    {
        $apertura = Apertura::find($id);

        if (!$apertura) {
            return response()->json([
                'message' => 'apertura not found',
            ]);
        }

        return response()->json([
            'data' => $apertura,
            'message' => 'apertura found.',
        ]);
    }
}
