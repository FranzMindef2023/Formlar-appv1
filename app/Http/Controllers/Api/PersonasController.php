<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\StorePersonaRequest;
use App\Models\Personas;
use App\Models\ResidenciasActuales;
use App\Models\DestinosPresentacion;
use App\Models\AsignacionesPresentacion;
use App\Models\UnidadesMilitares;
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
    // public function store(StorePersonaRequest $request)
    // {
    //     DB::beginTransaction();

    //     try {
    //         $data = $request->validated();

    //         // 1. Crear persona
    //         $persona = Personas::create([
    //             'nombres' => $data['nombres'],
    //             'primer_apellido' => $data['primer_apellido'],
    //             'segundo_apellido' => $data['segundo_apellido'],
    //             'ci' => $data['ci'],
    //             'expedido' => $data['lugar_expedicion'],
    //             'celular' => $data['celular'],
    //             'fecha_nacimiento' => $data['fecha_nacimiento'],
    //             'gestion' => now()->year,
    //             'status'=>$data['status']
    //             // ... otros campos si hay
    //         ]);

    //        // 2. Crear residencia_actual
    //         ResidenciasActuales::create([
    //             'persona_id' => $persona->id,
    //             'gestion' => now()->year,
    //             'id_departamento' => $data['id_departamento'],
    //             'id_lugar_recidencia' => $data['id_lugar_recidencia'],
    //             'status' => true,
    //         ]);

    //         // 3. Crear destino_presentacion
    //         DestinosPresentacion::create([
    //             'persona_id' => $persona->id,
    //             'gestion' => now()->year,
    //             'id_departamento_presenta' => $data['id_departamento_presenta'],
    //             'id_centro_reclutamiento' => $data['id_centro_reclutamiento'],
    //             'status' => true,
    //         ]);
    //         DB::commit();
    //         $residencia->load(['departamento', 'lugarResidencia']);
    //         $destino->load(['departamentoPresenta', 'centroReclutamiento']);

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'La persona fue registrada exitosamente.',
    //             'data' => [
    //                 'persona' => $persona,
    //                 'residencia_actual' => $residencia,
    //                 'destino_presentacion' => $destino,
    //             ]
    //         ], 200);

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Error al registrar persona: ' . $e->getMessage());

    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Error al registrar la persona.',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
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
                'status' => $data['status'],
            ]);

            // 2. Crear residencia_actual y guardar en variable
            $residencia = ResidenciasActuales::create([
                'persona_id' => $persona->id,
                'gestion' => now()->year,
                'id_departamento' => $data['id_departamento'],
                'id_lugar_recidencia' => $data['id_lugar_recidencia'],
                'direccion' => $data['direccion'], // ← NUEVA línea
                'status' => true,
            ]);

            // 3. Crear destino_presentacion y guardar en variable
            $destino = DestinosPresentacion::create([
                'persona_id' => $persona->id,
                'gestion' => now()->year,
                'id_departamento_presenta' => $data['id_departamento_presenta'],
                'id_centro_reclutamiento' => $data['id_centro_reclutamiento'],
                'status' => true,
            ]);

            // 4. Cargar relaciones
            $residencia->load(['departamento', 'lugarResidencia']);
            $destino->load(['departamentoPresenta', 'centroReclutamiento']);

            // Buscar asignación exacta para mostrar lugar y hora de presentación
            $unidad = UnidadesMilitares::with([
                'centroReclutamiento:id,descripcion,id_ubicacion,id_provincia',
                'centroReclutamiento.ubicacion:idubigeo,descubigeo',
                'centroReclutamiento.provincia:idubigeo,descubigeo',
                'ubicacion:idubigeo,descubigeo',
                'provincia:idubigeo,descubigeo'
            ])
            ->select('id', 'descripcion', 'fecha_presentacion', 'hora_presentacion', 'id_centro_reclutamiento', 'id_ubicacion', 'id_provincia')
            ->where('id', $destino->id_centro_reclutamiento)
            ->where('status', true)
            ->first();



            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'La persona fue registrada exitosamente.',
                'data' => [
                    'persona' => $persona,
                    'residencia_actual' => $residencia,
                    'destino_presentacion' => $destino,
                    'asignacion_presentacion' => $unidad
                ]
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
    public function consultarDatosPersona(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string',
            'ci' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'primer_apellido' => 'nullable|string',
            'segundo_apellido' => 'nullable|string',
        ]);

        try {
            $query = Personas::where('nombres', $request->query('nombres'))
                ->where('ci', $request->query('ci'))
                ->where('fecha_nacimiento', $request->query('fecha_nacimiento'));

            if ($request->filled('primer_apellido')) {
                $query->where('primer_apellido', $request->query('primer_apellido'));
            }

            if ($request->filled('segundo_apellido')) {
                $query->where('segundo_apellido', $request->query('segundo_apellido'));
            }

            $persona = $query->first();

            if (!$persona) {
                return response()->json([
                    'status' => false,
                    'message' => 'Persona no encontrada.'
                ], 200);
            }

            $residencia = ResidenciasActuales::with(['departamento', 'lugarResidencia'])
                ->where('persona_id', $persona->id)
                ->where('gestion', now()->year)
                ->first();

            $destino = DestinosPresentacion::with(['departamentoPresenta', 'centroReclutamiento'])
                ->where('persona_id', $persona->id)
                ->where('gestion', now()->year)
                ->first();

            $asignacion = null;
            if ($residencia && $destino) {
                $asignacion = UnidadesMilitares::with([
                    'centroReclutamiento:id,descripcion,id_ubicacion,id_provincia',
                    'centroReclutamiento.ubicacion:idubigeo,descubigeo',
                    'centroReclutamiento.provincia:idubigeo,descubigeo',
                    'ubicacion:idubigeo,descubigeo',
                    'provincia:idubigeo,descubigeo'
                ])
                ->select(
                    'id',
                    'descripcion',
                    'fecha_presentacion',
                    'hora_presentacion',
                    'id_centro_reclutamiento',
                    'id_ubicacion',
                    'id_provincia'
                )
                ->where('id', $destino->id_centro_reclutamiento)
                ->where('status', true)
                ->first();
            }

            return response()->json([
                'status' => true,
                'message' => 'Datos encontrados: la persona ya está registrada.',
                'data' => [
                    'persona' => $persona,
                    'residencia_actual' => $residencia,
                    'destino_presentacion' => $destino,
                    'asignacion_presentacion' => $asignacion
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al consultar datos: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error al consultar datos.',
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

    public function resumenRegistroPorUnidad(Request $request)
    {
        $gestion = $request->input('gestion', now()->year);

        $query = Personas::query()
            ->join('destinos_presentacion as dp', 'dp.persona_id', '=', 'personas.id')
            ->join('unidades_militares as um', 'dp.id_centro_reclutamiento', '=', 'um.id')
            ->select(
                'um.id as id_unidad_militar',
                'um.descripcion as unidad_militar',
                'dp.gestion',
                \DB::raw('COUNT(personas.id) as cantidad_registrados')
            )
            ->where('dp.status', true)
            ->where('dp.gestion', $gestion)
            ->groupBy('um.id', 'um.descripcion', 'dp.gestion');

        if ($request->filled('id_fuerza')) {
            $query->where('um.id_fuerza', $request->id_fuerza);
        }

        if ($request->filled('id_unidad_militar')) {
            $query->where('um.id', $request->id_unidad_militar);
        }

        $resumen = $query->get();

        return response()->json([
            'status' => true,
            'data' => $resumen
        ]);
    }
    public function filtrarPersonas(Request $request)
    {
        $query = Personas::query()
            ->select('personas.*')
            ->join('destinos_presentacion as dp', 'dp.persona_id', '=', 'personas.id')
            ->join('unidades_militares as um', 'dp.id_centro_reclutamiento', '=', 'um.id');

        // Aplicar filtros dinámicamente si están presentes
        if ($request->filled('id_fuerza')) {
            $query->where('um.id_fuerza', $request->id_fuerza);
        }

        if ($request->filled('id_centro_reclutamiento')) {
            $query->where('um.id_centro_reclutamiento', $request->id_centro_reclutamiento);
        }

        if ($request->filled('id_unidad_militar')) {
            $query->where('um.id', $request->id_unidad_militar);
        }

        $query->where('dp.status', true); // solo asignaciones activas

        $personas = $query->get();

        return response()->json([
            'status' => true,
            'data' => $personas
        ]);
    }


}
