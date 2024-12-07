<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Ingresos</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { margin-bottom: 20px; }
        .empresa-info { text-align: center; margin-bottom: 20px; }
        .empresa-logo { max-width: 150px; }
        .total { margin-top: 20px; text-align: right; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="empresa-info">
            @if($empresa->logo)
            <img src="{{ public_path($empresa->logo) }}" class="empresa-logo" alt="Logo">
            @endif
            <h2>{{ $empresa->nombre }}</h2>
            <p>{{ $empresa->direccion }}</p>
            <p>Tel: {{ $empresa->telefono }}</p>
            <p>RTN: {{ $empresa->rtn }}</p>
        </div>
    </div>

    <h1>Reporte de Ingresos</h1>
    <p>Período: {{ \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($fecha_fin)->format('d/m/Y') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Membresía</th>
                <th>Método Pago</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pagos as $pago)
                <tr>
                    <td>{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                    <td>{{ $pago->cliente->nombre_completo }}</td>
                    <td>
                        @foreach($pago->detalles as $detalle)
                            {{ $detalle->membresia->tipo }}<br>
                        @endforeach
                    </td>
                    <td>{{ $pago->metodo_pago }}</td>
                    <td>L. {{ number_format($pago->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p>Total Ingresos: L. {{ number_format($total, 2) }}</p>
    </div>
</body>
</html>