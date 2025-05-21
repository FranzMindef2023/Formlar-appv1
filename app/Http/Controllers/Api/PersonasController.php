<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\StorePersonaRequest;
use App\Models\Personas;
use Illuminate\Support\Facades\Log;

class PersonasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonaRequest $request)
    {
        // return $request->all();
        return response()->json([
            'status' => true,
            'message' => 'La persona fue registrada exitosamente.',
            'data' => $request->all()
        ], 200);
        try {
            $data = $request->validated();

            $persona = Personas::create($data);

            return response()->json([
                'status' => true,
                'message' => 'La persona fue registrada exitosamente.',
                'data' => $persona
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al registrar persona: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error al registrar la persona.',
                'error' => $e->getMessage()
            ], 500);
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
