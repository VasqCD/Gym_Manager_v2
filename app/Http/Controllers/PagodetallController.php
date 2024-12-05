<?php

namespace App\Http\Controllers;

use App\Models\Pagodetall;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PagodetallRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PagodetallController extends Controller
{
    /**
     * La función index muestra el listado de pagodetalls
     * 
     * Obtiene los pagodetalls con sus relaciones (pago y membresia)
     * ordenados por fecha de pago de forma descendente
     * 
     * @param Request $request Objeto con los datos de la petición HTTP
     * @return View Vista con el listado de pagodetalls paginado
     */
    public function index(Request $request): View
    {
        $pagodetalls = Pagodetall::paginate();

        return view('pagodetall.index', compact('pagodetalls'))
            ->with('i', ($request->input('page', 1) - 1) * $pagodetalls->perPage());
    }

    /**
     * Muestra el formulario para registrar un nuevo pagodetall
     * 
     * @return View Vista con el formulario de creación
     */
    public function create(): View
    {
        $pagodetall = new Pagodetall();

        return view('pagodetall.create', compact('pagodetall'));
    }

    /**
     * La función store almacena un nuevo pagodetall en la base de datos
     * 
     * @param PagodetallRequest $request Objeto con los datos de la petición HTTP
     * @return RedirectResponse Redirección a la lista de pagodetalls con un mensaje de éxito
     * @throws \Illuminate\Validation\ValidationException
     * 
     */
    public function store(PagodetallRequest $request): RedirectResponse
    {
        Pagodetall::create($request->validated());

        return Redirect::route('pagodetalls.index')
            ->with('success', 'Pagodetall created successfully.');
    }

    /**
     * La función show muestra el recurso especificado por id
     * 
     * @param int $id Identificador del pagodetall a mostrar
     * @return View Vista con los datos del pagodetall
     */
    public function show($id): View
    {
        $pagodetall = Pagodetall::find($id);

        return view('pagodetall.show', compact('pagodetall'));
    }

    /**
     * La función edit muestra el formulario para editar el pagodetall especificado por id
     * 
     * @param int $id Identificador del pagodetall a editar
     * @return View Vista con el formulario de edición del pagodetall
     * 
     */
    public function edit($id): View
    {
        $pagodetall = Pagodetall::find($id);

        return view('pagodetall.edit', compact('pagodetall'));
    }

    /**
     * La función update actualiza los datos del pagodetall en la base de datos
     * 
     * @param PagodetallRequest $request Objeto con los datos de la petición HTTP
     * @param Pagodetall $pagodetall Objeto con los datos del pagodetall a actualizar
     */
    public function update(PagodetallRequest $request, Pagodetall $pagodetall): RedirectResponse
    {
        $pagodetall->update($request->validated());

        return Redirect::route('pagodetalls.index')
            ->with('success', 'Pagodetall updated successfully');
    }

    /**
     * La función destroy elimina el pagodetall especificado por id
     * 
     * @param int $id Identificador del pagodetall a eliminar
     * @return RedirectResponse Redirección a la lista de pagodetalls con un mensaje de éxito
     */
    public function destroy($id): RedirectResponse
    {
        Pagodetall::find($id)->delete();

        return Redirect::route('pagodetalls.index')
            ->with('success', 'Pagodetall deleted successfully');
    }
}
