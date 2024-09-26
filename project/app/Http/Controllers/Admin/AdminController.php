<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class AdminController extends Controller
{
    private function checkAuthentication()
    {
        if (!Session::has('empleado') || Session::get('empleado')['codigo_rol'] != 1) {
            return redirect()->route('login')->with('error', 'Acceso denegado. Solo administradores pueden acceder.');
        }
    }   

    public function show()
    {
        $redirect = $this->checkAuthentication();
        if ($redirect) {
            return $redirect;
        }
        return view('admin.dashboard');
    } 
    
    public function verReportes()
    {
        $redirect = $this->checkAuthentication();
        if ($redirect) {
            return $redirect;
        }
        $topSucursales = DB::table('rcpersonal.top_2_sucursales')->get();

        $topArticulosVendidos = DB::table('rcpersonal.top_10_articulos')->get();

        $topClientes = DB::table('rcpersonal.top_10_clientes')->get();

        return view('admin.reportes', compact('topSucursales', 'topArticulosVendidos', 'topClientes'));
    }

    public function verTarjetas()
    {
        DB::select('SELECT asignar_tarjeta_puntos()');

        $clientes = DB::table('rccliente.vista_tarjetas_puntos')->get();
    
        return view('admin.tarjetas', compact('clientes'));
    }   
    
}
