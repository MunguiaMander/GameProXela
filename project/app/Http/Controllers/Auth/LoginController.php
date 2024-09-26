<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        $empleadoCount = DB::table('rcempleado.empleado')->count();
        if ($empleadoCount == 0) {
            return redirect()->route('empleado.primer.registro');
        }
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $empleado = DB::table('rcempleado.empleado')->where('username', $request->username)->first();   
        if($empleado && Hash::check($request->password, $empleado->password))
        {

            Session::put('empleado', [
                'id'=> $empleado->codigo_empleado,
                'nombre'=> $empleado->nombre,
                'apellido'=> $empleado->apellido,
                'codigo_rol'=> $empleado->codigo_rol,
                'codigo_sucursal'=> $empleado->codigo_sucursal,
            ]);

            $rol = DB::table('rcempleado.rol')->where('codigo_rol', $empleado->codigo_rol)->first();

            switch($rol->nombre)
            {
                case 'Administrador':               
                    return redirect()->route('admin.dashboard')->with('success', 'Bienvenido' . $empleado->nombre. ' ' . $empleado->apellido . '!');
                case 'Empleado de caja':
                    return redirect()->route('caja.dashboard')->with('success', 'Bienvenido' . $empleado->nombre. ' ' . $empleado->apellido . '!');
                case 'Empleado de bodega':
                    return redirect()->route('bodega.dashboard')->with('success', 'Bienvenido' . $empleado->nombre. ' ' . $empleado->apellido . '!');
                case 'Empleado de Inventario':
                    return redirect()->route('inventario.dashboard')->with('success', 'Bienvenido' . $empleado->nombre. ' ' . $empleado->apellido . '!');
                default:
                    return redirect()->route('login')->with('error', 'Rol no reconocido.');
            }
            
            
        }else
        {
            return back()->with('error', 'Las credenciales no son correctas');
        }

    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }

}
