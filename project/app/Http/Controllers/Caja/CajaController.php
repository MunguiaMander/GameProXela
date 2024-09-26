<?php

namespace App\Http\Controllers\Caja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CajaController extends Controller
{   
    private function checkAuthentication()
    {
        if (!Session::has('empleado') || Session::get('empleado')['codigo_rol'] != 2) {
            return redirect()->route('login')->with('error', 'Acceso denegado. Debes iniciar sesión como empleado de caja.');
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
    
        $productos = DB::table('rcpersonal.bodega')
            ->join('rcpersonal.producto', 'rcpersonal.bodega.producto', '=', 'rcpersonal.producto.codigo_producto')
            ->leftjoin('rcpersonal.estanteria', function($join){
                $join->on('rcpersonal.bodega.producto', '=', 'rcpersonal.estanteria.producto')
                    ->on('rcpersonal.bodega.sucursal', '=', 'rcpersonal.estanteria.sucursal');
            })->where('rcpersonal.bodega.sucursal', $codigo_sucursal)
                ->select(
                    'rcpersonal.producto.codigo_producto',
                    'rcpersonal.producto.nombre',
                    'rcpersonal.producto.marca',
                    'rcpersonal.producto.precio',
                    DB::raw('COALESCE(rcpersonal.bodega.cantidad, 0) as cantidad_bodega'),
                    DB::raw('COALESCE(rcpersonal.estanteria.cantidad, 0) as cantidad_estanteria')
                )->get();
    
        // Calculamos el total del carrito si existe
        $carrito = Session::get('carrito', []);
        $total = array_sum(array_map(function($producto) {
            return $producto['subtotal'];
        }, $carrito));
    
        return view('caja.dashboard', [
            'productos' => $productos,
            'carrito' => $carrito,
            'total' => $total
        ]);
    }

    public function limpiarCarrito()
    {
        Session::forget('carrito');
        return redirect()->route('caja.dashboard')->with('success', 'Carrito limpiado correctamente.');
    }        
    

    public function agregarAlCarrito(Request $request)
    {
        $producto = [
            'codigo_producto' => $request->codigo_producto,
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'cantidad' => 1,
            'subtotal' => $request->precio * 1
        ];

        $carrito = Session::get('carrito', []);
        $productoExistente = false;

        foreach ($carrito as &$item) {
            if ($item['codigo_producto'] == $producto['codigo_producto']) {
                $item['cantidad']++;
                $item['subtotal'] = $item['cantidad'] * $item['precio'];
                $productoExistente = true;
                break;
            }
        }

        if (!$productoExistente) {
            $carrito[] = $producto;
        }

        Session::put('carrito', $carrito);

        return redirect()->route('caja.dashboard')->with('success', 'Producto agregado al carrito.');
    }

    public function completarCompra()
    {
        $carrito = Session::get('carrito', []);
        $total = array_sum(array_map(function($producto) {
            return $producto['subtotal'];
        }, $carrito));
        return view('caja.compra', compact('carrito', 'total'));
    }
    
    public function procesarCompra(Request $request)
    {
        $carrito = Session::get('carrito', []);
    
        if (empty($carrito)) {
            return redirect()->back()->with('error', 'No hay productos en el carrito.');
        }
    
        $empleado = session('empleado');
        $codigo_empleado = $empleado['id'];
    
        DB::beginTransaction();
        try {
            $cliente = DB::table('rccliente.cliente')->where('nit_cliente', $request->nit_cliente)->first();
        
            if (!$cliente) {
                DB::table('rccliente.cliente')->insert([
                    'nit_cliente' => $request->nit_cliente,
                    'nombre' => $request->nombre_cliente,
                    'direccion' => $request->direccion_cliente,
                    'no_puntos' => 0
                ]);
            }
        
            $codigo_venta = DB::table('rcpersonal.venta')->insertGetId([
                'fecha' => now(),
                'subtotal' => array_sum(array_column($carrito, 'subtotal')),
                'descuento' => 0,
                'total' => array_sum(array_column($carrito, 'subtotal')),
                'nit_cliente' => $request->nit_cliente,
                'codigo_empleado' => $codigo_empleado,
            ], 'codigo_venta');
        
            foreach ($carrito as $producto) {
                DB::table('rcpersonal.detalleventa')->insert([
                    'codigo_venta' => $codigo_venta,
                    'producto' => $producto['codigo_producto'],
                    'cantidad' => $producto['cantidad']
                ]);
            }
        
            DB::commit();
        
            Session::forget('carrito');
            return redirect()->route('caja.dashboard')->with('success', 'Compra procesada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al procesar la compra: ' . $e->getMessage());
            return redirect()->route('caja.dashboard')->with('error', 'Ocurrió un error al procesar la compra.');
        }
        
    }
    

}