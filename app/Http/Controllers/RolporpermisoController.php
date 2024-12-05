<?php

namespace App\Http\Controllers;

use App\Models\Rolporpermiso;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\RolporpermisoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Rol;
use App\Models\Permiso;
use Illuminate\Support\Facades\Log;

/**
 * Controlador para la gestión de los roles por permisos de usuario en la aplicación
 * 
 * Esta clase maneja las operaciones CRUD y lógica de negocio
 * relacionada con los roles por permisos de usuario
 * 
 * @package App\Http\Controllers
 */
class RolporpermisoController extends Controller
{

    /**
     * La función index obtiene y pagina los datos de Rolporpermiso con manejo de errores y logging.
     * 
     * @param Request request El parámetro `Request` en la función `index` es una instancia
     * de la clase `Illuminate\Http\Request`. Representa la solicitud HTTP que se está realizando a la
     * aplicación y contiene información como datos de entrada, encabezados, cookies y más.
     * 
     * @return View La función `index` devuelve una vista llamada 'rolporpermiso.index' con los datos
     * de la variable `rolporpermisos` pasados como compact. Además, calcula el desplazamiento de la paginación
     * basado en el número de página actual de la entrada de la solicitud. Si ocurre una excepción durante
     * el proceso, registra el mensaje de error y redirige a la ruta 'rolporpermiso.index' con un
     * mensaje de error
     */
    public function index(Request $request): View
    {
        try {
            $rolporpermisos = Rolporpermiso::with(['rol', 'permiso'])->paginate();

            return view('rolporpermiso.index', compact('rolporpermisos'))
                ->with('i', ($request->input('page', 1) - 1) * $rolporpermisos->perPage());
        } catch (\Exception $e) {
            Log::error('Error en rolporpermisos.index: ' . $e->getMessage());
            return redirect()->route('rolporpermiso.index')
                ->with('error', 'Error al cargar los datos');
        }
    }

    
    /**
     * La función `create` recupera todos los roles y permisos y devuelve una vista con los datos.
     * 
     * @return View Se devuelve una vista llamada 'rolporpermiso.create' con las variables `roles` y
     * `permisos` pasadas a ella utilizando la función compact.
     */
    public function create(): View
    {
        $roles = Rol::all();
        $permisos = Permiso::all();

        return view('rolporpermiso.create', compact('roles', 'permisos'));
    }

    /**
     * La función `store` almacena un nuevo recurso en la base de datos.
     * 
     * @param Request request El parámetro `Request` en la función `store` es una instancia
     * de la clase `Illuminate\Http\Request`. Representa la solicitud HTTP que se está realizando a la
     * aplicación y contiene información como datos de entrada, encabezados, cookies y más.
     * 
     * @return RedirectResponse La función `store` redirige a la ruta 'rolporpermisos.index' con un mensaje
     * de éxito si el permiso se asigna correctamente al rol. Si el permiso ya está asignado al rol, se
     * redirige a la ruta anterior con un mensaje de error.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'rol_id' => 'required|exists:rols,id',
            'permiso_id' => 'required|exists:permisos,id',
        ]);

        // Verificar si el permiso ya está asignado al rol
        $exists = Rolporpermiso::where('rol_id', $request->rol_id)
            ->where('permiso_id', $request->permiso_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['permiso_id' => 'El permiso ya está asignado a este rol.']);
        }

        Rolporpermiso::create($request->all());

        return redirect()->route('rolporpermisos.index')
            ->with('success', 'Permiso asignado al rol correctamente.');
    }

    
    /**
     * La función `show` recupera un modelo Rolporpermiso específico por su ID y luego devuelve una vista
     * con los datos recuperados.
     * 
     * @param int id El parámetro `id` en la función `show` se utiliza para recuperar un modelo específico
     * `Rolporpermiso` de la base de datos en función del ID proporcionado. Este ID se utiliza típicamente para
     * recuperar el registro correspondiente de la tabla de la base de datos y luego pasar esos datos a la vista para
     * mostrar los detalles de ese registro.
     * 
     * @return View Se devuelve una vista de la función `show`. La vista que se devuelve es
     * 'rolporpermiso.show' y se pasa a ella los datos de la variable utilizando la función
     * 
     * The function "show" retrieves a specific Rolporpermiso model by its ID and then returns a view
     * with the retrieved data.
     */
    public function show($id): View
    {
        $rolporpermiso = Rolporpermiso::find($id);

        return view('rolporpermiso.show', compact('rolporpermiso'));
    }

    /**
     * La función `edit` recupera un modelo Rolporpermiso específico por su ID y luego devuelve una vista
     * con los datos recuperados.
     * 
     * @param int id El parámetro `id` en la función `edit` se utiliza para recuperar un modelo específico
     * `Rolporpermiso` de la base de datos en función del ID proporcionado. Este ID se utiliza típicamente para
     * recuperar el registro correspondiente de la tabla de la base de datos y luego pasar esos datos a la vista para
     * mostrar los detalles de ese registro.
     * 
     * @return View Se devuelve una vista de la función `edit`. La vista que se devuelve es
     * 'rolporpermiso.edit' y se pasa a ella los datos de la variable utilizando la función
     */
    public function edit($id): View
    {
        $rolporpermiso = Rolporpermiso::findOrFail($id);
        $roles = Rol::all();
        $permisos = Permiso::all();

        return view('rolporpermiso.edit', compact('rolporpermiso', 'roles', 'permisos'));
    }

    /**
     * La función `update` actualiza los datos de un recurso en la base de datos.
     * 
     * @param Request request El parámetro `Request` en la función `update` es una instancia
     * de la clase `Illuminate\Http\Request`. Representa la solicitud HTTP que se está realizando a la
     * aplicación y contiene información como datos de entrada, encabezados, cookies y más.
     * 
     * @param int id El parámetro `id` en la función `update` se utiliza para recuperar un modelo específico
     * `Rolporpermiso` de la base de datos en función del ID proporcionado. Este ID se utiliza típicamente para
     * recuperar el registro correspondiente de la tabla de la base de datos y luego actualizar esos datos con los
     * datos proporcionados en la solicitud.
     * 
     * @return RedirectResponse La función `update` redirige a la ruta 'rolporpermisos.index' con un mensaje
     * de éxito si el rol por permiso se actualiza correctamente. Si ocurre un error durante el proceso, se
     * redirige a la ruta anterior con un mensaje de error.
     */
    public function update(RolporpermisoRequest $request, Rolporpermiso $rolporpermiso): RedirectResponse
    {
        $rolporpermiso->update($request->validated());

        return Redirect::route('rolporpermisos.index')
            ->with('success', 'Rolporpermiso updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Rolporpermiso::find($id)->delete();

        return Redirect::route('rolporpermisos.index')
            ->with('success', 'Rolporpermiso deleted successfully');
    }
}
