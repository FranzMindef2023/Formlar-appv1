<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UbicacionGeograficaController extends Controller
{
    public function getDepartamentos(){
        $departamentos = DB::table('ubicacion_geografica')
            ->whereNull('id_padre')
            ->select('idubigeo as id', 'descubigeo as nombre','siglaubigeo as sigla')
            ->orderBy('idubigeo')
            ->get();

        return response()->json($departamentos);
    }
    public function getMunicipios($idDepartamento){
        $municipios = DB::table('ubicacion_geografica')
            ->where('id_padre', $idDepartamento)
            ->select('idubigeo as id', 'descubigeo as nombre')
            ->orderBy('descubigeo')
            ->get();

        return response()->json($municipios);
    }

}
