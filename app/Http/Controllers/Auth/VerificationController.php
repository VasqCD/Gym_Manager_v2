<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;

/**
 * Controlador para la verificación de correo electrónico
 * 
 * Esta clase maneja el proceso de verificación de correo electrónico
 * para usuarios recién registrados. Permite verificar las cuentas y 
 * reenviar correos de verificación cuando sea necesario. Utiliza el
 * trait VerifiesEmails de Laravel para la funcionalidad principal.
 *
 * @package App\Http\Controllers\Auth
 */
class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Controlador de Verificación de Email
    |--------------------------------------------------------------------------
    |
    | Este controlador es responsable de manejar la verificación de email para
    | cualquier usuario que se haya registrado recientemente en la aplicación.
    | Los emails también pueden ser reenviados si el usuario no recibió el
    | mensaje original.
    |
    */

    use VerifiesEmails;

    /**
     * Ruta de redirección después de la verificación
     *
     * Esta propiedad define la ruta a la que será redirigido el usuario
     * después de verificar exitosamente su dirección de correo.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Crea una nueva instancia del controlador
     *
     * El constructor aplica tres middlewares:
     * - 'auth': Requiere que el usuario esté autenticado
     * - 'signed': Verifica que la URL de verificación sea válida
     * - 'throttle': Limita los intentos de verificación y reenvío
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
