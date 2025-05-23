<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\StorePersonaRequest;
use App\Models\Personas;
use App\Models\ResidenciasActuales;
use App\Models\DestinosPresentacion;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();

        try {
            $data = $request->validated();

            // 1. Crear persona
            $persona = Personas::create([
                'nombres' => $data['nombres'],
                'primer_apellido' => $data['primer_apellido'],
                'segundo_apellido' => $data['segundo_apellido'],
                'ci' => $data['ci'],
                'expedido' => $data['lugar_expedicion'],
                'celular' => $data['celular'],
                'fecha_nacimiento' => $data['fecha_nacimiento'],
                'gestion' => now()->year,
                'status'=>$data['status']
                // ... otros campos si hay
            ]);

           // 2. Crear residencia_actual
            ResidenciasActuales::create([
                'persona_id' => $persona->id,
                'gestion' => now()->year,
                'id_departamento' => $data['id_departamento'],
                'id_lugar_recidencia' => $data['id_lugar_recidencia'],
                'status' => true,
            ]);

            // 3. Crear destino_presentacion
            DestinosPresentacion::create([
                'persona_id' => $persona->id,
                'gestion' => now()->year,
                'id_departamento_presenta' => $data['id_departamento_presenta'],
                'id_centro_reclutamiento' => $data['id_centro_reclutamiento'],
                'status' => true,
            ]);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'La persona fue registrada exitosamente.',
                'data' => $persona
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
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
