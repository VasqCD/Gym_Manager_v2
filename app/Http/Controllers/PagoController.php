<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Pagodetall;
use App\Models\Cliente;
use App\Models\Membresia;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PagoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $pagos = Pago::with(['cliente' => function ($query) {
            $query->withTrashed();
        }, 'detalles.membresia'])
            ->orderBy('fecha_pago', 'desc')
            ->paginate();

        return view('pago.index', compact('pagos'))
            ->with('i', ($request->input('page', 1) - 1) * $pagos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $clientes = Cliente::where('estado', false)->get();
        $membresias = Membresia::all();

        return view('pago.create', compact('clientes', 'membresias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'membresia_id' => 'required|exists:membresias,id',
            'cantidad' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0',
            'descuento' => 'nullable|numeric|min:0|max:100',
            'total' => 'required|numeric|min:0'
        ]);

        try {
            DB::beginTransaction();

            $pago = Pago::create([
                'cliente_id' => $request->cliente_id,
                'fecha_pago' => now(),
                'total' => $request->total
            ]);

            $subtotal = $request->subtotal;
            $descuento = $request->aplicar_descuento ?
                ($subtotal * $request->descuento / 100) : 0;
            $subtotalConDescuento = $subtotal - $descuento;
            $impuesto = $subtotalConDescuento * 0.15;

            $pago->detalles()->create([
                'membresia_id' => $request->membresia_id,
                'cantidad' => $request->cantidad,
                'subtotal' => $subtotal,
                'descuento' => $descuento,
                'impuesto' => $impuesto
            ]);

            DB::commit();
            return redirect()->route('pagos.index')
                ->with('success', 'Pago creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error al crear el pago: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $pago = Pago::with(['cliente', 'detalles.membresia'])->findOrFail($id);
        return view('pago.show', compact('pago'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pago = Pago::with(['cliente', 'detalles.membresia'])->findOrFail($id);
        $clientes = Cliente::all();
        $membresias = Membresia::all();

        return view('pago.edit', compact('pago', 'clientes', 'membresias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PagoRequest $request, Pago $pago): RedirectResponse
    {
        $pago->update($request->validated());

        return Redirect::route('pagos.index')
            ->with('success', 'Pago actualizado correctamente');
    }

    public function destroy($id): RedirectResponse
    {
        Pago::find($id)->delete();

        return Redirect::route('pagos.index')
            ->with('success', 'El pago a sido eliminado correctamente');
    }
}
