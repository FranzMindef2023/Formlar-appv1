<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAperturaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gestion' => [
                'required',
                'integer',
                'unique:aperturas,gestion',
                function ($attribute, $value, $fail) {
                    if ($value < date('Y')) {
                        $fail('El campo ' . $attribute . ' debe ser igual o mayor que la gestion actual');
                    }
                },

            ],
            'cantidad' => 'required|integer|min:1',
            'fecha_limite' => 'required|date|after:today',
            'fecha_apertura' => 'required|date|before_or_equal:today',
            'edad_min' => 'required|integer|between:0,40',
            'edad_max' => 'required|integer|between:0,40|gte:edad_min',
            'cite_junta' => 'nullable|string|max:65535',
            'firma_mae' => 'nullable|string|max:65535',
        ];
    }

    public function messages(): array
    {
        return [
            'gestion.required' => 'El campo gestion es obligatorio.',
            'gestion.integer' => 'El campo gestion debe ser un número entero.',
            'gestion.unique' => 'El valor ingresado de gestion ya existe',
            'cantidad.required' => 'El campo cantidad es obligatorio.',
            'cantidad.integer' => 'El campo cantidad debe ser un numero entero.',
            'cantidad.min' => 'La cantidad debe ser al menos 1.',
            'cantidad.max' => 'La cantidad no puede ser mayor a 10000.',
            'fecha_limite.required' => 'El campo fecha limite de edad es obligatorio.',
            'fecha_limite.date' => 'El campo fecha limite debe ser una fecha valida.',
            'fecha_limite.after' => 'La fecha limite de edad debe ser posterior a hoy.',
            'fecha_apertura.required' => 'El campo fecha de apertura es obligatorio.',
            'fecha_apertura.date' => 'El campo fecha de apertura debe ser una fecha valida.',
            'fecha_apertura.before_or_equal' => 'La fecha de apertura debe ser igual o anterior a hoy.',
            'edad_min.required' => 'El campo edad minima es obligatorio.',
            'edad_min.integer' => 'El campo edad minima debe ser un numero entero.',
            'edad_min.min' => 'La edad minima debe ser al menos 0.',
            'edad_min.max' => 'La edad minima no puede ser mayor a 150.',
            'edad_max.required' => 'El campo edad maxima es obligatorio.',
            'edad_max.integer' => 'El campo edad maxima debe ser un número entero.',
            'edad_max.min' => 'La edad maxima debe ser al menos 0.',
            'edad_max.max' => 'La edad maxima no puede ser mayor a 150.',
            'edad_max.gte' => 'La edad maxima debe ser mayor o igual a la edad minima.',
            'cite_junta.string' => 'El campo cite junta debe ser un texto.',
            'cite_junta.max' => 'El campo cite junta no puede exceder los 65535 caracteres.',
            'firma_mae.string' => 'El campo firma MAE debe ser un texto.',
            'firma_mae.max' => 'El campo firma MAE no puede exceder los 65535 caracteres.',
        ];
    }
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'error' => $validator->errors(),
            'message' => 'la validacion fallo',
        ], 422));
    }
}
