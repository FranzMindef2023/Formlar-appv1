<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAperturaRequest;
use App\Models\Apertura;
use Illuminate\Http\Request;

class AperturaController extends Controller
{
    private function successResponse($data, string $message = 'Success', int $status = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    private function errorResponse($error, string  $message = 'Something went wrong!', int $status = 400)
    {
        return response()->json([
            'success' => false,
            'error' => $error,
            'message' => $message,
        ], $status);
    }

    public function index()
    {
        $aperturas = Apertura::all();


        if ($aperturas->isEmpty()) {
            return $this->errorResponse(null, 'Aperturas list is empty', 404);
        }

        return $this->successResponse($aperturas, 'Aperturas list retrieved successfully');
    }

    public function store(StoreAperturaRequest $request)
    {
        try {
            $apertura = Apertura::create($request->validated());

            return $this->successResponse($apertura, 'Apertura created successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'An unexpected error occurred. Please try again.', 500);
        }
    }

    public function show(string $id)
    {
        try {
            $apertura = Apertura::findOrFail($id);

            return $this->successResponse($apertura, 'Apertura found.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse($e, 'Apertura not found', 404);
        }
    }
    public function show_actual_gestion()
    {
        try {

            $apertura = Apertura::firstWhere('gestion', date('Y'));


            return $this->successResponse($apertura, 'Apertura found.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse($e, 'Apertura not found', 404);
        }
    }

    public function show_by_gestion(string $year)
    {
        try {
            $apertura = Apertura::firstWhere('gestion', $year);

            if (!$apertura) {
                return $this->errorResponse(null, 'Apertura not found', 404);
            }

            return $this->successResponse($apertura, 'Apertura found.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse($e, 'Apertura not found', 404);
        }
    }


    public function update(string $id, Request $request)
    {
        try {
            $apertura = Apertura::findOrFail($id);
            $apertura->update($request->validated());

            return $this->successResponse($apertura, 'Apertura updated.', 201);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse($e, 'Apertura not found', 404);
        }
    }
}
