<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Compra;
use App\DetalleCompra;

class CompraController extends Controller
{
    //
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $compras = Compra::join('proveedores','compras.idproveedor','=','proveedores.id')
            ->join('users','compras.idusuario','=','users.id')
            ->select('compras.id','compras.tipo_identificacion',
            'compras.num_compra','compras.fecha_compra','compras.impuesto','compras.total',
            'compras.estado','proveedores.nombre','users.usuario')
            ->orderBy('compras.id', 'desc')->paginate(3);
        }
        else{
            $compras = Compra::join('proveedores','compras.idproveedor','=','proveedores.id')
            ->join('users','compras.idusuario','=','users.id')
            ->select('compras.id','compras.tipo_identificacion',
            'compras.num_compra','compras.fecha_compra','compras.impuesto','compras.total',
            'compras.estado','proveedores.nombre','users.usuario')
            ->where('compras.'.$criterio, 'like', '%'. $buscar . '%')->orderBy('compras.id', 'desc')->paginate(3);
        }
         
        return [
            'pagination' => [
                'total'        => $compras->total(),
                'current_page' => $compras->currentPage(),
                'per_page'     => $compras->perPage(),
                'last_page'    => $compras->lastPage(),
                'from'         => $compras->firstItem(),
                'to'           => $compras->lastItem(),
            ],
            'compras' => $compras
        ];
    }

    public function buscarCompra(Request $request){

        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $compras = Compra::where('num_compra','=', $filtro)
        ->select('id','idproveedor','idusuario','tipo_identificacion','num_compra','fecha_compra')->orderBy('num_compra', 'asc')->take(1)->get();

        return ['compras' => $compras];

    }

    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $compra = Compra::join('proveedores','compras.idproveedor','=','proveedores.id')
        ->join('users','compras.idusuario','=','users.id')
        ->select('compras.id','compras.tipo_identificacion',
        'compras.num_compra','compras.fecha_compra','compras.impuesto','compras.total',
        'compras.estado','proveedores.nombre','users.usuario')
        ->where('compras.id','=',$id)
        ->orderBy('compras.id', 'desc')->take(1)->get();

        return ['compra' => $compra];


    }

    public function obtenerDetalles(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $detalles = DetalleCompra::join('productos','detalle_compras.idproducto','=','productos.id')
        ->select('detalle_compras.cantidad','detalle_compras.precio','productos.nombre as producto')
        ->where('detalle_compras.idcompra','=',$id)
        ->orderBy('detalle_compras.id','desc')->get();

        return ['detalles' => $detalles];

    }

    public function pdf(Request $request,$id){

        $compras = Compra::join('proveedores','compras.idproveedor','=','proveedores.id')
        ->join('users','compras.idusuario','=','users.id')
        ->select('compras.id','compras.tipo_identificacion','compras.num_compra',
        'compras.created_at','compras.impuesto','compras.total',
        'compras.estado','proveedores.nombre','proveedores.tipo_documento',
        'proveedores.num_documento','proveedores.direccion','proveedores.email',
        'proveedores.telefono','users.usuario','users.nombre as nom_usuario')
        ->where('compras.id','=',$id)
        ->orderBy('compras.id', 'desc')->take(1)->get();

        $detalles = DetalleCompra::join('productos','detalle_compras.idproducto','=','productos.id')
        ->select('detalle_compras.cantidad','detalle_compras.precio','productos.id',
        'productos.nombre as producto','productos.stock')
        ->where('detalle_compras.id','=',$id)
        ->orderBy('detalle_compras.id', 'desc')->get();

        $numcompra=Compra::select('num_compra')->where('id',$id)->get();

        $pdf = \PDF::loadView('pdf.compra',['compras'=>$compras,'detalles'=>$detalles]);
        return $pdf->download('compra-'.$numcompra[0]->num_compra.'.pdf');



    }

    
   
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now('America/Guayaquil');
 
            $compra = new Compra();
            $compra->idproveedor = $request->idproveedor;
            $compra->idusuario = \Auth::user()->id;
            $compra->tipo_identificacion = $request->tipo_identificacion;
            $compra->num_compra = $request->num_compra;
            $compra->fecha_compra = $mytime->toDateString();
            $compra->impuesto = $request->impuesto;
            $compra->total = $request->total;
            $compra->estado = 'Registrado';
            $compra->save();
            
            //Array de detalles
            $detalles = $request->data;
            
            
            //Recorro todos los elementos
 
            foreach($detalles as $a=>$det)
            {
                $detalle = new DetalleCompra();
                /*enviamos valores a las propiedades del objeto detalle*/
                /*al idcompra del objeto detalle le envio el id del objeto compra, que es el objeto que se ingresó en la tabla compras de la bd*/
                $detalle->idcompra = $compra->id;
                $detalle->idproducto = $det['idproducto'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];          
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
        $compra = Compra::findOrFail($request->id);
        $compra->estado = 'Anulado';
        $compra->save();
    }
}
