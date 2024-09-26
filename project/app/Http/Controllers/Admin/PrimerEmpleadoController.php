<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PrimerEmpleadoController extends Controller
{
    public function show()
    {

        $empleadoCount = DB::table('rcempleado.empleado')->count();

        if ($empleadoCount > 0) {
            return redirect()->route('login')->with('error', 'Ya existen empleados en el sistema.');
        }
        $roles = DB::table('rcempleado.rol')->get();
        $sucursales = DB::table('rcempleado.sucursal')->get();
        return view('admin.primero', compact('roles', 'sucursales'));
    }

    public function showAddEmpleado()
    {
        if (!Session::has('empleado') || Session::get('empleado')['codigo_rol'] != 1) {
            return redirect()->route('login')->with('error', 'Acceso denegado. Solo administradores pueden acceder.');
        }
        $empleadoCount = DB::table('rcempleado.empleado')->count();
        $roles = DB::table('rcempleado.rol')->get();
        $sucursales = DB::table('rcempleado.sucursal')->get();
        return view('admin.primero', compact('roles', 'sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'nombre' => 'required',
            'apellido' => 'required',
            'codigo_rol' => 'required|integer',
            'codigo_sucursal' => 'required|integer',
            'no_caja' => 'required|integer',
        ]);

        DB::table('rcempleado.empleado')->insert([
            'username' => $request->username,
            'password' => Hash::make($request->password), 
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'codigo_rol' => $request->codigo_rol,
            'codigo_sucursal' => $request->codigo_sucursal,
            'no_caja' => $request->no_caja
        ]);
        $empleadoCount = DB::table('rcempleado.empleado')->count();

        if ($empleadoCount > 0) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('login')->with('success', 'Primer empleado registrado correctamente. Ahora puede iniciar sesión.');
    }
}
