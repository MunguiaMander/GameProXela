<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - Top Sucursales</title>
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
</head>
<body class="bg-gradient-primary">

    <div class="container mt-5 text-center">
        <img src="{{ asset('img/logo.png') }}" alt="Logotipo" class="img-fluid mb-4" style="max-width: 150px;">
    </div>

    <div class="container mt-3 container-custom">
        <h2 class="text-center title">Reportes Financieros y de Ventas</h2>
        <div class="text-center my-4">
            @if (Session::has('empleado'))
                <h4 class="text-success">Administrador: {{ session('empleado')['nombre'] }} {{ session('empleado')['apellido'] }}</h4>
            @else
                <h4 class="text-danger">Información del administrador no disponible</h4>
            @endif
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <h3 class="text-primary text-center">Top 2 Sucursales con Más Ingresos</h3>
                <table class="table table-striped table-custom">
                    <thead>
                        <tr>
                            <th>Código Sucursal</th>
                            <th>Nombre Sucursal</th>
                            <th>Total Ingresos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topSucursales as $sucursal)
                            <tr>
                                <td>{{ $sucursal->codigo_sucursal }}</td>
                                <td>{{ $sucursal->nombre }}</td>
                                <td>${{ number_format($sucursal->total_ingresos, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <h3 class="text-primary text-center">Top 10 Artículos Más Vendidos</h3>
                <table class="table table-striped table-custom">
                    <thead>
                        <tr>
                            <th>Código Producto</th>
                            <th>Nombre Producto</th>
                            <th>Cantidad Vendida</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topArticulosVendidos as $articulo)
                            <tr>
                                <td>{{ $articulo->codigo_producto }}</td>
                                <td>{{ $articulo->nombre }}</td>
                                <td>{{ $articulo->cantidad_vendida }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <h3 class="text-primary text-center">Top 10 Clientes que Más Dinero han Gastado</h3>
                <table class="table table-striped table-custom">
                    <thead>
                        <tr>
                            <th>NIT Cliente</th>
                            <th>Nombre Cliente</th>
                            <th>Total Gastado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topClientes as $cliente)
                            <tr>
                                <td>{{ $cliente->nit_cliente }}</td>
                                <td>{{ $cliente->nombre }}</td>
                                <td>${{ number_format($cliente->total_gastado, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Regresar al Dashboard</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
