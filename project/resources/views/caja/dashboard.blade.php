<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Empleado de Caja</title>
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col text-center">
                <img src="{{ asset('img/logo.png') }}" alt="Logotipo de la tienda" class="img-fluid mb-3" style="max-width: 150px;">
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                @if (Session::has('empleado') && array_key_exists('codigo_sucursal', session('empleado')))
                    <h1 class="h3 text-primary">Empleado de Caja: {{ session('empleado')['nombre'] }} {{ session('empleado')['apellido'] }}</h1>
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
                <h3 class="text-primary">Productos disponibles</h3>
                <div class="row">
                    @foreach ($productos as $producto)
                        <div class="col-md-6">
                            <div class="producto-card card mb-3">
                                <img src="{{ asset('img/producto.png') }}" class="card-img-top" alt="Imagen del producto">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $producto->nombre }}</h5>
                                    <p class="card-text">Marca: {{ $producto->marca }}</p>
                                    <p class="card-text">Precio: ${{ $producto->precio }}</p>
                                    <p class="card-text">Cantidad en bodega: {{ $producto->cantidad_bodega }}</p>
                                    <p class="card-text">Cantidad en estantería: {{ $producto->cantidad_estanteria }}</p>
                                    <form action="{{ route('caja.agregar.carrito') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="codigo_producto" value="{{ $producto->codigo_producto }}">
                                        <input type="hidden" name="nombre" value="{{ $producto->nombre }}">
                                        <input type="hidden" name="precio" value="{{ $producto->precio }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Agregar al carrito</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-4">
                <h3 class="text-primary">Carrito de compras</h3>
                @if (Session::has('carrito') && count(Session::get('carrito')) > 0)
                    <ul class="list-group">
                        @foreach(Session::get('carrito') as $producto)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $producto['nombre'] }} - ${{ $producto['precio'] }} x {{ $producto['cantidad'] }}
                                <span>${{ $producto['subtotal'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <h5 class="mt-3">Total: ${{ $total }}</h5>
                    <form action="{{ route('caja.completar.compra') }}" method="GET">
                        <button type="submit" class="btn btn-success mt-3">Proceder a la compra</button>
                    </form>
                    <form action="{{ route('caja.limpiar.carrito') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning mt-3">Limpiar Carrito</button>
                    </form>                    
                @else
                    <p>No hay productos en el carrito.</p>
                @endif

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
