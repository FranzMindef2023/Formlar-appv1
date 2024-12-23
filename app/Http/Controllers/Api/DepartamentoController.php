<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::all();

        if ($departamentos->isEmpty()) {
            return response()->json([
                'message' => 'departamentos is empty',
            ]);
        }

        return response()->json([
            'data' => $departamentos,
            'message' => 'departamentos listed successfully',
        ]);
    }
}
