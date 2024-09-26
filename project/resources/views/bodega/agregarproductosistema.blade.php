<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto al Sistema</title>
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
                <h1 class="h3 text-primary">Agregar Producto al Sistema</h1>
                <hr class="my-4">
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('bodega.agregar.productos.sistema') }}" method="POST">
                            @csrf
                            
                            <div class="form-group">
                                <label for="nombre" class="font-weight-bold">Nombre del Producto</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre del producto" required>
                            </div>

                            <div class="form-group">
                                <label for="precio" class="font-weight-bold">Precio</label>
                                <input type="number" step="0.01" name="precio" id="precio" class="form-control" placeholder="Ingrese el precio del producto" required>
                            </div>

                            <div class="form-group">
                                <label for="descripcion" class="font-weight-bold">Descripción</label>
                                <textarea name="descripcion" id="descripcion" class="form-control" rows="3" placeholder="Ingrese una descripción del producto" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="marca" class="font-weight-bold">Marca</label>
                                <input type="text" name="marca" id="marca" class="form-control" placeholder="Ingrese la marca del producto" required>
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Agregar Producto al Sistema
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
