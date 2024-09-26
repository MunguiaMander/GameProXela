<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario - Dashboard</title>
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col text-center">
                <img src="{{ asset('img/logo.png') }}" alt="Logotipo" class="img-fluid mb-3" style="max-width: 150px;">
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                @if (Session::has('empleado') && array_key_exists('codigo_sucursal', session('empleado')))
                    <h1 class="h3 text-primary">Empleado de Inventario: {{ session('empleado')['nombre'] }} {{ session('empleado')['apellido'] }}</h1>
                    <p class="lead">Sucursal: {{ session('empleado')['codigo_sucursal'] }}</p>
                @else
                    <h1>Información del empleado no disponible</h1>
                @endif
            </div>
        </div>
    </div>

    <div class="container text-right mb-3">
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
        </form>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3 class="text-primary">Productos en Bodega</h3>
                <div class="row">
                    @foreach ($productos_bodega as $producto)
                        <div class="col-md-6">
                            <div class="producto-card card mb-3">
                                <img src="{{ asset('img/producto.png') }}" class="card-img-top" alt="Imagen del producto">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $producto->nombre }}</h5>
                                    <p class="card-text">Marca: {{ $producto->marca }}</p>
                                    <p class="card-text">Precio: ${{ $producto->precio }}</p>
                                    <p class="card-text">Cantidad en bodega: {{ $producto->cantidad_bodega }}</p>
                                    <form action="{{ route('inventario.trasladar') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="producto" value="{{ $producto->codigo_producto }}">
                                        <div class="form-group">
                                            <label for="cantidad">Cantidad a trasladar</label>
                                            <input type="number" name="cantidad" class="form-control" min="1" max="{{ $producto->cantidad_bodega }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="no_pasillo">Número de Pasillo</label>
                                            <input type="number" name="no_pasillo" class="form-control" min="1" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Trasladar a estantería</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
