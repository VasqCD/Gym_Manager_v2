<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

/**
 * Controlador para el restablecimiento de contraseñas
 * 
 * Esta clase maneja las solicitudes de restablecimiento de contraseña,
 * incluyendo la validación del token, actualización de la contraseña
 * y redirección del usuario. Utiliza el trait ResetsPasswords de
 * Laravel para proporcionar la funcionalidad principal.
 *
 * @package App\Http\Controllers\Auth
 */
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Controlador de Restablecimiento de Contraseña
    |--------------------------------------------------------------------------
    |
    | Este controlador es responsable de manejar las solicitudes de
    | restablecimiento de contraseña y utiliza un trait simple para
    | incluir este comportamiento. Puede explorar este trait y 
    | sobrescribir cualquier método que desee modificar.
    |
    */

    use ResetsPasswords;

    /**
     * Ruta de redirección después del restablecimiento de contraseña
     *
     * Esta propiedad define la ruta a la que será redirigido el usuario
     * después de restablecer exitosamente su contraseña.
     *
     * @var string
     */
    protected $redirectTo = '/home';
}
