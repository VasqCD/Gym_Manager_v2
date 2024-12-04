<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InformacionEmpresa;
use Illuminate\Support\Facades\Storage;

class InformacionEmpresaController extends Controller
{
    /**
     * Muestra la información de la empresa
     */
    public function index()
    {
        $empresa = InformacionEmpresa::first();
        return view('empresa.index', compact('empresa'));
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        //
    }

    /**
     * Almacena un nuevo recurso en la base de datos.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Muestra el recurso especificado.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(string $id)
    {
        //
    }

    public function __construct()
    {
        if (!file_exists(public_path('images/logo'))) {
            mkdir(public_path('images/logo'), 0777, true);
        }
    }

    /**
     * Actualiza los datos de la empresa en la base de datos
     */
    public function update(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:100',
            'rtn' => 'nullable|string|max:50',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'descripcion' => 'nullable|string',
            'horario' => 'nullable|string|max:100',
            'redes_sociales' => 'nullable|string|max:255'
        ]);

        $empresa = InformacionEmpresa::first();
        if (!$empresa) {
            $empresa = new InformacionEmpresa();
        }

        $empresa->fill($request->except('logo'));

        if ($request->hasFile('logo')) {
            try {
                // Eliminar logo anterior
                if ($empresa->logo && file_exists(public_path($empresa->logo))) {
                    unlink(public_path($empresa->logo));
                }

                $fileName = time() . '_' . $request->file('logo')->getClientOriginalName();
                $request->file('logo')->move(public_path('images/logo'), $fileName);

                $empresa->logo = 'images/logo/' . $fileName;
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Error al subir el logo: ' . $e->getMessage());
            }
        }

        $empresa->save();

        return redirect()->route('empresa.index')->with('success', 'Información actualizada correctamente');
    }


    /**
     * Elimina el recurso especificado de la base de datos.
     */
    public function destroy(string $id)
    {
        //
    }
}
