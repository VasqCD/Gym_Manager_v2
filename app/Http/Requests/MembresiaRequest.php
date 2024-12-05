<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request personalizado para la validación de datos de membresías
 * 
 * Esta clase maneja la validación de datos para la creación y 
 * actualización de membresías, incluyendo información como
 * tipo, descripción, costo y duración.
 *
 * @package App\Http\Requests
 */
class MembresiaRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud
     *
     * Por defecto permite todas las solicitudes. Si se requiere una
     * validación más específica, sobrescribir este método.
     *
     * @return bool Siempre retorna true
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtiene las reglas de validación aplicables a la solicitud
     *
     * Define las reglas de validación para los campos de la membresía:
     * - tipo: tipo de membresía (requerido)
     * - descripcion: detalles adicionales de la membresía
     * - costo: precio de la membresía (requerido)
     * - duracion: período de validez de la membresía (requerido)
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'tipo' => 'required|string',
			'descripcion' => 'string',
			'costo' => 'required',
			'duracion' => 'required',
        ];
    }
}
