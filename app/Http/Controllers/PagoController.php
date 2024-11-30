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
            'metodo_pago' => 'required|in:efectivo,tarjeta,transferencia',
            'observaciones' => 'nullable|string|max:500',
            'total' => 'required|numeric|min:0'
        ]);

        try {
            DB::beginTransaction();

            // Crear registro en tabla pagos
            $pago = Pago::create([
                'cliente_id' => $request->cliente_id,
                'fecha_pago' => now(),
                'total' => $request->total,
                'metodo_pago' => $request->metodo_pago,
                'observaciones' => $request->observaciones
            ]);

            // Crear registro en tabla pagodetall
            $pago->detalles()->create([
                'membresia_id' => $request->membresia_id,
                'cantidad' => $request->cantidad,
                'subtotal' => $request->subtotal,
                'descuento' => $request->descuento ?? 0,
                'impuesto' => $request->impuesto
            ]);

            // Activar cliente
            Cliente::findOrFail($request->cliente_id)
                ->update(['estado' => true]);

            DB::commit();
            return redirect()->route('pagos.index')
                ->with('success', 'Pago creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
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
    public function edit($id): View
{
    // Cargar pago con sus relaciones
    $pago = Pago::with(['cliente', 'detalles.membresia'])->findOrFail($id);
    
    // Obtener listas para los selects
    $clientes = Cliente::all();
    $membresias = Membresia::all();
    
    // Obtener el detalle del pago para acceder fácilmente en la vista
    $detalle = $pago->detalles->first();

    // Pasar datos a la vista
    return view('pago.edit', compact('pago', 'clientes', 'membresias', 'detalle'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pago $pago): RedirectResponse
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'metodo_pago' => 'required|in:efectivo,tarjeta,transferencia',
            'observaciones' => 'nullable|string|max:500',
            'total' => 'required|numeric|min:0'
        ]);

        try {
            DB::beginTransaction();

            // Actualizar tabla pagos
            $pago->update([
                'cliente_id' => $request->cliente_id,
                'total' => $request->total,
                'metodo_pago' => $request->metodo_pago,
                'observaciones' => $request->observaciones
            ]);

            // Actualizar tabla pagodetall
            $detalle = $pago->detalles->first();
            if ($detalle) {
                $detalle->update([
                    'membresia_id' => $request->membresia_id,
                    'cantidad' => $request->cantidad,
                    'subtotal' => $request->subtotal,
                    'descuento' => $request->descuento ?? 0,
                    'impuesto' => $request->impuesto
                ]);
            }

            DB::commit();
            return redirect()->route('pagos.index')
                ->with('success', 'Pago actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->withErrors(['error' => 'Error al actualizar el pago: ' . $e->getMessage()]);
        }
    }

    public function destroy($id): RedirectResponse
    {
        Pago::find($id)->delete();

        return Redirect::route('pagos.index')
            ->with('success', 'El pago a sido eliminado correctamente');
    }
}
