<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request personalizado para la validación de pagos
 * 
 * Esta clase maneja la validación de datos para la creación y 
 * actualización de pagos, incluyendo información como el cliente,
 * la fecha del pago y el monto total.
 *
 * @package App\Http\Requests
 */
class PagoRequest extends FormRequest
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
     * Define las reglas de validación para los campos del pago:
     * - cliente_id: identificador del cliente (requerido)
     * - fecha_pago: fecha en que se realizó el pago (requerido)
     * - total: monto total del pago (requerido)
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'cliente_id' => 'required',
			'fecha_pago' => 'required',
			'total' => 'required',
        ];
    }
}
