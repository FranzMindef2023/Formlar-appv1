<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnidadesEspecialesController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $unidades = DB::table('unidades_militares as um')
        ->join('ubicacion_geografica as ug', 'um.id_provincia', '=', 'ug.idubigeo')
        ->select('um.id', 'ug.descubigeo as nombre', 'ug.nivel', 'um.id_ubicacion')
        ->where('um.id_ubicacion', $id)
        ->where('um.status', true) // solo activos
        ->get();

        return response()->json($unidades);
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
