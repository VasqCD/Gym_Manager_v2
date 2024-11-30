<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\RolRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Permiso;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


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
    try {
        Log::info('Iniciando verificación de cambios', [
            'rol_id' => $rol->id,
            'datos_actuales' => $rol->toArray(),
            'datos_nuevos' => $request->all()
        ]);

        $cambios = [];
        
        // Verificar cambios en nombre
        if ($request->filled('nombre') && $request->nombre !== $rol->nombre) {
            // Solo validar nombre si cambió
            $request->validate([
                'nombre' => [
                    'required',
                    \Illuminate\Validation\Rule::unique('rols', 'nombre')->ignore($rol->id)
                ]
            ]);
            $cambios['nombre'] = $request->nombre;
        }

        // Verificar cambios en descripción
        if ($request->filled('descripcion') && $request->descripcion !== $rol->descripcion) {
            $cambios['descripcion'] = $request->descripcion;
        }

        DB::beginTransaction();

        // Solo actualizar si hay cambios en los datos básicos
        if (!empty($cambios)) {
            Log::info('Actualizando datos del rol', ['cambios' => $cambios]);
            $rol->update($cambios);
        }

        // Verificar cambios en permisos
        $permisosActuales = $rol->permisos->pluck('id')->toArray();
        $permisosNuevos = $request->input('permisos', []);
        
        // Convertir a enteros para comparación correcta
        $permisosNuevos = array_map('intval', $permisosNuevos);
        
        // Solo sincronizar si hay cambios en los permisos
        if (count(array_diff($permisosActuales, $permisosNuevos)) > 0 || 
            count(array_diff($permisosNuevos, $permisosActuales)) > 0) {
            
            Log::info('Actualizando permisos', [
                'anteriores' => $permisosActuales,
                'nuevos' => $permisosNuevos
            ]);
            
            $rol->permisos()->sync($permisosNuevos);
        }

        DB::commit();

        return redirect()->route('roles.index')
            ->with('success', 'Rol actualizado exitosamente');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error en actualización', [
            'rol_id' => $rol->id,
            'error' => $e->getMessage()
        ]);

        return redirect()->route('roles.index')
            ->with('error', 'Error al actualizar el rol: ' . $e->getMessage());
    }
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
