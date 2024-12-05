<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request personalizado para la validación de permisos
 * 
 * Esta clase maneja la validación de datos para la creación y 
 * actualización de permisos en el sistema, incluyendo el nombre
 * del permiso y su descripción.
 *
 * @package App\Http\Requests
 */
class PermisoRequest extends FormRequest
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
     * Define las reglas de validación para los campos del permiso:
     * - nombre: nombre del permiso (requerido)
     * - descripcion: descripción detallada del permiso
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'nombre' => 'required|string',
			'descripcion' => 'string',
        ];
    }
}
