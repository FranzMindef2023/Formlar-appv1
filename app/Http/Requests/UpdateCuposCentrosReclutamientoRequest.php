<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCuposCentrosReclutamientoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'codigo_division' => 'required|integer|between:1,10',
            'cupo' => 'required|integer|min:1',
            'gestion' => 'required|integer|gte:' . date('Y'),
        ];
    }
    public function messages(): array
    {
        return [
            'codigo_division.required' => 'El campo codigo_division es obligatorio.',
            'codigo_division.integer' => 'El campo codigo_division debe ser un entero.',
            'codigo_division.between' => 'El campo codigo_division deber ser un numero dentro del rango del numero de divisiones que existen.',
            'cupo.required' => 'El campo cupo es obligatorio',
            'cupo.integer' => 'El campo cupo debe ser un entero',
            'cupo.min' => 'El campo cupo debe ser minimo 1 para poder crearse',
            'gestion.required' => 'El campo gestion es obligatorio',
            'gestion.integer' => 'El campo gestion debe ser un entero',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'error' => $validator->errors(),
            'message' => 'Something went wrong with the validation.',
        ], 422));
    }
}
