<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Venta;
use App\DetalleVentas;
use App\User;
use App\FormaPago;
use App\Pagos;

class VentaController extends Controller
{
    //
    public function index(Request $request){

        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $ventas = Venta::join('clientes','ventas.idcliente','=','clientes.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.tipo_identificacion',
            'ventas.num_venta','ventas.fecha_venta','ventas.impuesto','ventas.total',
            'ventas.estado','clientes.nombre','users.usuario')
            ->orderBy('ventas.id', 'desc')->paginate(3);
        }
        else{
            $ventas = Venta::join('clientes','ventas.idcliente','=','clientes.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.tipo_identificacion',
            'ventas.num_venta','venta.fecha_venta','ventas.impuesto','ventas.total',
            'ventas.estado','clientes.nombre','users.usuario')
            ->where('ventas.'.$criterio, 'like', '%'. $buscar . '%')->orderBy('ventas.id', 'desc')->paginate(3);
        }
         
        return [
            'pagination' => [
                'total'        => $ventas->total(),
                'current_page' => $ventas->currentPage(),
                'per_page'     => $ventas->perPage(),
                'last_page'    => $ventas->lastPage(),
                'from'         => $ventas->firstItem(),
                'to'           => $ventas->lastItem(),
            ],
            'ventas' => $ventas
        ];
     

    }

    public function buscarVenta(Request $request){

        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $ventas = Venta::where('num_venta','=', $filtro)
        ->select('id','idcliente','num_venta','fecha_venta','impuesto')->orderBy('num_venta', 'asc')->take(1)->get();

        return ['ventas' => $ventas];
    }

    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $ventas = Venta::join('clientes','ventas.idcliente','=','clientes.id')
        ->join('users','ventas.idusuario','=','users.id')
        ->select('ventas.id','ventas.tipo_identificacion',
        'ventas.num_venta','ventas.fecha_venta','ventas.impuesto','ventas.total',
        'ventas.estado','clientes.nombre','users.usuario')
        ->where('ventas.id','=',$id)
        ->orderBy('ventas.id', 'desc')->take(1)->get();

        return ['ventas' => $ventas];
    }

    public function obtenerDetalle(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $detalles = DetalleVentas::join('productos','detalle_ventas.idproducto','=','productos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.precio','detalle_ventas.descuento',
        'productos.nombre as producto')
        ->where('detalle_ventas.idventa','=',$id)
        ->orderBy('detalle_ventas.id', 'desc')->get();

        return ['detalles' => $detalles];
        
    }

    public function selectFormaPago(Request $request){

        if (!$request->ajax()) return redirect('/');
 
        $filtro = $request->filtro;
        $formas = FormaPago::orderBy('id', 'asc')->get();
 
        return ['formas' => $formas];
        
       // if (!$request->ajax()) return redirect('/');

       // $filtro = $request->$filtro;
       // $clientes = Cliente::where('nombre', 'like', '%'. $filtro . '%')
       // ->orWhere('num_documento', 'like', '%'. $filtro . '%')
       // ->select('id','nombre','num_documento')
       // ->orderBy('nombre', 'asc')->get();

       // return ['clientes' => $clientes];
        
    }


    public function pdf(Request $request,$id){

        $ventas = Venta::join('clientes','ventas.idcliente','=','clientes.id')
        ->join('users','ventas.idusuario','=','users.id')
        ->select('ventas.id','ventas.tipo_identificacion','ventas.num_venta',
        'ventas.created_at','ventas.impuesto','ventas.total',
        'ventas.estado','clientes.nombre','clientes.tipo_documento','clientes.num_documento',
        'clientes.direccion','clientes.email','clientes.telefono','users.usuario')
        ->where('ventas.id','=',$id)
        ->orderBy('ventas.id', 'desc')->take(1)->get();

        $detalles = DetalleVentas::join('productos','detalle_ventas.idproducto','=','productos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.precio','detalle_ventas.descuento',
        'productos.id','productos.nombre as producto')
        ->where('detalle_ventas.idventa','=',$id)
        ->orderBy('detalle_ventas.id', 'desc')->get();

        $numventa=Venta::select('num_venta')->where('id',$id)->get();

        $pdf = \PDF::loadView('pdf.venta',['ventas'=>$ventas,'detalles'=>$detalles]);
        return $pdf->download('venta-'.$numventa[0]->num_venta.'.pdf');


    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now('America/Guayaquil');
 
            $ventas = new Venta();
            $ventas->idcliente = $request->idcliente;
            $ventas->idusuario = \Auth::user()->id;
            $ventas->tipo_identificacion = $request->tipo_identificacion;
            $ventas->num_venta = $request->num_venta;
            $ventas->fecha_venta = $mytime->toDateString();
            $ventas->impuesto = $request->impuesto;
            $ventas->total = $request->total;
            $ventas->estado = 'Registrado';
            $ventas->save();
            
            //Array de detalles
            $detalles = $request->data;
            
            
            //Recorro todos los elementos
 
            foreach($detalles as $a=>$det)
            {
                $detalle = new DetalleVentas();
                /*enviamos valores a las propiedades del objeto detalle*/
                /*al idcompra del objeto detalle le envio el id del objeto compra, que es el objeto que se ingresó en la tabla compras de la bd*/
                $detalle->idventa = $ventas->id;
                $detalle->idproducto = $det['idproducto'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];
                $detalle->descuento = $det['descuento'];
                $detalle->save();
            }
               

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $ventas = Venta::findOrFail($request->id);
        $ventas->estado = 'Anulado';
        $ventas->save();
    }

}
