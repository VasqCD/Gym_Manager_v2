<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request personalizado para la validación de datos de empleados
 * 
 * Esta clase maneja la validación de datos para la creación y 
 * actualización de empleados, incluyendo información como
 * nombre completo y cargo.
 *
 * @package App\Http\Requests
 */
class EmpleadoRequest extends FormRequest
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
     * Define las reglas de validación para los campos del empleado:
     * - nombre_completo: nombre completo del empleado (requerido)
     * - cargo: puesto o posición del empleado
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'nombre_completo' => 'required|string',
			'cargo' => 'string',
        ];
    }
}
