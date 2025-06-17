<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EstudianteInvitado;
use App\Models\UnidadesMilitares;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EstudiantesInvitadosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function resumenInvitadosPorUnidad(Request $request)
    {
        $gestion = $request->input('gestion', Carbon::now()->year);

        $query = EstudianteInvitado::query()
            ->join('cupos as c', 'c.codigo_unidad', '=', 'estudiantes_invitados.codigo_unidad')
            ->join('unidades_militares as um', 'um.codigo', '=', 'c.id_reclutamiento')
            ->select(
                'um.codigo as id_unidad_militar',
                'um.descripcion as unidad_militar',
                'c.gestion',
                \DB::raw('COUNT(estudiantes_invitados.id) as cantidad_registrados')
            )
            ->where('estudiantes_invitados.invitado', true)
             ->where('estudiantes_invitados.gestion', $gestion)
            ->where('c.gestion', $gestion)
            ->groupBy('um.codigo', 'um.descripcion', 'c.gestion');

        // Filtros opcionales
        if ($request->filled('id_fuerza')) {
            $query->where('um.id_fuerza', $request->id_fuerza);
        }

        if ($request->filled('id_centro')) {
            $query->where('um.codigo', $request->id_centro);
        }

        $resumen = $query->get();

        return response()->json([
            'status' => true,
            'data' => $resumen
        ]);
    }
    public function listadoInvitadosPorReclutamiento(int $id_centro_reclutamiento)
    {
        try {
            $idReclutamiento = $id_centro_reclutamiento;
            $gestion = Carbon::now()->year;

            // Buscar unidad militar correspondiente al centro de reclutamiento
            $unidad = UnidadesMilitares::
                where('codigo', $id_centro_reclutamiento)
                ->where('status', true)
                ->first();

            if (!$unidad) {
                return response()->json([
                    'status' => false,
                    'message' => 'No se encontró unidad militar para el centro de reclutamiento indicado.',
                ], 404);
            }

            $invitados = EstudianteInvitado::query()
                ->join('cupos as c', 'c.codigo_unidad', '=', 'estudiantes_invitados.codigo_unidad')
                ->select(
                    'estudiantes_invitados.nombres',
                    'estudiantes_invitados.apellido_paterno',
                    'estudiantes_invitados.apellido_materno',
                    'estudiantes_invitados.correlativo',
                    'estudiantes_invitados.fecha_presentacion',
                    'estudiantes_invitados.hora_presentacion',
                    'estudiantes_invitados.codigo_unidad',
                    'estudiantes_invitados.unidad_educativa'
                )
                ->where('estudiantes_invitados.invitado', true)
                ->where('c.id_reclutamiento', $idReclutamiento)
                ->where('estudiantes_invitados.gestion', $gestion)
                ->where('c.gestion', $gestion)
                ->orderBy('c.codigo_unidad')
                ->orderBy('estudiantes_invitados.apellido_paterno')
                ->orderBy('estudiantes_invitados.apellido_materno')
                ->orderBy('estudiantes_invitados.nombres')
                ->get();

            return response()->json([
                'status' => true,
                'data' => [
                    'unidad_militar' => [
                        'id_unidad_militar' => $unidad->codigo,
                        'unidad_militar' => $unidad->descripcion,
                        'gestion' => $gestion,
                        'cantidad_registrados' => $invitados->count(),
                    ],
                    'relacion_nominal' =>  $invitados,
                ]
            ],200);
        } catch (\Exception $e) {
            // Log::error('Error al obtener listado de invitados: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error al obtener los datos.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function resumenUnidadesEducativas(int $id_centro_reclutamiento)
    {
        try {
            $idReclutamiento = $id_centro_reclutamiento;
            $gestion = Carbon::now()->year;
            $datos = EstudianteInvitado::query()
                ->join('cupos as c', 'c.codigo_unidad', '=', 'estudiantes_invitados.codigo_unidad')
                ->select(
                    'estudiantes_invitados.codigo_unidad',
                    'estudiantes_invitados.unidad_educativa',
                    'estudiantes_invitados.zona',
                    'estudiantes_invitados.direccion',
                    DB::raw("COUNT(CASE WHEN estudiantes_invitados.sexo = 'MASCULINO' THEN 1 END) as hombres"),
                    DB::raw("COUNT(CASE WHEN estudiantes_invitados.sexo = 'FEMENINO' THEN 1 END) as mujeres"),
                    DB::raw("COUNT(estudiantes_invitados.id) as total")
                )
                ->where('estudiantes_invitados.gestion', $gestion)
                ->where('c.gestion', $gestion)
                ->where('estudiantes_invitados.invitado', true)
                ->where('c.id_reclutamiento', $idReclutamiento)
                ->groupBy('estudiantes_invitados.codigo_unidad', 'estudiantes_invitados.unidad_educativa', 'estudiantes_invitados.zona', 'estudiantes_invitados.direccion')
                ->orderBy('estudiantes_invitados.unidad_educativa', 'asc')
                ->get();

            return response()->json([
                'status' => true,
                'data' => $datos
            ],200);

        } catch (\Exception $e) {
            \Log::error('Error al obtener resumen educativo: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error al procesar los datos.',
                'error' => $e->getMessage()
            ], 500);
        }
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
