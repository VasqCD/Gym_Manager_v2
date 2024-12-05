<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * Request personalizado para la validación de detalles de pago
 * 
 * Esta clase maneja la validación de datos para los detalles de pago,
 * incluyendo la información sobre el pago principal, la membresía asociada,
 * cantidad y subtotal de cada detalle.
 *
 * @package App\Http\Requests
 */
class PagodetallRequest extends FormRequest
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
     * Define las reglas de validación para los campos del detalle de pago:
     * - pago_id: identificador del pago principal (requerido)
     * - membresia_id: identificador de la membresía (requerido)
     * - cantidad: número de items en el detalle (requerido)
     * - subtotal: monto parcial del detalle (requerido)
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'pago_id' => 'required',
			'membresia_id' => 'required',
			'cantidad' => 'required',
			'subtotal' => 'required',
        ];
    }
}
