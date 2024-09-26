<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
    <style>
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo-container img {
            max-width: 150px;
        }
        .form-container {
            max-width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body class="bg-gradient-primary">
    <div class="container mt-5">
        <div class="logo-container">
            <img src="{{ asset('img/logo.png') }}" alt="Logotipo" class="img-fluid">
        </div>
        <div class="card o-hidden border-0 shadow-lg my-5 form-container">
            <div class="card-body p-0">
                <div class="p-5">
                    <h1 class="h4 text-gray-900 mb-4 text-center">Registrar Primer Usuario</h1>
                    <form action="{{ route('empleado.primer.registro.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="username">Usuario</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contrase;a</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Contrase;a</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido</label>
                            <input type="text" name="apellido" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="codigo_rol">Rol</label>
                            <select name="codigo_rol" class="form-control" required>
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->codigo_rol }}">{{ $rol->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="codigo_sucursal">Sucursal</label>
                            <select name="codigo_sucursal" class="form-control" required>
                                @foreach($sucursales as $sucursal)
                                    <option value="{{ $sucursal->codigo_sucursal }}">{{ $sucursal->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_caja">Numero de Caja</label>
                            <input type="number" name="no_caja" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Registrar Usuario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
