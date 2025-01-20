<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreCuposCentrosReclutamientoRequest extends FormRequest
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
            'id_centros_reclutamiento' => [
                'required',
                'integer',
                'min:1',
                'exists:centros_reclutamientos,id',
                function ($attribute, $value, $fail) {
                    try {
                        if (\App\Models\CuposCentrosReclutamiento::where('id_centros_reclutamiento', $value)
                            ->where('gestion', $this->input('gestion'))
                            ->first()
                        ) {
                            $fail('El centro de reclutamiento ya tiene cupos asignados para esta gestion.');
                        }
                    } catch (\Exception $e) {
                        $fail('Error al validar el campo ' . $attribute . ': ' . $e->getMessage());
                    }
                }
            ],

            'codigo_division' => 'required|integer|between:1,10|exists:divisions,codigo',
            'cupo' => 'required|integer|min:1', // !EMERGENCY cambiar a min:1
            'gestion' => 'required|integer|exists:aperturas,gestion|gte:' . date('Y'),
        ];
    }
    public function messages()
    {
        return [
            'id_centros_reclutamiento.required' => 'El campo id_centros_reclutamiento es obligatorio.',
            'id_centros_reclutamiento.integer' => 'El campo id_centros_reclutamiento debe ser un entero.',
            'id_centros_reclutamiento.min' => 'El campo id_centros_reclutamiento comienza en 1.',
            'id_centros_reclutamiento.exists' => 'El campo id_centros_reclutamiento debe ser un id valido y existente.',
            'codigo_division.required' => 'El campo codigo_division es obligatorio.',
            'codigo_division.integer' => 'El campo codigo_division debe ser un entero.',
            'codigo_division.between' => 'El campo codigo_division deber ser un numero dentro del rango del numero de divisiones que existen.',
            'codigo_division.exists' => 'El campo codigo_division debe debe ser un codigo valido y existente',
            'cupo.required' => 'El campo cupo es obligatorio',
            'cupo.integer' => 'El campo cupo debe ser un entero',
            'cupo.min' => 'El campo cupo debe ser minimo 1 para poder crearse',
            'gestion.required' => 'El campo gestion es obligatorio',
            'gestion.integer' => 'El campo gestion debe ser un entero',
            'gestion.exists' => 'El campo gestion debe ser valido y existente',
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
