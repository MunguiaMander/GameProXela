<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Productos a la Sucursal</title>
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <div class="row">
            <div class="col text-center">
                <img src="{{ asset('img/logo.png') }}" alt="Logotipo de la tienda" class="img-fluid mb-3" style="max-width: 150px;">
            </div>
        </div>

        <div class="row">
            <div class="col text-center">
                <h1 class="h3 text-primary">Agregar Productos a la Sucursal</h1>
                <hr class="my-4">
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('bodega.productos.store') }}" method="POST">
                            @csrf
                            
                            <div class="form-group">
                                <label for="producto" class="font-weight-bold">Seleccione un Producto</label>
                                <select name="producto" id="producto" class="form-control" required>
                                    <option value="" disabled selected>Seleccione un producto</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->codigo_producto }}">{{ $producto->nombre }} - ${{ $producto->precio }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="cantidad" class="font-weight-bold">Cantidad</label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" required>
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Agregar Producto a la Sucursal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
