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

class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }

    public function generar(Request $request)
    {
        $tipo = $request->tipo;
        $data = [];

        // Obtener información de la empresa para todos los reportes
        $data['empresa'] = InformacionEmpresa::first();

        switch ($tipo) {
            case 'membresias-activas':
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
                $data['clientes'] = Cliente::with(['pagos.detalles.membresia'])
                    ->whereHas('pagos.detalles.membresia', function ($query) {
                        $query->where('tipo', 'VIP');
                    })->get();
                $view = 'reportes.clientes-vip';
                $titulo = 'Clientes VIP';
                break;

            case 'proximos-vencer':
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
