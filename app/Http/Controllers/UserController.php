<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Models\Rolporpermiso;
use Illuminate\Http\RedirectResponse;


/**
 * Controlador para la gestión de usuarios
 * 
 * Esta clase maneja las operaciones CRUD relacionadas con los usuarios
 * del sistema y su asignación de roles
 * 
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * Muestra el listado de usuarios con sus roles asociados
     *
     * @return View Vista con el listado de usuarios y roles paginado
     */
    public function index()
    {
        $users = User::with('rol')->paginate();
        return view('user.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }

    /**
     * Muestra el formulario para crear un nuevo usuario
     *
     * @return View Vista con el formulario de creación
     */
    public function create()
    {
        $roles = Rol::all();
        return view('user.create', compact('roles'));
    }

   /**
     * Almacena un nuevo usuario en la base de datos
     *
     * @param Request $request Datos del formulario de creación
     * @return RedirectResponse Redirección con mensaje de éxito o error
     * @throws \Illuminate\Validation\ValidationException Si los datos no pasan la validación
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rol_id' => 'required|exists:rols,id'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Muestra los datos de un usuario
     *
     * @param string $id ID del usuario a mostrar
     * @return View Vista con los datos del usuario
     */
    public function show(string $id)
    {
        /** @var User $user */
    }

    /**
     * Muestra el formulario para editar un usuario
     *
     * @param User $user Usuario a editar
     * @return View Vista con el formulario de edición
     */
    public function edit(User $user)
    {
        $roles = Rol::all();
        return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Actualiza los datos de un usuario
     *
     * @param Request $request Datos del formulario de edición
     * @param User $user Usuario a actualizar
     * @return RedirectResponse Redirección con mensaje de éxito o error
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'rol_id' => 'required|exists:rols,id',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'rol_id' => $request->rol_id,
            'password' => $request->password ? Hash::make($request->password) : $user->password
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Elimina un usuario de la base de datos
     *
     * @param User $user Usuario a eliminar
     * @return RedirectResponse Redirección con mensaje de éxito
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}
