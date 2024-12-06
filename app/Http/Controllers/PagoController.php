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
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\InformacionEmpresa;

/**
 * Controlador para la gestión de pagos
 * 
 * Esta clase maneja todas las operaciones relacionadas con los pagos
 * de membresías, incluyendo su registro, consulta y generación de comprobantes
 * 
 * @package App\Http\Controllers
 */
class PagoController extends Controller
{
    /**
     * Muestra el listado de pagos realizados
     * 
     * Obtiene los pagos con sus relaciones (cliente y detalles de membresía)
     * ordenados por fecha de pago de forma descendente
     *
     * @param Request $request Objeto con los datos de la petición HTTP
     * @return View Vista con el listado de pagos paginado
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
     * Muestra el formulario para registrar un nuevo pago
     *
     * @return View Vista con el formulario de creación
     */
    public function create(): View
    {
        $clientes = Cliente::where('estado', false)->get();
        $membresias = Membresia::all();

        return view('pago.create', compact('clientes', 'membresias'));
    }

    /**
     * La función `store` procesa una solicitud de pago, crea registros de pago y detalles de pago,
     * activa un cliente y maneja cualquier error que pueda ocurrir.
     * 
     * @param Request request La función `store` que proporcionaste es responsable de almacenar un pago
     * registro junto con sus detalles en la base de datos. Permíteme explicar el proceso paso a paso:
     * 
     * @return RedirectResponse Si el proceso de creación de pagos es exitoso, se devuelve una respuesta de redirección a
     * la ruta 'pagos.index' con un mensaje de éxito 'Pago creado exitosamente.'
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
                'descuento' => $request->descuento_monto ?? 0,
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
     * Muestra los detalles de un pago específico
     *
     * @param int $id Identificador del pago a consultar
     * @return View Vista con los detalles del pago
     */
    public function show($id): View
    {
        $pago = Pago::with(['cliente', 'detalles.membresia'])->findOrFail($id);
        return view('pago.show', compact('pago'));
    }

    /**
     * Muestra el formulario para editar un pago
     *
     * @param int $id Identificador del pago a editar
     * @return View Vista con el formulario de edición
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
     * La función `update` en PHP actualiza el pago y los detalles del pago, manejando la validación y
     * las transacciones de la base de datos.
     * 
     * @param Request request Es un objeto que contiene los datos enviados al servidor como parte
     * de una solicitud HTTP. En este contexto, se está utilizando para recuperar y validar los datos de entrada
     * para actualizar un registro de pago.
     * @param Pago pago La función `update` que proporcionaste es responsable de actualizar un registro de pago
     * junto con sus detalles en una base de datos. Permíteme explicar los parámetros utilizados en esta función:
     * 
     * @return RedirectResponse Se devuelve una RedirectResponse. Si la operación de actualización es
     * exitosa, se redirigirá a la ruta 'pagos.index' con un mensaje de éxito. Si hay un
     * error durante el proceso de actualización, se redirigirá a la página anterior con los datos de entrada y
     * un mensaje de error que indique el problema encontrado al actualizar el pago.
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
                    'descuento' => $request->descuento_monto ?? 0,
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

    /**
     * Elimina un pago de la base de datos
     *
     * @param int $id Identificador del pago a eliminar
     * @return RedirectResponse Redirección a la lista de pagos con un mensaje de éxito
     */
    public function destroy($id): RedirectResponse
    {
        Pago::find($id)->delete();

        return Redirect::route('pagos.index')
            ->with('success', 'El pago a sido eliminado correctamente');
    }

    /**
     * Genera un comprobante de pago en formato PDF
     *
     * @param int $id Identificador del pago a facturar
     * @return un archivo Comprobante de pago en formato PDF
     */
    public function generarFactura($id)
    {
        $pago = Pago::with(['cliente', 'detalles.membresia'])->findOrFail($id);
        $empresa = InformacionEmpresa::first();
        $pdf = PDF::loadView('pago.factura', compact('pago', 'empresa'));

        return $pdf->stream("factura-{$pago->id}.pdf");
    }
}
