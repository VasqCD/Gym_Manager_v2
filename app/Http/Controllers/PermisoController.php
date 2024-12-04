<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PermisoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Rol;
/**
 * Controlador para la gestión de permisos del sistema
 * 
 * Esta clase maneja las operaciones relacionadas con los permisos
 * y su asignación a roles dentro del sistema de autorización
 * 
 * @package App\Http\Controllers
 */
class PermisoController extends Controller
{
    /**
     * Muestra el listado de permisos y roles
     *
     * Obtiene y muestra los permisos con sus roles asociados
     * y los roles con sus permisos en una vista paginada
     *
     * @param Request $request Objeto con los datos de la petición HTTP
     * @return View Vista con el listado de permisos y roles
     */
    public function index(Request $request): View
{
    // Paginar resultados y cargar relaciones
    $permisos = Permiso::with('roles')->paginate(10);
    $roles = Rol::with('permisos')->paginate(10);

    return view('admin.roles-permisos.index', compact('roles', 'permisos'));
}

    /**
     * Almacena un nuevo permiso en la base de datos
     *
     * Valida los datos de la petición y crea un nuevo permiso
     * en la base de datos, luego redirige a la vista de roles
     * con un mensaje de éxito o error
     *
     * @param PermisoRequest $request Objeto con los datos de la petición HTTP
     * @return RedirectResponse Redirección a la vista de roles
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|unique:permisos,nombre',
            'descripcion' => 'nullable'
        ]);

        try {
            Permiso::create($request->all());
            return Redirect::route('roles.index')
                ->with('success', 'Permiso creado exitosamente');
        } catch (\Exception $e) {
            return Redirect::route('roles.index')
                ->with('error', 'Error al crear el permiso');
        }
    }

    /**
     * Actualiza un permiso en la base de datos
     *
     * Valida los datos de la petición y actualiza un permiso
     * en la base de datos, luego redirige a la vista de roles
     * con un mensaje de éxito o error
     *
     * @param PermisoRequest $request Objeto con los datos de la petición HTTP
     * @param Permiso $permiso Objeto del permiso a actualizar
     * @return RedirectResponse Redirección a la vista de roles
     */
    public function update(Request $request, Permiso $permiso): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|unique:permisos,nombre,' . $permiso->id,
            'descripcion' => 'nullable'
        ]);

        try {
            $permiso->update($request->all());
            return Redirect::route('roles.index')
                ->with('success', 'Permiso actualizado exitosamente');
        } catch (\Exception $e) {
            return Redirect::route('roles.index')
                ->with('error', 'Error al actualizar el permiso');
        }
    }

    /**
     * Elimina un permiso de la base de datos
     *
     * Elimina un permiso de la base de datos y redirige a la vista
     * de roles con un mensaje de éxito o error
     *
     * @param Permiso $permiso Objeto del permiso a eliminar
     * @return RedirectResponse Redirección a la vista de roles
     */
    public function destroy(Permiso $permiso): RedirectResponse
    {
        try {
            $permiso->roles()->detach();
            $permiso->delete();
            return Redirect::route('roles.index')
                ->with('success', 'Permiso eliminado exitosamente');
        } catch (\Exception $e) {
            return Redirect::route('roles.index')
                ->with('error', 'No se puede eliminar el permiso porque está en uso');
        }
    }
}
