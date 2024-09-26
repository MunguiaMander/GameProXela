<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador</title>
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <img src="{{ asset('img/logo.png') }}" alt="Logotipo" class="img-fluid mb-4" style="max-width: 200px;">
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (Session::has('empleado'))
                    <div class="alert alert-success text-center">
                        ¡Sesión activa! Bienvenido Admin, {{ session('empleado')['nombre'] }} {{ session('empleado')['apellido'] }}.
                    </div>
                @else
                    <div class="alert alert-danger text-center">
                        No hay ninguna sesión activa.
                    </div>
                @endif
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 text-right">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
                </form>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100 text-center">
                    <div class="card-body">
                        <h4 class="card-title">Agregar Usuarios</h4>
                        <p class="card-text">Crear nuevos usuarios para el sistema.</p>
                        <a href="{{ route('admin.dashboard.add.empleado') }}" class="btn btn-primary">Agregar Usuario</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100 text-center">
                    <div class="card-body">
                        <h4 class="card-title">Ver Reportes</h4>
                        <p class="card-text">Acceder a reportes financieros y de ventas.</p>
                        <a href="{{ route('admin.dashboard.reportes') }}" class="btn btn-primary">Ver Reportes</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100 text-center">
                    <div class="card-body">
                        <h4 class="card-title">Administrar Tarjetas</h4>
                        <p class="card-text">Gestionar tarjetas de puntos.</p>
                        <a href="{{ route('admin.dashboard.tarjetas') }}" class="btn btn-primary">Administrar Tarjetas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
