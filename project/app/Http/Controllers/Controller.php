<?php

namespace App\Http\Controllers;

abstract class Controller
{
    private function checkAuthentication()
    {
        if (!Session::has('empleado') || Session::get('empleado')['codigo_rol'] != 3) {
            return redirect()->route('login')->with('error', 'Acceso denegado. Debes iniciar sesión como empleado de bodega.');
        }
        return null;
    }
}
