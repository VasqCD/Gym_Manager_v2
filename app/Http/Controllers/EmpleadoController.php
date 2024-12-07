<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\EmpleadoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

/**
 * Controlador para la gestión de empleados
 * 
 * Esta clase maneja las operaciones CRUD y lógica de negocio
 * relacionada con los empleados del gimnasio
 * 
 * @package App\Http\Controllers
 */
class EmpleadoController extends Controller
{
    /**
     * Muestra el listado de empleados
     *
     * @param Request $request Objeto con los datos de la petición HTTP
     * @return View Vista con el listado de empleados paginado
     */
    public function index(Request $request): View
    {
        $empleados = Empleado::paginate();
        return view('empleado.index', compact('empleados'))
            ->with('i', ($request->input('page', 1) - 1) * $empleados->perPage());
    }

     /**
     * Muestra el formulario para crear un nuevo empleado
     *
     * @return View Vista con el formulario de creación
     */
    public function create(): View
    {
        $empleado = new Empleado();
        return view('empleado.create', compact('empleado'));
    }

    /**
     * Almacena un nuevo empleado en la base de datos
     *
     * @param Request $request Objeto con los datos de la petición HTTP
     * @return RedirectResponse Redirección con mensaje de éxito o error
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:100',
            'dni' => 'required|string|max:15|unique:empleados',
            'telefono' => 'required|string|max:15',
            'direccion' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:100|unique:empleados',
            'cargo' => 'required|string|max:50',
            'salario' => 'required|numeric|min:0',
            'fecha_contratacion' => 'required|date',
            'horario_trabajo' => 'nullable|string|max:100',
            'tipo_contrato' => 'required|in:Tiempo Completo,Medio Tiempo,Por Horas',
            'numero_seguro_social' => 'nullable|string|max:20',
            'contacto_emergencia' => 'nullable|string|max:100',
            'telefono_emergencia' => 'nullable|string|max:15'
        ]);

        Empleado::create($request->all());

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado creado exitosamente.');
    }

    /**
     * Muestra los detalles de un empleado
     *
     * @param int $id Identificador del empleado a mostrar
     * @return View Vista con los detalles del empleado
     */
    public function show($id): View
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleado.show', compact('empleado'));
    }

    /**
     * Muestra el formulario para editar un empleado
     *
     * @param int $id Identificador del empleado a editar
     * @return View Vista con el formulario de edición
     */
    public function edit($id): View
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleado.edit', compact('empleado'));
    }

    /**
     * Actualiza los datos de un empleado en la base de datos
     *
     * @param Request $request Objeto con los datos de la petición HTTP
     * @param int $id Identificador único del empleado
     * @return RedirectResponse Redirección con mensaje de éxito o error
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:100',
            'dni' => 'required|string|max:15|unique:empleados,dni,'.$id,
            'telefono' => 'required|string|max:15',
            'direccion' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:100|unique:empleados,email,'.$id,
            'cargo' => 'required|string|max:50',
            'salario' => 'required|numeric|min:0',
            'fecha_contratacion' => 'required|date',
            'horario_trabajo' => 'nullable|string|max:100',
            'tipo_contrato' => 'required|in:Tiempo Completo,Medio Tiempo,Por Horas',
            'numero_seguro_social' => 'nullable|string|max:20',
            'contacto_emergencia' => 'nullable|string|max:100',
            'telefono_emergencia' => 'nullable|string|max:15',
            'activo' => 'required|boolean'
        ]);

        $empleado = Empleado::findOrFail($id);
        $empleado->update($request->all());

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado actualizado exitosamente.');
    }

    /**
     * Elimina un empleado de la base de datos
     *
     * @param int $id Identificador único del empleado
     * @return RedirectResponse Redirección con mensaje de éxito o error
     */
    public function destroy($id): RedirectResponse
    {
        Empleado::findOrFail($id)->delete();
        return redirect()->route('empleados.index')
            ->with('success', 'Empleado eliminado exitosamente.');
    }
}