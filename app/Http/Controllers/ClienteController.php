<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controlador para la gestión de clientes
 * 
 * Esta clase maneja todas las operaciones CRUD relacionadas con los clientes
 * del sistema, incluyendo listado, creación, actualización y eliminación
 * 
 * @package App\Http\Controllers
 */

class ClienteController extends Controller
{
    public function index(Request $request): View
    {
        $clientes = Cliente::paginate();
        return view('cliente.index', compact('clientes'))
            ->with('i', ($request->input('page', 1) - 1) * $clientes->perPage());
    }

    /**
     * Muestra el formulario para crear un nuevo cliente
     * 
     * Prepara y muestra la vista con el formulario vacío para registrar
     * un nuevo cliente en el sistema
     *
     * @return \Illuminate\View\View Vista con el formulario de creación
     */
    public function create(): View
    {
        $cliente = new Cliente();
        return view('cliente.create', compact('cliente'));
    }

    /**
     * Almacena un nuevo cliente en la base de datos
     * 
     * Valida y procesa los datos recibidos del formulario para crear
     * un nuevo registro de cliente en el sistema
     *
     * @param \Illuminate\Http\Request $request Datos del formulario de creación
     * @return \Illuminate\Http\RedirectResponse Redirección con mensaje de éxito o error
     * @throws \Illuminate\Validation\ValidationException Si los datos no pasan la validación
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:100',
            'dni' => 'required|string|max:15|unique:clientes',
            'telefono' => 'required|string|max:15',
            'direccion' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:100|unique:clientes',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|in:M,F',
            'condiciones_medicas' => 'nullable|string'
        ]);

        $request->merge([
            'fecha_registro' => now(),
            'estado' => false // Cliente inactivo por defecto
        ]);

        try {
            $cliente = Cliente::create($request->all());

            // Si la petición viene del modal de pagos
            if ($request->has('es_modal')) {
                return redirect()->route('pagos.create')
                    ->with('cliente_id', $cliente->id)
                    ->with('success', 'Cliente registrado exitosamente. Se activará al comprar una membresía.');
            }

            // Si es creación normal de cliente
            return redirect()->route('clientes.index')
                ->with('success', 'Cliente creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al registrar el cliente');
        }
    }

    /**
     * Display the specified resource.
     * 
     * Muestra los detalles de un cliente específico
     *
     * @param int $id Identificador del cliente a consultar
     * @return \Illuminate\View\View Vista con los detalles del cliente
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Cuando no se encuentra el cliente
     */
    public function show($id): View
    {
        $cliente = Cliente::findOrFail($id);
        return view('cliente.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * Muestra el formulario para editar un cliente existente
     *
     * @param int $id Identificador del cliente a editar
     * @return \Illuminate\View\View Vista con el formulario de edición
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Cuando no se encuentra el cliente
     */
    public function edit($id): View
    {
        $cliente = Cliente::findOrFail($id);
        return view('cliente.edit', compact('cliente'));
    }

    /**
     * Actualiza los datos de un cliente específico en la base de datos
     *
     * @param \Illuminate\Http\Request $request Datos del formulario de actualización
     * @param int $id Identificador único del cliente
     * @return \Illuminate\Http\RedirectResponse Redirección con mensaje de éxito o error
     * @throws \Illuminate\Validation\ValidationException Si los datos no pasan la validación
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si no se encuentra el cliente
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:100',
            'dni' => 'required|string|max:15|unique:clientes,dni,' . $id,
            'telefono' => 'required|string|max:15',
            'direccion' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:100|unique:clientes,email,' . $id,
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|in:M,F',
            'contacto_emergencia' => 'nullable|string|max:100',
            'telefono_emergencia' => 'nullable|string|max:15',
            'condiciones_medicas' => 'nullable|string'
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Elimina un cliente específico del sistema
     *
     * @param int $id Identificador único del cliente a eliminar
     * @return \Illuminate\Http\RedirectResponse Redirección con mensaje de éxito
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si no se encuentra el cliente
     */
    public function destroy($id): RedirectResponse
    {
        Cliente::findOrFail($id)->delete();
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }
}
