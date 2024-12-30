<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCuposUnidadesEducativasRequest extends FormRequest
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
            'centros_reclutamiento_id' => 'required|integer|min:1|exists:centros_reclutamientos,id',
            'cupos' => 'required|integer|min:0',
            'porcentaje_hombres' => 'required|numeric|min:0|max:100',
            'porcentaje_mujeres' => 'required|numeric|min:0|max:100',
            'aceptado_hombres' => 'nullable|integer|min:0',
            'aceptado_mujeres' => 'nullable|integer|min:0',
            'gestion' => 'required|integer|exists:aperturas,gestion|gte:' . date('Y'),
        ];
    }

    public function messages(): array
    {
        return [
            'centros_reclutamiento_id.required' => 'El campo centros de reclutamiento es obligatorio.',
            'centros_reclutamiento_id.integer' => 'El campo centros de reclutamiento debe ser un numero entero.',
            'centros_reclutamiento_id.exists' => 'El centro de reclutamiento seleccionado no existe.',
            'unidades_educativa_codigo.required' => 'El campo codigo de unidad educativa es obligatorio.',
            'unidades_educativa_codigo.integer' => 'El codigo de unidad educativa debe ser un numero entero.',
            'unidades_educativa_codigo.exists' => 'El codigo de unidad educativa seleccionada no existe.',
            'cupos.required' => 'El campo cupos es obligatorio.',
            'cupos.integer' => 'El campo cupos debe ser un numero entero.',
            'cupos.min' => 'El campo cupos debe ser un valor mayor o igual a 0.',
            'porcentaje_hombres.required' => 'El porcentaje de hombres es obligatorio.',
            'porcentaje_hombres.numeric' => 'El porcentaje de hombres debe ser un numero.',
            'porcentaje_hombres.min' => 'El porcentaje de hombres no puede ser menor a 0.',
            'porcentaje_hombres.max' => 'El porcentaje de hombres no puede exceder 100.',
            'porcentaje_mujeres.required' => 'El porcentaje de mujeres es obligatorio.',
            'porcentaje_mujeres.numeric' => 'El porcentaje de mujeres debe ser un numero.',
            'porcentaje_mujeres.min' => 'El porcentaje de mujeres no puede ser menor a 0.',
            'porcentaje_mujeres.max' => 'El porcentaje de mujeres no puede exceder 100.',
            'aceptado_hombres.integer' => 'El campo aceptado hombres debe ser un numero entero.',
            'aceptado_mujeres.integer' => 'El campo aceptado mujeres debe ser un numero entero.',
            'gestion.required' => 'El campo gestion es obligatorio.',
            'gestion.integer' => 'El campo gestion debe ser un número entero.',
            'gestion.min' => 'La gestion debe ser igual o mayor que el año actual.',
            'gestion.exists' => 'La gestion debe ser valida o existente',
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
