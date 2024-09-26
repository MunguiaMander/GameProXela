<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Empleado de Bodega</title>
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        
        <div class="row">
            <div class="col text-center">
                <img src="{{ asset('img/logo.png') }}" alt="Logotipo de la tienda" class="img-fluid mb-4" style="max-width: 150px;">
            </div>
        </div>

        <div class="row">
            <div class="col text-center">
                @if (Session::has('empleado') && array_key_exists('codigo_sucursal', session('empleado')))
                    <h1 class="h3 text-primary">Bienvenido a la Bodega de la Sucursal: {{ session('empleado')['codigo_sucursal'] }}</h1>
                @else
                    <h1 class="h3 text-warning">Sucursal no definida</h1>
                @endif
                <hr class="my-4">
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 offset-md-2">
                @if (Session::has('empleado'))
                    <div class="alert alert-success text-center">
                        ¡Sesión activa! Bienvenido, {{ session('empleado')['nombre'] }} {{ session('empleado')['apellido'] }}.
                    </div>
                @else
                    <div class="alert alert-danger text-center">
                        No hay ninguna sesión activa.
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col text-right">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
                </form>
            </div>
        </div>

        <div class="row justify-content-center my-4">
            <div class="col-md-8">
                @if (Session::has('empleado') && array_key_exists('codigo_sucursal', session('empleado')))
                    <div class="alert alert-info text-center">
                        <strong>¡Sucursal: {{ session('empleado')['codigo_sucursal'] }}!</strong>
                        Usuario actual: {{ session('empleado')['nombre'] }} {{ session('empleado')['apellido'] }}
                    </div>
                @else
                    <div class="alert alert-warning text-center">
                        La información de la sucursal no está disponible.
                    </div>
                @endif
            </div>
        </div>

        <div class="row justify-content-around">
            <div class="col-md-3">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title">Agregar Productos a la Sucursal</h5>
                        <a href="{{ route('bodega.agregar.producto') }}" class="btn btn-primary">Acceder</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title">Eliminar Productos de la Sucursal</h5>
                        <a href="{{ route('bodega.eliminar.productos') }}" class="btn btn-primary">Acceder</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title">Agregar Productos al Sistema</h5>
                        <a href="{{ route('bodega.agregar.productos.sistema') }}" class="btn btn-primary">Acceder</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
