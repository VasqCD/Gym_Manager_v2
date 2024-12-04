<?php

namespace App\Http\Controllers;

use App\Models\Bitacoracambio;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controlador para gestionar las operaciones relacionadas con la bitácora de cambios
 * 
 * Esta clase maneja las funcionalidades de visualización y consulta de los registros
 * de la bitácora de cambios en el sistema
 * 
 * @package App\Http\Controllers
 */
class BitacoracambioController extends Controller
{
    /**
     * Muestra el listado de la bitácora de cambios
     * 
     * @param Request $request Objeto con los datos de la petición HTTP
     * @return View Vista con el listado de registros paginados
     */
    public function index(Request $request): View
    {
        $bitacoracambios = Bitacoracambio::orderBy('created_at', 'desc')->paginate();

        return view('bitacoracambio.index', compact('bitacoracambios'))
            ->with('i', ($request->input('page', 1) - 1) * $bitacoracambios->perPage());
    }

    /**
     * Muestra los detalles de un registro específico de la bitácora
     * 
     * @param int $id Identificador del registro a consultar
     * @return View Vista con los detalles del registro
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Cuando no se encuentra el registro
     */
    public function show($id): View
    {
        $bitacoracambio = Bitacoracambio::findOrFail($id);

        return view('bitacoracambio.show', compact('bitacoracambio'));
    }
}