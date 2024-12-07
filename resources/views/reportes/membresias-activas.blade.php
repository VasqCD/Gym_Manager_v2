<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Membresías Activas</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { margin-bottom: 20px; }
        .empresa-info { text-align: center; margin-bottom: 20px; }
        .empresa-logo { max-width: 150px; }
        .reporte-titulo { text-align: center; margin: 20px 0; }
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
        <h1>Reporte de Clientes con Membresías Activas</h1>
        <p>Fecha de generación: {{ date('d/m/Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Membresía</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Días Restantes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $cliente)
                @foreach($cliente->pagos as $pago)
                    @foreach($pago->detalles as $detalle)
                        <tr>
                            <td>{{ $cliente->nombre_completo }}</td>
                            <td>{{ $detalle->membresia->tipo }}</td>
                            <td>{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                            <td>{{ $pago->fecha_pago->addDays($detalle->membresia->duracion)->format('d/m/Y') }}</td>
                            <td>{{ $pago->dias_restantes }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>