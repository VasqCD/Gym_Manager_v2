<?php

namespace App\Http\Controllers;

use App\Models\Membresia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\MembresiaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

/**
 * Controlador para la gestión de membresías
 * 
 * Esta clase maneja todas las operaciones relacionadas con las membresías
 * del gimnasio, incluyendo su creación, modificación y consulta
 * 
 * @package App\Http\Controllers
 */
class MembresiaController extends Controller
{
    /**
     * Muestra el listado de membresías disponibles
     *
     * @param Request $request Objeto con los datos de la petición HTTP
     * @return View Vista con el listado de membresías paginado
     */
    public function index(Request $request): View
    {
        $membresias = Membresia::paginate();

        return view('membresia.index', compact('membresias'))
            ->with('i', ($request->input('page', 1) - 1) * $membresias->perPage());
    }

    /**
     * Muestra el formulario para crear una nueva membresía
     *
     * @return View Vista con el formulario de creación
     */
    public function create(): View
    {
        $membresia = new Membresia();
        return view('membresia.create', compact('membresia'));
    }

    /**
     * Almacena una nueva membresía en la base de datos
     *
     * @param Request $request Datos del formulario de creación
     * @return RedirectResponse Redirección con mensaje de éxito o error
     * @throws \Illuminate\Validation\ValidationException Si los datos no pasan la validación
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'tipo' => 'required|string|max:255|unique:membresias',
            'descripcion' => 'required|string',
            'costo' => 'required|numeric|min:0',
            'duracion' => 'required|integer|min:1'
        ]);

        try {
            Membresia::create($request->all());
            return redirect()->route('membresias.index')
                ->with('success', 'Membresía creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear la membresía.')
                ->withInput();
        }
    }

    /**
     * Muestra los detalles de una membresía específica
     *
     * @param int $id Identificador de la membresía a consultar
     * @return View Vista con los detalles de la membresía
     */
    public function show($id): View
    {
        $membresia = Membresia::find($id);

        return view('membresia.show', compact('membresia'));
    }

    /**
     * Muestra el formulario para editar una membresía existente
     *
     * @param int $id Identificador de la membresía a editar
     * @return View Vista con el formulario de edición
     */
    public function edit($id): View
    {
        $membresia = Membresia::find($id);

        return view('membresia.edit', compact('membresia'));
    }

    /**
     * Actualiza los datos de una membresía específica en la base de datos
     *
     * @param MembresiaRequest $request Datos del formulario de actualización
     * @param Membresia $membresia Membresía a actualizar
     * @return RedirectResponse Redirección con mensaje de éxito o error
     */
    public function update(MembresiaRequest $request, Membresia $membresia): RedirectResponse
    {
        $membresia->update($request->validated());

        return Redirect::route('membresias.index')
            ->with('success', 'Membresia updated successfully');
    }

    /**
     * Elimina una membresía específica de la base de datos
     *
     * @param int $id Identificador de la membresía a eliminar
     * @return RedirectResponse Redirección con mensaje de éxito
     */
    public function destroy($id): RedirectResponse
    {
        Membresia::find($id)->delete();

        return Redirect::route('membresias.index')
            ->with('success', 'Membresia deleted successfully');
    }
}
