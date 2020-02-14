<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Compra;
use App\Venta;
use App\DetalleCompra;
use App\DetalleVentas;
use App\Producto;
use Illuminate\Http\Request;

class DashboardDetalleController extends Controller
{
    public function __invoke(Request $request)
    {

        $anio=date('Y');
        $compras=DB::table('detalle_compras')
        ->join('compras','detalle_compras.idcompra','=','compras.id')
        ->join('productos','detalle_compras.idproducto','=','productos.id')
        ->select(DB::raw('YEAR(compras.fecha_compra) as anio'),
        DB::raw('MONTH(compras.fecha_compra) as mes'),
        DB::raw('SUM(detalle_compras.cantidad * detalle_compras.precio) as total'),
        'productos.id','productos.nombre')
        ->whereYear('compras.fecha_compra',$anio)
        ->groupBy(DB::raw('YEAR(compras.fecha_compra)'),DB::raw('MONTH(compras.fecha_compra)'),'productos.id','productos.nombre')
        ->get();

        $ventas=DB::table('detalle_ventas')
        ->join('ventas','detalle_ventas.idventa','=','ventas.id')
        ->join('productos','detalle_ventas.idproducto','=','productos.id')
        ->select(DB::raw('YEAR(ventas.fecha_venta) as anio'),
        DB::raw('MONTH(ventas.fecha_venta) as mes'),
        DB::raw('SUM(detalle_ventas.cantidad * detalle_ventas.precio) as total'),
        'productos.id','productos.nombre')
        ->whereYear('ventas.fecha_venta',$anio)
        ->groupBy(DB::raw('YEAR(ventas.fecha_venta)'),DB::raw('MONTH(ventas.fecha_venta)'),'productos.id','productos.nombre')
        ->get();

    
        return ['compras'=>$compras,'ventas'=>$ventas,'anio'=>$anio];
    }
}
