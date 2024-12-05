<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request personalizado para la validación de bitácora de cambios
 * 
 * Esta clase maneja la validación de datos para el registro de cambios
 * en la bitácora del sistema, incluyendo información sobre el usuario,
 * la tabla afectada y la acción realizada.
 *
 * @package App\Http\Requests
 */
class BitacoracambioRequest extends FormRequest
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
     * Define las reglas de validación para los campos requeridos:
     * - usuario: nombre o identificador del usuario que realiza la acción
     * - tabla: nombre de la tabla afectada por el cambio
     * - accion: tipo de operación realizada (crear, actualizar, eliminar)
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'usuario' => 'required|string',
            'tabla' => 'required|string',
            'accion' => 'required|string',
        ];
    }
}
