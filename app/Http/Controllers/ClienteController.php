<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ClienteRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ClienteController extends Controller
{
    public function index(Request $request): View
    {
        $clientes = Cliente::paginate();
        return view('cliente.index', compact('clientes'))
            ->with('i', ($request->input('page', 1) - 1) * $clientes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $cliente = new Cliente();
        return view('cliente.create', compact('cliente'));
    }

    /**
     * Store a newly created resource in storage.
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
     */
    public function show($id): View
    {
        $cliente = Cliente::findOrFail($id);
        return view('cliente.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $cliente = Cliente::findOrFail($id);
        return view('cliente.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        Cliente::findOrFail($id)->delete();
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }
}
