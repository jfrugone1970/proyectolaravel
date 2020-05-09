<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Banco;
use App\ClienteBanco;
use App\Cliente;
use App\Tarjeta;
use App\ClienteTarjeta;
use App\Pagos;
use App\User;
use App\Venta;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');

        $buscar= $request->buscarS;
        $criterio= $request->criterioS;

        if($buscar==''){

            $pago= Pagos::orderBy('id','desc')->paginate(3);

        } else{

            $pago= Pagos::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(3);
        }

         
        return[

            'pagination' => [
            'total'            => $pago->total(),
            'current_page'     => $pago->currentPage(),
            'per_page'         => $pago->perPage(),
            'last_page'        => $pago->lastPage(),
            'from'             => $pago->firstItem(),
            'to'               => $pago->lastItem(),
           
            ],

            'pago' =>$pago

        ];
       
    }

    public function pdf(Request $request, $id){

        $pagos= Pagos::where('id',$id)->orderBy('id','desc')->get();

        $cont=Pagos::where('id',$id)->count();
       
        $hoy = Carbon::now()->format('d/m/Y');

        $cliente= Pagos::select('idcliente','nombre')->where('id',$id)->get();

        $pdf= \PDF::loadView('pdf.pagos',['pagos'=>$pagos,'cont'=>$cont]);
        return $pdf->download('pagos-cliente=>'.$cliente.'Fecha=>'.$hoy.'.pdf');

      
    }



    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now('America/Guayaquil');
 
            $pagos = new Pagos();
            $pagos->factura = $request->factura;
            $pagos->tipo_pago = $request->tipo_pago;
            $pagos->idcliente = $request->idcliente;
            $pagos->nombre = $request->nombre;
            $pagos->idbanco = $request->idbanco;
            $pagos->nombre_banco = $request->nombre_banco;
            $pagos->idtarjeta = $request->idtarjeta;
            $pagos->nombre_tarjeta = $request->nombre_tarjeta;
            $pagos->valor = $request->valor;

            $pagos->save();
            
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }


}
