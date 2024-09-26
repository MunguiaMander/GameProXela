<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarjetas de Puntos</title>
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
    <div class="container mt-5">
        <div class="row">
            <div class="col text-center">
                <img src="{{ asset('img/logo.png') }}" alt="Logotipo" class="img-fluid mb-3" style="max-width: 150px;">
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <h1 class="h3 text-white">Administrador: {{ session('empleado')['nombre'] }} {{ session('empleado')['apellido'] }}</h1>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h3 class="text-center text-white">Tarjetas de Puntos</h3>

        <table class="table table-striped bg-white">
            <thead>
                <tr>
                    <th>NIT Cliente</th>
                    <th>Nombre Cliente</th>
                    <th>Categoría de Tarjeta</th>
                    <th>Total Gastado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->nit_cliente }}</td>
                        <td>{{ $cliente->nombre }}</td>
                        <td>{{ $cliente->categoria_tarjeta }}</td>
                        <td>Q{{ number_format($cliente->total_gastado, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-center mt-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Regresar al Dashboard</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
