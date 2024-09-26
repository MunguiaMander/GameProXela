<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completar Compra</title>
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
</head>
<body class="bg-gradient-primary">

    <div class="container mt-5 text-center">
        <img src="{{ asset('img/logo.png') }}" alt="Logotipo de la tienda" class="img-fluid mb-3" style="max-width: 150px;">
    </div>

    <div class="container mt-3">
        <h2 class="text-center text-white">Completar Compra</h2>

        <form action="{{ route('caja.procesar.compra') }}" method="POST">
            @csrf
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h4>Datos del Cliente</h4>
                    <div class="form-group">
                        <label for="nit_cliente">NIT del Cliente</label>
                        <input type="text" class="form-control" name="nit_cliente" id="nit_cliente" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre_cliente">Nombre</label>
                        <input type="text" class="form-control" name="nombre_cliente" id="nombre_cliente" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion_cliente">Dirección</label>
                        <input type="text" class="form-control" name="direccion_cliente" id="direccion_cliente" required>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-body">
                    <h4>Carrito</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="carrito-items">
                            @foreach($carrito as $producto)
                                <tr>
                                    <td>{{ $producto['nombre'] }}</td>
                                    <td>{{ $producto['cantidad'] }}</td>
                                    <td>${{ $producto['precio'] }}</td>
                                    <td>${{ $producto['subtotal'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h5 class="text-right">Total: ${{ $total }}</h5>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success">Procesar Compra</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
