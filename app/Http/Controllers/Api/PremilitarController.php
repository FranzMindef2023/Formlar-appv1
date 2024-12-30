<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CuposUnidadesEducativa;
use App\Models\Premilitar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PremilitarController extends Controller
{
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
        try {
            $premilitares = Premilitar::paginate(25);

            return $this->successResponse($premilitares, 'Premilitares recuperados exitosamente');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Internal server error.');
        }
    }
    public function index_habilitados_edad()
    {
        try {
            $premilitares = Premilitar::where('habilitado_edad', true)
                ->paginate(25);

            return $this->successResponse($premilitares, 'Premilitares recuperados exitosamente.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Internal server error.');
        }
    }
    public function index_invitados()
    {
        try {
            $premilitares = Premilitar::where('invitado', true)
                ->paginate(25);

            return $this->successResponse($premilitares, 'Premilitares recuperados exitosamente');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Internal server error.');
        }
    }
    public function am_i_invited(string $ci)
    {
        $premilitar = Premilitar::where('ci', $ci)
            ->first();

        if (!$premilitar) {
            return $this->errorResponse(null, 'Ci not found.');
        }

        if (!$premilitar->habilitado_edad) {
            return $this->successResponse($premilitar, 'El premilitar no fue invitado por que no cumple con la edad requerida');
        }

        if (!$premilitar->invitado) {
            return $this->successResponse($premilitar, 'El premilitar no fue invitado');
        }

        $centro_reclutamiento = CuposUnidadesEducativa
            ::where('unidades_educativa_codigo', $premilitar->codigo_unidad_educativa)
            ->where('gestion', $premilitar->gestion)
            ->first();

        if ($centro_reclutamiento->cupos <= 0) {
            return $this->errorResponse(null, 'No se encuentran cupos disponibles para la unidad educativa');
        }


        return $this->successResponse($premilitar, 'El premilitar fue invitado');
    }
}
