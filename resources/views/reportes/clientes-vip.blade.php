<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Clientes VIP</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { margin-bottom: 20px; }
        .empresa-info { text-align: center; margin-bottom: 20px; }
        .empresa-logo { max-width: 150px; }
        .reporte-titulo { text-align: center; margin: 20px 0; }
        .status-vip { color: gold; font-weight: bold; }
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
            <p>{{ $empresa->email }}</p>
            <p>RTN: {{ $empresa->rtn }}</p>
        </div>
    </div>

    <div class="reporte-titulo">
        <h1>Reporte de Clientes VIP</h1>
        <p>Fecha de generación: {{ date('d/m/Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Fecha Inicio VIP</th>
                <th>Fecha Fin VIP</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $cliente)
                @foreach($cliente->pagos as $pago)
                    @foreach($pago->detalles as $detalle)
                        @if($detalle->membresia->tipo === 'VIP')
                        <tr>
                            <td>{{ $cliente->nombre_completo }}</td>
                            <td>{{ $cliente->dni }}</td>
                            <td>{{ $cliente->telefono }}</td>
                            <td>{{ $cliente->email }}</td>
                            <td>{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                            <td>{{ $pago->fecha_pago->addDays($detalle->membresia->duracion)->format('d/m/Y') }}</td>
                            <td>{{ $pago->dias_restantes > 0 ? 'Activo' : 'Vencido' }}</td>
                        </tr>
                        @endif
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px; text-align: right;">
        <p>Total Clientes VIP: {{ $clientes->count() }}</p>
    </div>
</body>
</html>