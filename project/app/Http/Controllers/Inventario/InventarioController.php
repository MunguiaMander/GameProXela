<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class InventarioController extends Controller
{
    private function checkAuthentication()
    {
        if (!Session::has('empleado') || Session::get('empleado')['codigo_rol'] != 4) {
            return redirect()->route('login')->with('error', 'Acceso denegado. Debes iniciar sesión como empleado de inventario.');
        }
        return null;
    }

    public function dashboard()
    {
        $redirect = $this->checkAuthentication();
        if ($redirect) {
            return $redirect;
        }

        $empleado = session('empleado');
        $codigo_sucursal = $empleado['codigo_sucursal'];

        $productos_bodega = DB::table('rcpersonal.bodega')
            ->join('rcpersonal.producto', 'rcpersonal.bodega.producto', '=', 'rcpersonal.producto.codigo_producto')
            ->where('rcpersonal.bodega.sucursal', $codigo_sucursal)
            ->select(
                'rcpersonal.producto.codigo_producto',
                'rcpersonal.producto.nombre',
                'rcpersonal.producto.marca',
                'rcpersonal.producto.precio',
                'rcpersonal.bodega.cantidad as cantidad_bodega'
            )
            ->get();

        return view('inventario.dashboard', ['productos_bodega' => $productos_bodega]);
    }

    public function trasladarAEstanteria(Request $request)
    {
        $empleado = session('empleado');
        $codigo_sucursal = $empleado['codigo_sucursal'];
    
        DB::beginTransaction();
        try {
            // Verifica si el producto ya está en la estantería
            $productoEstanteria = DB::table('rcpersonal.estanteria')
                ->where('sucursal', $codigo_sucursal)
                ->where('producto', $request->input('producto'))
                ->first();
    
            if ($productoEstanteria) {
                // Si el producto ya está en la estantería, actualiza la cantidad
                DB::table('rcpersonal.estanteria')
                    ->where('sucursal', $codigo_sucursal)
                    ->where('producto', $request->input('producto'))
                    ->update([
                        'cantidad' => $productoEstanteria->cantidad + $request->input('cantidad'),
                        'no_pasillo' => $request->input('no_pasillo')
                    ]);
            } else {
                // Si no está en la estantería, inserta un nuevo registro
                DB::table('rcpersonal.estanteria')->insert([
                    'sucursal' => $codigo_sucursal,
                    'producto' => $request->input('producto'),
                    'cantidad' => $request->input('cantidad'),
                    'no_pasillo' => $request->input('no_pasillo')
                ]);
            }
    
            DB::commit();
            return redirect()->route('inventario.dashboard')->with('success', 'Producto trasladado correctamente a la estantería.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al trasladar el producto: ' . $e->getMessage());
        }
    }
        
    
    
    
}
