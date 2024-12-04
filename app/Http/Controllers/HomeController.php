<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Membresia;
use App\Models\Pago;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Muestra la página de inicio del sistema
     *
     * @return \Illuminate\View\View Vista con los datos de la página de inicio
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la página de inicio del sistema
     *
     * @return \Illuminate\View\View Vista con los datos de la página de inicio
     */
    public function index(): View
    {
        // Clientes activos
        $clientesActivos = Cliente::where('estado', true)->count();

        // Membresías activas usando join
        $membresiasActivas = DB::table('pagos')
            ->join('pagodetalls', 'pagos.id', '=', 'pagodetalls.pago_id')
            ->join('membresias', 'pagodetalls.membresia_id', '=', 'membresias.id')
            ->whereRaw('DATEDIFF(NOW(), pagos.fecha_pago) <= membresias.duracion')
            ->count();

        // Ingresos del mes
        $ingresosMes = Pago::whereMonth('fecha_pago', now()->month)
            ->whereYear('fecha_pago', now()->year)
            ->sum('total');

        // Datos para gráfico de membresías
        $membresiasStats = DB::table('membresias')
            ->leftJoin('pagodetalls', 'membresias.id', '=', 'pagodetalls.membresia_id')
            ->leftJoin('pagos', 'pagodetalls.pago_id', '=', 'pagos.id')
            ->select(
                'membresias.tipo',
                DB::raw('COUNT(DISTINCT CASE
                WHEN DATEDIFF(NOW(), pagos.fecha_pago) <= membresias.duracion
                THEN pagos.id
                ELSE NULL
                END) as total_activos')
            )
            ->groupBy('membresias.id', 'membresias.tipo')
            ->get();

        $membresiasLabels = $membresiasStats->pluck('tipo')->toArray();
        $membresiasData = $membresiasStats->pluck('total_activos')->toArray();

        // Datos para gráfico de ingresos mensuales
        $ingresos = Pago::selectRaw('MONTH(fecha_pago) as mes, SUM(total) as total')
            ->whereYear('fecha_pago', date('Y'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        $ingresosData = array_fill(0, 12, 0);

        foreach ($ingresos as $ingreso) {
            $ingresosData[$ingreso->mes - 1] = (float) $ingreso->total;
        }

        return view('home', compact(
            'clientesActivos',
            'membresiasActivas',
            'ingresosMes',
            'membresiasLabels',
            'membresiasData',
            'meses',
            'ingresosData'
        ));
    }
}
