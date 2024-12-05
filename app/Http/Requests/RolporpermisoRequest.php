<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request personalizado para la validación de asignación de permisos a roles
 * 
 * Esta clase maneja la validación de datos para la asignación y 
 * actualización de permisos a roles específicos en el sistema,
 * verificando que existan tanto el rol como el permiso.
 *
 * @package App\Http\Requests
 */
class RolporpermisoRequest extends FormRequest
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
     * Define las reglas de validación para los campos de la relación:
     * - rol_id: identificador del rol (requerido)
     * - permiso_id: identificador del permiso (requerido)
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'rol_id' => 'required',
			'permiso_id' => 'required',
        ];
    }
}
