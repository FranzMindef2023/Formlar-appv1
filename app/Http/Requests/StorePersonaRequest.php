<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use App\Rules\CiValido;

class StorePersonaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('persona') ?? null;

        return [
            'nombres' => 'required|string|min:3|max:100',
            'primer_apellido' => 'nullable|string|min:3|max:100',
            'segundo_apellido' => 'nullable|string|min:3|max:100',
            'ci' => [
                'required',
                'string',
                'max:20',
                Rule::unique('personas', 'ci')->ignore($id, 'id'),
                new CiValido(), // Aquí se aplica la regla personalizada
            ],
            'fecha_nacimiento' => 'required|date|before:-17 years|after:-24 years',
            'status' => 'required|boolean',

            'id_departamento' => 'required|integer|exists:ubicacion_geografica,idubigeo',
            'id_lugar_nacimiento' => 'required|integer|exists:ubicacion_geografica,idubigeo',
            'id_centro_reclutamiento' => 'required|integer|exists:unidades_especiales,id',
            'g-recaptcha-response' => ['required', new \App\Rules\GoogleRecaptcha],
        ];
    }

    public function messages()
    {
        return [
            'nombres.required' => 'El nombre es obligatorio.',
            'nombres.min' => 'El nombre debe tener al menos 3 caracteres.',
            'nombres.max' => 'El nombre no debe exceder los 100 caracteres.',

            'primer_apellido.min' => 'El apellido paterno debe tener al menos 3 caracteres.',
            'primer_apellido.max' => 'El apellido paterno no debe exceder los 100 caracteres.',
            'segundo_apellido.min' => 'El apellido materno debe tener al menos 3 caracteres.',
            'segundo_apellido.max' => 'El apellido materno no debe exceder los 100 caracteres.',

            'ci.required' => 'El CI es obligatorio.',
            'ci.unique' => 'Este CI ya está en uso.',
            'ci.max' => 'El CI no debe exceder los 20 caracteres.',

            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.date' => 'Debe ser una fecha válida.',
            'fecha_nacimiento.before' => 'La persona no cumple con la edad requerida.',
            'fecha_nacimiento.after' => 'La persona no cumple con la edad requerida.',

            'status.required' => 'El estado es obligatorio.',
            'status.boolean' => 'El estado debe ser verdadero o falso.',

            'id_departamento.required' => 'El departamento es obligatorio.',
            'id_departamento.exists' => 'El departamento seleccionado no existe.',

            'id_lugar_nacimiento.required' => 'El lugar de nacimiento es obligatorio.',
            'id_lugar_nacimiento.exists' => 'El lugar de nacimiento no existe.',

            'id_centro_reclutamiento.required' => 'El centro de reclutamiento es obligatorio.',
            'id_centro_reclutamiento.exists' => 'El centro de reclutamiento seleccionado no existe.',

            'g-recaptcha-response.required' => 'Por favor, verifica que no eres un robot.',
            'g-recaptcha-response' => 'La verificación de reCAPTCHA ha fallado. Intenta nuevamente.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Datos de entrada no válidos.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
