<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ConfirmsPasswords;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | Este controlador es responsable de manejar las confirmaciones de contraseña y
    | utiliza un simple trait para incluir el comportamiento. Eres libre de explorar
    | este trait y anular cualquier función que requiera personalización.
    |
    */

    use ConfirmsPasswords;

    /**
     * Donde redirigir a los usuarios cuando la url prevista falla.
     * 
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Crear una nueva instancia de controlador. en este caso, el middleware de autenticación.
     * 
     * @return void
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}
