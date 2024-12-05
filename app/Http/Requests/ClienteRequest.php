<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request personalizado para la validación de datos de cliente
 * 
 * Esta clase maneja la validación de datos para la creación y 
 * actualización de clientes, incluyendo información personal
 * como nombre, DNI, teléfono y dirección.
 *
 * @package App\Http\Requests
 */
class ClienteRequest extends FormRequest
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
     * Define las reglas de validación para los campos del cliente:
     * - nombre_completo: nombre completo del cliente (requerido)
     * - dni: documento de identidad del cliente
     * - telefono: número de contacto
     * - direccion: dirección física del cliente
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'nombre_completo' => 'required|string',
			'dni' => 'string',
			'telefono' => 'string',
			'direccion' => 'string',
        ];
    }
}
