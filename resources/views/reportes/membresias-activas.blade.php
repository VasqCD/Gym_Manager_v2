<!DOCTYPE html>
<html>

<head>
    <title>Reporte de Membresías Activas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            margin-bottom: 10px;
            width: 100%;
            display: table;
        }

        .empresa-info {
            display: table-row;
        }

        .logo-container {
            display: table-cell;
            vertical-align: middle;
            width: 20%;
            padding-right: 15px;
        }

        .info-container {
            display: table-cell;
            vertical-align: middle;
            text-align: left;
        }

        .empresa-logo {
            max-width: 80px;
        }

        .empresa-info h2 {
            margin: 0 0 5px 0;
            font-size: 16px;
        }

        .empresa-info p {
            margin: 2px 0;
            font-size: 11px;
        }

        .reporte-titulo {
            text-align: center;
            margin: 10px 0;
            clear: both;
        }

        .reporte-titulo h1 {
            font-size: 14px;
            margin: 5px 0;
        }

        tfoot tr td {
        border-top: 2px solid #000;
        font-size: 12px;
        padding: 8px;
    }
    </style>
</head>

<body>
    <div class="header">
        <div class="empresa-info">
            <div class="logo-container">
                @if($empresa->logo)
                <img src="{{ public_path($empresa->logo) }}" class="empresa-logo" alt="Logo">
                @endif
            </div>
            <div class="info-container">
                <h2>{{ $empresa->nombre }}</h2>
                <p>{{ $empresa->direccion }} | Tel: {{ $empresa->telefono }}</p>
                <p>Email: {{ $empresa->email }} | RTN: {{ $empresa->rtn }}</p>
            </div>
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
        <tfoot>
        <tr>
            <td colspan="4" style="text-align: right; padding-right: 10px;">
                <strong>Total de Clientes Activos:</strong>
            </td>
            <td colspan="1" style="text-align: left;">
                <strong>{{ $clientes->count() }}</strong>
            </td>
        </tr>
    </tfoot>
    </table>
</body>

</html>