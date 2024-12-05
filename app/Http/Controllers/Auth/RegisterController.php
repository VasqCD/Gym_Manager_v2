<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Controlador para el registro de nuevos usuarios
 * 
 * Esta clase maneja todo el proceso de registro de nuevos usuarios,
 * incluyendo la validación de datos, creación de cuentas y 
 * asignación de roles iniciales. Utiliza el trait RegistersUsers
 * de Laravel para la funcionalidad base de registro.
 *
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Controlador de Registro
    |--------------------------------------------------------------------------
    |
    | Este controlador maneja el registro de nuevos usuarios así como su
    | validación y creación. Por defecto, este controlador usa un trait
    | para proporcionar esta funcionalidad sin requerir código adicional.
    |
    */

    use RegistersUsers;

    /**
     * Ruta de redirección después del registro exitoso
     *
     * Esta propiedad define la ruta a la que será redirigido el usuario
     * después de completar el proceso de registro satisfactoriamente.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Crea una nueva instancia del controlador
     *
     * El constructor aplica el middleware 'guest' para asegurar que
     * solo los usuarios no autenticados puedan acceder al registro.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Obtiene un validador para la solicitud de registro
     *
     * @param  array  $data Datos a validar del formulario de registro
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Crea una nueva instancia de usuario después de un registro válido
     *
     * @param  array  $data Datos validados del usuario
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Obtener el rol de Empleado
        $rolEmpleado = Rol::where('nombre', 'Empleado')->first();

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'rol_id' => $rolEmpleado->id, // Asignar rol automáticamente
        ]);
    }
}
