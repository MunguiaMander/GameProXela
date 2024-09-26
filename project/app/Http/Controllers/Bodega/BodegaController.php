<?php

namespace App\Http\Controllers\Bodega;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BodegaController extends Controller
{
    private function checkAuthentication()
    {
        if (!Session::has('empleado') || Session::get('empleado')['codigo_rol'] != 3) {
            return redirect()->route('login')->with('error', 'Acceso denegado. Debes iniciar sesión como empleado de bodega.');
        }
        return null;
    }

    public function dashboard()
    {
        $redirect = $this->checkAuthentication();
        if ($redirect) {
            return $redirect;
        }

        return view('bodega.dashboard');
    }

    public function agregarProductoSucursal()
    {
        $redirect = $this->checkAuthentication();
        if ($redirect) {
            return $redirect;
        }
        $productos = DB::table('rcpersonal.producto')->get();
        $empleado = session('empleado');
        return view('bodega.agregarproducto', ['productos' => $productos]);
    }

    public function storeProductosSucursal(Request $request)
    {

        $empleado = session('empleado');

        DB::table('rcpersonal.bodega')->insert([
            'sucursal' => $empleado['codigo_sucursal'],
            'producto' => $request->producto,
            'cantidad' => $request->cantidad
        ]);
        return redirect()->route('bodega.dashboard')->with('success', 'Producto agregado correctamente a la sucursal.');
    }


    public function eliminarProductosSucursal()
    {
        $redirect = $this->checkAuthentication();
        if ($redirect) {
            return $redirect;
        }
        $empleado = session('empleado');
        $codigo_sucursal = $empleado['codigo_sucursal'];

        $productos = DB::table('rcpersonal.bodega')
            ->join('rcpersonal.producto', 'rcpersonal.bodega.producto', '=', 'rcpersonal.producto.codigo_producto')
            ->where('rcpersonal.bodega.sucursal', $codigo_sucursal)
            ->select('rcpersonal.producto.codigo_producto', 'rcpersonal.producto.nombre', 'rcpersonal.producto.precio', 'rcpersonal.bodega.cantidad')
            ->get();
        return view('bodega.eliminarproducto', ['productos' => $productos]);
    }

    public function borrarProductoSucursal(Request $request)
    {
        $redirect = $this->checkAuthentication();
        if ($redirect) {
            return $redirect;
        }

        $empleado = session('empleado');
        $codigo_sucursal = $empleado['codigo_sucursal'];
        $codigo_producto = $request->input('producto');
        $cantidad_a_eliminar = $request->input('cantidad');

        $productoEnBodega = DB::table('rcpersonal.bodega')
            ->where('sucursal', $codigo_sucursal)
            ->where('producto', $codigo_producto)
            ->first();
            
        if ($productoEnBodega->cantidad < $cantidad_a_eliminar) {
            return redirect()->back()->with('error', 'La cantidad ingresada es mayor que la cantidad disponible en la bodega.');
        }

        $nueva_cantidad = $productoEnBodega->cantidad - $cantidad_a_eliminar;

        if ($nueva_cantidad > 0) {
            DB::table('rcpersonal.bodega')
                ->where('sucursal', $codigo_sucursal)
                ->where('producto', $codigo_producto)
                ->update(['cantidad' => $nueva_cantidad]);
        } else {
            DB::table('rcpersonal.bodega')
                ->where('sucursal', $codigo_sucursal)
                ->where('producto', $codigo_producto)
                ->delete();
        }

        return redirect()->route('bodega.dashboard')->with('success', 'Producto actualizado correctamente en la bodega.');
    }

    public function agregarProductosSistema()
    {
        $redirect = $this->checkAuthentication();
        if ($redirect) {
            return $redirect;
        }

        return view('bodega.agregarproductosistema');
    }
    
    public function storeProductoSistema(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'required|string|max:150',
            'marca' => 'required|string|max:50',
        ]);

        DB::table('rcpersonal.producto')->insert([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'marca' => $request->marca
        ]);

        return redirect()->route('bodega.dashboard')->with('success', 'Producto agregado correctamente al sistema.');
    }


}
