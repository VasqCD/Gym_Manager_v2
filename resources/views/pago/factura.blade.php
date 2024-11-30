<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura #{{ $pago->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .cliente-info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f4f4f4; }
        .totales { margin-top: 20px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>FACTURA</h1>
        <p>Factura #: {{ $pago->id }}</p>
        <p>Fecha: {{ $pago->fecha_pago->format('d/m/Y H:i') }}</p>
    </div>

    <div class="cliente-info">
        <h3>Cliente:</h3>
        <p>{{ $pago->cliente->nombre_completo }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Membresía</th>
                <th>Cantidad</th>
                <th>Precio Unit.</th>
                <th>Subtotal</th>
                <th>Descuento</th>
                <th>ISV</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pago->detalles as $detalle)
            <tr>
                <td>{{ $detalle->membresia->tipo }}</td>
                <td>{{ $detalle->cantidad }}</td>
                <td>L. {{ number_format($detalle->membresia->costo, 2) }}</td>
                <td>L. {{ number_format($detalle->subtotal, 2) }}</td>
                <td>L. {{ number_format($detalle->descuento, 2) }}</td>
                <td>L. {{ number_format($detalle->impuesto, 2) }}</td>
                <td>L. {{ number_format($detalle->subtotal - $detalle->descuento + $detalle->impuesto, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totales">
        <h3>Total: L. {{ number_format($pago->total, 2) }}</h3>
    </div>
</body>
</html>