<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCuposUnidadesEducativasRequest;
use App\Http\Requests\UpdateCuposUnidadesEducativasRequest;
use App\Models\CuposCentrosReclutamiento;
use App\Models\CuposUnidadesEducativa;
use App\Models\Premilitar;
use App\Models\VistaPorcentaje;
use Illuminate\Http\Request;

class CuposUnidadesEducativaController extends Controller
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

    private function errorResponse($error, $message = 'Something went wrong!', $status = 400)
    {
        return response()->json([
            'success' => false,
            'error' => $error,
            'message' => $message,
        ], $status);
    }
    public function index()
    {
        $cupos_unidades_educativa = CuposUnidadesEducativa::all();

        if ($cupos_unidades_educativa->isEmpty()) {
            return $this->errorResponse(null, 'Cupos de Unidades Educativas is empty.');
        }

        return $this->successResponse($cupos_unidades_educativa, 'Cupos unidades educativas retrived successfully.');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCuposUnidadesEducativasRequest $request)
    {
        try {

            $total_cupos_centro_reclutamiento = CuposCentrosReclutamiento
                ::where('id_centros_reclutamiento', $request->centros_reclutamiento_id)
                ->where('gestion', $request->gestion)
                ->first();

            if (!$total_cupos_centro_reclutamiento) {
                return $this->errorResponse(null, 'No se habilitaron cupos para el centro de reclutamiento en la gestion ' . $request->gestion);
            }

            $sum_cupos_ue_cr = CuposUnidadesEducativa
                ::where('centros_reclutamiento_id', $request->centros_reclutamiento_id)
                ->where('gestion', $request->gestion)
                ->sum('cupos');

            if ($sum_cupos_ue_cr + $request->cupos > $total_cupos_centro_reclutamiento->cupo) {
                return $this->errorResponse('La cantidad de cupos disponibles para asignar a la unidad educativa con el centro de reclutamiento ' . $request->centros_reclutamiento_id . ' y con la apertura de la gestion ' . $request->gestion . ' es ' . $total_cupos_centro_reclutamiento->cupo - $sum_cupos_ue_cr, 'La cantidad total de cupos no puede exceder el limite definido para la gestion actual.', 422);
            }


            $porcentaje_ue = VistaPorcentaje::where('codigo_unidad_educativa', $request->unidades_educativa_codigo)
                ->where('gestion', $request->gestion)
                ->first();

            if ($request->cupos > $porcentaje_ue->total_estudiantes) {
                return $this->errorResponse(null, 'La cantidad de cupos a asignar excede a la cantidad total de estudiantes');
            }

            $aceptado_hombres = round(($request->cupos * $request->porcentaje_hombres) / 100);
            if ($aceptado_hombres > $porcentaje_ue->total_hombres) {
                return $this->errorResponse(null, 'La cantidad de cupos a asignar o el porcentaje asignado no cumple con la cantidad de hombres que tiene la unidad educativa');
            }
            $aceptado_mujeres = round(($request->cupos * $request->porcentaje_mujeres) / 100);
            if ($aceptado_mujeres > $porcentaje_ue->total_mujeres) {
                return $this->errorResponse(null, 'La cantidad de cupos a asignar o el porcentaje asignado no cumple con la cantidad de mujeres que tiene la unidad educativa');
            }

            if ($aceptado_hombres + $aceptado_mujeres != $request->cupos) {
                return $this->errorResponse(null, 'La cantidad de personas habilitadas por edad es menor a los cupos a asignar');
            }

            //vdc04045

            $data = array_merge($request->validated(), [
                'aceptado_hombres' => $aceptado_hombres,
                'aceptado_mujeres' => $aceptado_mujeres,
            ]);



            $cupos_unidad_educativa = CuposUnidadesEducativa::create($data);
            Premilitar::join('unidades_educativas as ue', 'premilitars.codigo_unidad_educativa', '=', 'ue.codigo')
                ->where('ue.codigo', $request->unidades_educativa_codigo)
                ->where('premilitars.sexo', 'FEMENINO')
                ->where('premilitars.habilitado_edad', true)
                ->where('gestion', date('Y'))
                ->orderBy('premilitars.nota_promedio', 'desc')
                ->limit($aceptado_mujeres)
                ->update(['habilitado_notas' => true, 'invitado' => true]);

            Premilitar::join('unidades_educativas as ue', 'premilitars.codigo_unidad_educativa', '=', 'ue.codigo')
                ->where('ue.codigo', $request->unidades_educativa_codigo)
                ->where('premilitars.sexo', 'MASCULINO')
                ->where('premilitars.habilitado_edad', true)
                ->where('gestion', date('Y'))
                ->orderBy('premilitars.nota_promedio', 'desc')
                ->limit($aceptado_hombres)
                ->update(['habilitado_notas' => true, 'invitado' => true]);


            return $this->successResponse($cupos_unidad_educativa, 'Cupos de la unidad educativa updated succesfully.');
        } catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $cupos_unidad_educativa = CuposUnidadesEducativa::findOrFail($id);



            return $this->successResponse($cupos_unidad_educativa, 'Cupos de la unidad educativa retrieved successfully.');
        } catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCuposUnidadesEducativasRequest $request, string $id)
    {
        try {
            $total_cupos_centro_reclutamiento = CuposCentrosReclutamiento
                ::where('id_centros_reclutamiento', $request->centros_reclutamiento_id)
                ->where('gestion', $request->gestion)
                ->first();

            if (!$total_cupos_centro_reclutamiento) {
                return $this->errorResponse(null, 'No se habilitaron cupos para el centro de reclutamiento en la gestion ' . $request->gestion);
            }

            $sum_cupos_ue_cr = CuposUnidadesEducativa
                ::where('centros_reclutamiento_id', $request->centros_reclutamiento_id)
                ->where('gestion', $request->gestion)
                ->sum('cupos');

            if ($sum_cupos_ue_cr + $request->cupos > $total_cupos_centro_reclutamiento->cupo) {
                return $this->errorResponse('La cantidad de cupos disponibles para asignar a la unidad educativa con el centro de reclutamiento ' . $request->centros_reclutamiento_id . ' y con la apertura de la gestion ' . $request->gestion . ' es ' . $total_cupos_centro_reclutamiento->cupo - $sum_cupos_ue_cr, 'La cantidad total de cupos no puede exceder el limite definido para la gestion actual.', 422);
            }


            $porcentaje_ue = VistaPorcentaje::where('codigo_unidad_educativa', $id)
                ->where('gestion', $request->gestion)
                ->first();

            if ($request->cupos > $porcentaje_ue->total_estudiantes) {
                return $this->errorResponse(null, 'La cantidad de cupos a asignar excede a la cantidad total de estudiantes');
            }

            $aceptado_hombres = round(($request->cupos * $request->porcentaje_hombres) / 100);
            if ($aceptado_hombres > $porcentaje_ue->total_hombres) {
                return $this->errorResponse(null, 'La cantidad de cupos a asignar o el porcentaje asignado no cumple con la cantidad de hombres que tiene la unidad educativa');
            }
            $aceptado_mujeres = round(($request->cupos * $request->porcentaje_mujeres) / 100);
            if ($aceptado_mujeres > $porcentaje_ue->total_mujeres) {
                return $this->errorResponse(null, 'La cantidad de cupos a asignar o el porcentaje asignado no cumple con la cantidad de mujeres que tiene la unidad educativa');
            }
            $data = array_merge($request->validated(), [
                'aceptado_hombres' => $aceptado_hombres,
                'aceptado_mujeres' => $aceptado_mujeres,
            ]);


            $cupos_unidad_educativa = CuposUnidadesEducativa
                ::firstWhere('unidades_educativa_codigo', $request->$id)
                ->where('gestion', $request->gestion)
                ->update($data);

            Premilitar::join('unidades_educativas as ue', 'premilitars.codigo_unidad_educativa', '=', 'ue.codigo')
                ->where('ue.codigo', $id)
                ->where('premilitars.habilitado_edad', true)
                ->where('gestion', date('Y'))
                ->update(['habilitado_notas' => false, 'invitado' => false]);

            Premilitar::join('unidades_educativas as ue', 'premilitars.codigo_unidad_educativa', '=', 'ue.codigo')
                ->where('ue.codigo', $request->unidades_educativa_codigo)
                ->where('premilitars.sexo', 'FEMENINO')
                ->where('premilitars.habilitado_edad', true)
                ->where('gestion', date('Y'))
                ->orderBy('premilitars.nota_promedio', 'desc')
                ->limit($aceptado_mujeres)
                ->update(['habilitado_notas' => true, 'invitado' => true]);

            Premilitar::join('unidades_educativas as ue', 'premilitars.codigo_unidad_educativa', '=', 'ue.codigo')
                ->where('ue.codigo', $request->unidades_educativa_codigo)
                ->where('premilitars.sexo', 'MASCULINO')
                ->where('premilitars.habilitado_edad', true)
                ->where('gestion', date('Y'))
                ->orderBy('premilitars.nota_promedio', 'desc')
                ->limit($aceptado_hombres)
                ->update(['habilitado_notas' => true, 'invitado' => true]);


            return $this->successResponse($cupos_unidad_educativa, 'Cupos de la unidad educativa created succesfully.');
        } catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $cupos_unidad_educativa = CuposUnidadesEducativa::findOrFail($id);

            $cupos_unidad_educativa->delete();

            Premilitar::join('unidades_educativas as ue', 'premilitars.codigo_unidad_educativa', '=', 'ue.codigo')
                ->where('ue.codigo', $id)
                ->where('premilitars.habilitado_edad', true)
                ->where('gestion', date('Y'))
                ->update(['habilitado_notas' => false, 'invitado' => false]);


            $this->successResponse($id);
        } catch (\Exception $th) {
            $this->errorResponse($th->getMessage());
        }
    }
}
