<!DOCTYPE html>
<html>

<head>
    <title>Planilla de Empleados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 12px;
            /* Reducir tamaño de fuente para mejor ajuste */
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            /* Reducir padding */
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            margin-bottom: 15px;
        }

        .empresa-info {
            text-align: center;
            margin-bottom: 15px;
        }

        .empresa-logo {
            max-width: 100px;
            /* Logo más pequeño */
        }

        .reporte-titulo {
            text-align: center;
            margin: 15px 0;
        }
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

    <div class="reporte-titulo">
        <h1>Planilla de Empleados</h1>
        <p>Fecha de generación: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Cargo</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Fecha Ingreso</th>
                <th>Salario Base</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empleados as $empleado)
            <tr>
                <td>{{ $empleado->nombre_completo }}</td>
                <td>{{ $empleado->dni }}</td>
                <td>{{ $empleado->cargo }}</td>
                <td>{{ $empleado->telefono }}</td>
                <td>{{ $empleado->email }}</td>
                <td>{{ $empleado->fecha_contratacion ? $empleado->fecha_contratacion->format('d/m/Y') : 'No registrada' }}</td>
                <td style="text-align: right">L. {{ number_format($empleado->salario, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" style="text-align: right"><strong>Total Planilla:</strong></td>
                <td style="text-align: right"><strong>L. {{ number_format($empleados->sum('salario'), 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>