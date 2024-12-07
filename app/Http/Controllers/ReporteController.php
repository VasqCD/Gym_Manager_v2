<?php

namespace App\Http\Controllers;


use App\Models\Cliente;
use App\Models\Membresia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\InformacionEmpresa;
use App\Models\Pago;
use App\Models\Empleado;

/**
 * Controlador para la generación de reportes PDF del sistema.
 * 
 * Este controlador maneja la generación de diferentes tipos de reportes:
 * - Membresías activas
 * - Clientes VIP
 * - Membresías próximas a vencer
 * - Reporte de ingresos
 * - Planilla de empleados
 * 
 * @package App\Http\Controllers
 */
class ReporteController extends Controller
{
    /**
     * Muestra la vista principal para la generación de reportes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('reportes.index');
    }

    /**
     * Genera un reporte PDF según el tipo especificado.
     * 
     * @param Request $request Solicitud HTTP con los parámetros del reporte
     *     @type string $tipo Tipo de reporte a generar:
     *         - membresias-activas
     *         - clientes-vip
     *         - proximos-vencer
     *         - ingresos-mes
     *         - planilla-empleados
     *     @type string $fecha_inicio Fecha inicial para reporte de ingresos
     *     @type string $fecha_fin Fecha final para reporte de ingresos
     * 
     * @return \Illuminate\Http\Response Stream del archivo PDF generado
     * 
     * @throws \Illuminate\Validation\ValidationException Cuando las fechas son inválidas
     */
    public function generar(Request $request)
    {
        $tipo = $request->tipo;
        $data = [];

        // Obtener información de la empresa para todos los reportes
        $data['empresa'] = InformacionEmpresa::first();

        switch ($tipo) {
            case 'membresias-activas':
                /**
                 * Genera reporte de clientes con membresías vigentes
                 * Calcula la vigencia comparando la fecha de pago + duración
                 */
                $data['clientes'] = Cliente::with(['pagos' => function ($query) {
                    $query->with(['detalles' => function ($query) {
                        $query->with('membresia');
                    }]);
                }])
                    ->whereHas('pagos', function ($query) {
                        $query->whereHas('detalles', function ($query) {
                            $query->whereHas('membresia', function ($query) {
                                $query->whereRaw('DATEDIFF(CURDATE(), pagos.fecha_pago) <= membresias.duracion');
                            });
                        });
                    })
                    ->get();
                $view = 'reportes.membresias-activas';
                $titulo = 'Clientes con Membresías Activas';
                break;

            case 'clientes-vip':
                /**
                 * Genera reporte de clientes con membresías VIP.
                 */
                $data['clientes'] = Cliente::with(['pagos.detalles.membresia'])
                    ->whereHas('pagos.detalles.membresia', function ($query) {
                        $query->where('tipo', 'VIP');
                    })->get();
                $view = 'reportes.clientes-vip';
                $titulo = 'Clientes VIP';

                $pdf = PDF::loadView($view, $data);
                $pdf->setPaper('a4', 'landscape'); // Configurar orientación horizontal
                return $pdf->stream($titulo . '.pdf');
                break;

            case 'proximos-vencer':
                /**
                 * Genera reporte de membresías próximas a vencer en los próximos 7 días.
                 */
                $data['clientes'] = Cliente::with(['pagos' => function ($query) {
                    $query->with(['detalles' => function ($query) {
                        $query->with('membresia');
                    }]);
                }])
                    ->whereHas('pagos', function ($query) {
                        $query->whereHas('detalles', function ($query) {
                            $query->whereHas('membresia', function ($query) {
                                $query->whereRaw('DATEDIFF(pagos.fecha_pago + INTERVAL membresias.duracion DAY, CURDATE()) BETWEEN 0 AND 7');
                            });
                        });
                    })
                    ->get();
                $view = 'reportes.proximos-vencer';
                $titulo = 'Membresías Próximas a Vencer';
                break;

            case 'ingresos-mes':
                /**
                 * Genera reporte de ingresos entre fechas específicas
                 * @param string $fecha_inicio Fecha inicial en formato Y-m-d
                 * @param string $fecha_fin Fecha final en formato Y-m-d
                 */
                $request->validate([
                    'fecha_inicio' => 'required|date',
                    'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
                ]);

                $data['fecha_inicio'] = $request->fecha_inicio;
                $data['fecha_fin'] = $request->fecha_fin;

                $data['pagos'] = Pago::with(['detalles.membresia', 'cliente'])
                    ->whereBetween('fecha_pago', [$request->fecha_inicio, $request->fecha_fin])
                    ->get();

                $data['total'] = $data['pagos']->sum('total');

                $view = 'reportes.ingresos';
                $titulo = 'Reporte de Ingresos';
                break;

            case 'planilla-empleados':
                /**
                 * Lista todos los empleados activos ordenados por cargo.
                 */
                $data['empleados'] = Empleado::where('activo', true)
                    ->orderBy('cargo')
                    ->get();
                $view = 'reportes.planilla-empleados';
                $titulo = 'Planilla de Empleados';

                $pdf = PDF::loadView($view, $data);
                $pdf->setPaper('a4', 'landscape'); // Configurar orientación horizontal
                return $pdf->stream($titulo . '.pdf');
                break;
        }

        $pdf = PDF::loadView($view, $data);
        return $pdf->stream($titulo . '.pdf');
    }
}
