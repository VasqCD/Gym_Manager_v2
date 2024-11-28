<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\RolRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Permiso;

class RolController extends Controller
{
    public function index(): View
    {
        $roles = Rol::with('permisos')->paginate(perPage: 10);
        $permisos = Permiso::with('roles')->get(); // Agregamos with('roles')

        return view('admin.roles-permisos.index', compact('roles', 'permisos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|unique:rols,nombre',
            'descripcion' => 'nullable'
        ]);

        $rol = Rol::create($request->all());

        // Asociar permisos si existen
        if ($request->has('permisos')) {
            $rol->permisos()->attach($request->permisos);
        }

        return Redirect::route('roles.index')
            ->with('success', 'Rol creado exitosamente');
    }

    public function update(Request $request, Rol $rol): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|unique:rols,nombre,'.$rol->id,
            'descripcion' => 'nullable'
        ]);

        $rol->update($request->all());
        
        // Sincronizar permisos
        $rol->permisos()->sync($request->permisos ?? []);

        return Redirect::route('roles.index')
            ->with('success', 'Rol actualizado exitosamente');
    }

    public function destroy(Rol $rol): RedirectResponse
    {
        try {
            // Eliminar relaciones y rol
            $rol->permisos()->detach();
            $rol->delete();

            return Redirect::route('roles.index')
                ->with('success', 'Rol eliminado exitosamente');
        } catch (\Exception $e) {
            return Redirect::route('roles.index')
                ->with('error', 'No se puede eliminar el rol porque está en uso');
        }
    }
}