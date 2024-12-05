<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

/**
 * Controlador que maneja la autenticación de usuarios
 * 
 * Esta clase gestiona todo el proceso de inicio de sesión de usuarios,
 * incluyendo la validación de credenciales y redirección post-login.
 * Utiliza el trait AuthenticatesUsers de Laravel para proporcionar
 * la funcionalidad principal de autenticación.
 *
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | Este controlador maneja la autenticación de usuarios para la aplicación y
    | su redirección a la pantalla principal. El controlador utiliza un trait
    | para proporcionar convenientemente esta funcionalidad a la aplicación.
    |
    */

    use AuthenticatesUsers;

    
    /**
     * Ruta de redirección después del inicio de sesión exitoso
     *
     * Esta propiedad define la ruta a la que será redirigido el usuario
     * después de iniciar sesión correctamente en la aplicación.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    

    /**
     * Crea una nueva instancia del controlador
     *
     * El constructor aplica los middlewares necesarios para controlar el acceso:
     * - El middleware 'guest' se aplica a todos los métodos excepto 'logout'
     * - Esto asegura que solo los usuarios no autenticados puedan acceder
     *   a las rutas de login
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
