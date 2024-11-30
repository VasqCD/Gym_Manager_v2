<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura #{{ $pago->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0 auto;
            padding: 20px;
            max-width: 800px;
            font-size: 14px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 20px;
        }
        
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
        
        .empresa-info {
            margin-bottom: 20px;
            text-align: center;
            font-size: 12px;
        }
        
        .cliente-info {
            margin-bottom: 20px;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;
        }
        
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        
        .totales {
            margin-top: 20px;
            text-align: right;
            border-top: 2px solid #ddd;
            padding-top: 10px;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            text-align: center;
            color: #666;
        }
        
        .importante {
            color: #777;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        @if($empresa->logo)
            <img src="{{ public_path($empresa->logo) }}" class="logo" alt="Logo">
        @endif
        <h1>FACTURA</h1>
    </div>

    <div class="empresa-info">
        <h2>{{ $empresa->nombre }}</h2>
        <p>RTN: {{ $empresa->rtn }}</p>
        <p>{{ $empresa->direccion }}</p>
        <p>Tel: {{ $empresa->telefono }} | Email: {{ $empresa->email }}</p>
    </div>

    <div class="cliente-info">
        <table style="width:100%; border:none;">
            <tr>
                <td style="border:none;"><strong>Factura #:</strong> {{ $pago->id }}</td>
                <td style="border:none;"><strong>Fecha:</strong> {{ $pago->fecha_pago->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td style="border:none;"><strong>Cliente:</strong> {{ $pago->cliente->nombre_completo }}</td>
                <td style="border:none;"><strong>Método de Pago:</strong> {{ ucfirst($pago->metodo_pago) }}</td>
            </tr>
        </table>
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
        <table style="width:auto; float:right; border:none;">
            <tr>
                <td style="border:none; text-align:right;"><strong>Subtotal:</strong></td>
                <td style="border:none; text-align:right;">L. {{ number_format($pago->detalles->sum('subtotal'), 2) }}</td>
            </tr>
            <tr>
                <td style="border:none; text-align:right;"><strong>ISV:</strong></td>
                <td style="border:none; text-align:right;">L. {{ number_format($pago->detalles->sum('impuesto'), 2) }}</td>
            </tr>
            <tr>
                <td style="border:none; text-align:right;"><strong>Descuento:</strong></td>
                <td style="border:none; text-align:right;">L. {{ number_format($pago->detalles->sum('descuento'), 2) }}</td>
            </tr>
            <tr>
                <td style="border:none; text-align:right;"><strong>Total:</strong></td>
                <td style="border:none; text-align:right;"><strong>L. {{ number_format($pago->total, 2) }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Emitido por: {{ auth()->user()->name }} | Fecha de impresión: {{ now()->format('d/m/Y H:i:s') }}</p>
        @if($empresa->horario)
            <p class="importante">Horario de atención: {{ $empresa->horario }}</p>
        @endif
        @if($empresa->redes_sociales)
            <p>{{ $empresa->redes_sociales }}</p>
        @endif
        <p class="importante">*** Gracias por su preferencia ***</p>
    </div>
</body>
</html>