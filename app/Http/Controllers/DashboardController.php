<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Compra;
use App\Venta;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function __invoke(Request $request)
    {
        $anio=date('Y');
        $compras=DB::table('compras as c')
        ->select(DB::raw('MONTH(c.fecha_compra) as mes'),
        DB::raw('YEAR(c.fecha_compra) as anio'),
        DB::raw('SUM(c.total) as total'))
        ->whereYear('c.fecha_compra',$anio)
        ->groupBy(DB::raw('MONTH(c.fecha_compra)'),DB::raw('YEAR(c.fecha_compra)'))
        ->get();

        $ventas=DB::table('ventas as v')
        ->select(DB::raw('MONTH(v.fecha_venta) as mes'),
        DB::raw('YEAR(v.fecha_venta) as anio'),
        DB::raw('SUM(v.total) as total'))
        ->whereYear('v.fecha_venta',$anio)
        ->groupBy(DB::raw('MONTH(v.fecha_venta)'),DB::raw('YEAR(v.fecha_venta)'))
        ->get();

        return ['compras'=>$compras,'ventas'=>$ventas,'anio'=>$anio];


       
    }
}
