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
                        ->whereBetween('ubigeo', [1, 9]) // ubigeo del 1 al 9
                        ->where(function($query) {
                            $query->whereRaw("codigoubigeo ~ '^[1-9]$'"); // codigoubigeo "1" al "9"
                        })
                        ->select('idubigeo as id', 'descubigeo as nombre', 'siglaubigeo as sigla')
                        ->orderBy('ubigeo')
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
    public function getZonasGeograficas(){
        $zonas = DB::table('zonas_geograficas')
                    ->select('id', 'nombre')
                    ->orderBy('nombre')
                    ->get();

        return response()->json($zonas);
    }
    public function getDepartamentosZona($idZonaGeografica){
        try {
            $departamentos = DB::table('ubicacion_geografica')
                ->whereNull('id_padre')
                ->where('id_zona_geografica', $idZonaGeografica)
                ->select('idubigeo as id', 'descubigeo as nombre', 'siglaubigeo as sigla')
                ->orderBy('ubigeo')
                ->get();

            return response()->json($departamentos);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
