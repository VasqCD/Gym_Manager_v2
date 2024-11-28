<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PermisoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Rol;
class PermisoController extends Controller
{
    public function index(Request $request): View
{
    // Paginar resultados y cargar relaciones
    $permisos = Permiso::with('roles')->paginate(10);
    $roles = Rol::with('permisos')->paginate(10);

    return view('admin.roles-permisos.index', compact('roles', 'permisos'));
}

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
